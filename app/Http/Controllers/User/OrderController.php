<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Danh sách đơn của chính user
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    // (Tuỳ chọn) Xem chi tiết một đơn
    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $order->load('items.product');
        return view('user.orders.show', compact('order'));
    }

    // Đặt hàng từ giỏ (session)
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:COD,online'
        ]);

        $user = Auth::user();
        $cart = \App\Models\Cart::where('user_id', $user->id)->first();
        $items = $cart ? $cart->items()->with('product')->get() : collect();
        if ($items->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Tính tổng tiền theo server — không nhận total từ client
        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id'        => Auth::id(),
                'total'          => $total,
                'status'         => 'processing',
                'payment_method' => $request->payment_method,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->price,
                ]);
            }

            // Xoá giỏ hàng database sau khi đặt
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('user.orders.index')->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('user.cart.index')->with('error', 'Có lỗi khi đặt hàng. Vui lòng thử lại.');
        }
    }
}
