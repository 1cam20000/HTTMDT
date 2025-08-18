@extends('layouts.app')
<title>Products</title>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Danh sách Sản phẩm</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">Thêm sản phẩm mới</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success"><p>{{ $message }}</p></div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Mã SP</th>
            <th>Tên váy</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Giá bán</th>
            <th>Kích cỡ</th>
            <th>Màu sắc</th>
            <th>Hình ảnh</th>
            <th width="280px">Hành động</th>
            
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->size }}</td>
            <td>{{ $product->color }}</td>
            <td>
                @if($product->image)
                    <img src="{{ asset($product->image) }}" width="60">
                @else
                    <span>Không có</span>
                @endif
            </td>
            <td>
                <a class="btn btn-info" href="{{ route('admin.products.show',$product->id) }}">Xem</a>
                <a class="btn btn-primary" href="{{ route('admin.products.edit',$product->id) }}">Sửa</a>
                <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
            
        </tr>
        @endforeach
    </table>
</div>
@endsection