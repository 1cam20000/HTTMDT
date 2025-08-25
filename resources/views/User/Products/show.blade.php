@extends('layouts.user')


<title>Products</title>

@section('content')
<div class="container">
    <h2>Chi tiết sản phẩm</h2>
    <a class="btn btn-primary" href="{{ route('admin.products.index') }}">Quay lại</a>

    <div class="form-group mt-3">
        <strong>Tên váy:</strong> {{ $product->name }}
    </div>

    <div class="form-group">
        <strong>Mô tả:</strong> {{ $product->description }}
    </div>

    <div class="form-group">
        <strong>Số lượng:</strong> {{ $product->quantity }}
    </div>

    <div class="form-group">
        <strong>Giá bán (VNĐ):</strong> {{ $product->price }}
    </div>

    <div class="form-group">
        <strong>Kích cỡ:</strong> {{ $product->size }}
    </div>

    <div class="form-group">
        <strong>Màu sắc:</strong> {{ $product->color }}
    </div>

    <div class="form-group">
        <strong>Danh mục:</strong> {{ $product->category ? $product->category->name : 'Chưa có danh mục' }}
    </div>
    <div class="form-group">
        <strong>Hình ảnh:</strong>
        @if($product->image)
            <img src="{{ asset($product->image) }}" width="150">
        @else
            <span>Không có ảnh</span>
        @endif
    </div>

    <form action="{{ route('user.cart.add', $product->id) }}" method="POST" class="mt-3">
        @csrf
        {{-- <input type="hidden" name="product_id" value="{{ $product->id }}"> --}}
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" style="width:60px;">
        <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
    </form>
</div>
@endsection
