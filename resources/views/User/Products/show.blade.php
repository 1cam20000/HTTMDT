@extends('layouts.user')

@section('content')
<div class="container">
    <h2>{{ $product->name }}</h2>
    @if($product->image)
        <img src="{{ asset($product->image) }}" width="200" class="mb-3">
    @endif
    <p><strong>Mô tả:</strong> {{ $product->description }}</p>
    <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
    <p><strong>Giá:</strong> {{ number_format($product->price) }} VNĐ</p>
    <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
