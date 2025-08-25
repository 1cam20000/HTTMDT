<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0.0;

        foreach ($cart as $row) {
            $price = (float) ($row['price'] ?? 0);
            $qty   = (int)   ($row['quantity'] ?? 0);
            $total += $price * $qty;
        }

        // View đúng thư mục user/cart
        return view('user.cart.index', compact('cart', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ
     * Route: POST /user/cart/add/{product}  -> name: user.cart.add
     * Lấy {product} bằng route model binding
     */
    public function add(Request $request, Product $product)
    {
        // Nếu không truyền quantity thì mặc định là 1
        $qty = (int) $request->input('quantity', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'price'    => (float)$product->price,
                'quantity' => $qty,
                'category' => optional($product->category)->name,
                'image'    => $product->image,
            ];
        }

        session()->put('cart', $cart);

        // Chuyển đến trang giỏ hàng và hiển thị thông báo thành công
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

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('user.cart.index')->with('error', 'Sản phẩm không có trong giỏ.');
        }

        $cart[$id]['quantity'] = (int)$request->quantity;
        session()->put('cart', $cart);

        return redirect()->route('user.cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    /**
     * Xoá 1 sản phẩm khỏi giỏ
     * Route: DELETE /user/cart/remove/{product}  -> name: user.cart.remove
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return redirect()->route('user.cart.index')->with('success', 'Đã xoá sản phẩm khỏi giỏ.');
        }

        return redirect()->route('user.cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ.');
    }

    /**
     * Xoá toàn bộ giỏ
     * Route: DELETE /user/cart/clear  -> name: user.cart.clear
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('user.cart.index')->with('success', 'Đã xoá toàn bộ giỏ hàng.');
    }
}
