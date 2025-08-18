@extends('layouts.app')
<title>Products</title>
@section('content')

<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <a class="btn btn-primary" href="{{ route('admin.products.index') }}">Quay lại</a>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <strong>Tên váy:</strong>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <strong>Mô tả:</strong>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <strong>Số lượng:</strong>
            <input type="number" name="quantity" class="form-control">
        </div>
        <div class="form-group">
            <strong>Giá bán (VNĐ):</strong>
            <input type="text" name="price" class="form-control">
        </div>
        <div class="form-group">
            <strong>Kích cỡ:</strong>
            <input type="text" name="size" class="form-control">
        </div>
        <div class="form-group">
            <strong>Màu sắc:</strong>
            <input type="text" name="color" class="form-control">
        </div>
        <div class="form-group">
            <strong>Danh mục:</strong>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <strong>Hình ảnh:</strong>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mt-2">Lưu</button>
    </form>
</div>
@endsection