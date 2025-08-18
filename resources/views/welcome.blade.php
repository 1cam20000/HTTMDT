@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Chào mừng đến cửa hàng Váy công sở</h1>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="Ảnh sản phẩm">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product->price, 0) }} VNĐ</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection