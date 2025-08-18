@extends('layouts.app')
<title>Products</title>

@section('content')
<div class="container">
    <h2>Chỉnh sửa sản phẩm</h2>
    <a class="btn btn-primary" href="{{ route('admin.products.index') }}">Quay lại</a>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <strong>Tên váy:</strong>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control">
        </div>

        <div class="form-group">
            <strong>Mô tả:</strong>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <strong>Số lượng:</strong>
            <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control">
        </div>

        <div class="form-group">
            <strong>Giá bán (VNĐ):</strong>
            <input type="text" name="price" value="{{ $product->price }}" class="form-control">
        </div>

        <div class="form-group">
            <strong>Kích cỡ:</strong>
            <input type="text" name="size" value="{{ $product->size }}" class="form-control">
        </div>

        <div class="form-group">
            <strong>Màu sắc:</strong>
            <input type="text" name="color" value="{{ $product->color }}" class="form-control">
        </div>

        <div class="form-group">
            <strong>Danh mục:</strong>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <strong>Hình ảnh:</strong>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <img src="{{ asset($product->image) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
    </form>
</div>
@endsection