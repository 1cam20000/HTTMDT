@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm</h2>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="card mb-3">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5>{{ $product->name }}</h5>
                        <p>{{ number_format($product->price) }} VNĐ</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $products->links() }}
</div>
@endsection
