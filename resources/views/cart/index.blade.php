@extends('layouts.user')
@section('content')
<div class="container">
    <h2>Giỏ hàng của bạn</h2>
    <table class="table table-bordered">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
        </tr>
        @forelse($cart as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>
                @if($item['image'])
                    <img src="{{ asset($item['image']) }}" width="80">
                @endif
            </td>
            <td>{{ number_format($item['price']) }} VNĐ</td>
            <td>
                <form action="{{ route('user.cart.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:60px;">
                    <button type="submit" class="btn btn-sm btn-warning">Cập nhật</button>
                </form>
            </td>
            <td>{{ number_format($item['price'] * $item['quantity']) }} VNĐ</td>
            <td>
                <form action="{{ route('user.cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Giỏ hàng trống</td>
        </tr>
        @endforelse
    </table>
    <h4>Tổng tiền: {{ number_format($total) }} VNĐ</h4>
    <a href="/user/products" class="btn btn-primary">Tiếp tục mua hàng</a>
</div>
@endsection
