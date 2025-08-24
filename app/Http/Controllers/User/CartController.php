<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image
            ];
        }
        session(['cart' => $cart]);
        return redirect()->route('user.cart.index');
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->product_id;
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }
        return redirect()->route('user.cart.index');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->product_id;
        unset($cart[$productId]);
        session(['cart' => $cart]);
        return redirect()->route('user.cart.index');
    }
}
