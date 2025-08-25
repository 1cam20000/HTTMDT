<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $items = $cart ? $cart->items()->with('product')->get() : collect();
        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return view('user.cart.index', compact('items', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ
     * Route: POST /user/cart/add/{product}  -> name: user.cart.add
     * Lấy {product} bằng route model binding
     */
    public function add(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);
        if ($qty < 1) $qty = 1;

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('user.cart.index')->with('success', 'Đã thêm vào giỏ hàng.');
    }

    /**
     * Cập nhật số lượng 1 item trong giỏ
     * Route: PATCH /user/cart/{id}  -> name: user.cart.update
     * $id là product_id trong giỏ (key của mảng session)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'quantity.min'      => 'Số lượng tối thiểu là 1.'
        ]);

        $item = CartItem::find($id);
        if (!$item) {
            return redirect()->route('user.cart.index')->with('error', 'Sản phẩm không có trong giỏ.');
        }
        $item->quantity = (int)$request->quantity;
        $item->save();
        return redirect()->route('user.cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    /**
     * Xoá 1 sản phẩm khỏi giỏ
     * Route: DELETE /user/cart/remove/{product}  -> name: user.cart.remove
     */
    public function remove(Product $product)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $item = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
            if ($item) {
                $item->delete();
                return redirect()->route('user.cart.index')->with('success', 'Đã xoá sản phẩm khỏi giỏ.');
            }
        }
        return redirect()->route('user.cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ.');
    }

    /**
     * Xoá toàn bộ giỏ
     * Route: DELETE /user/cart/clear  -> name: user.cart.clear
     */
    public function clear()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cart->items()->delete();
        }
        return redirect()->route('user.cart.index')->with('success', 'Đã xoá toàn bộ giỏ hàng.');
    }
}
