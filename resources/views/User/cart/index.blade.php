@extends('layouts.user')

@section('content')
<div class="container">
  <h3 class="mb-3">🛒 Giỏ hàng của bạn</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if($items->count() > 0)
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th class="text-center" style="width:140px;">Số lượng</th>
            <th class="text-end">Giá</th>
            <th class="text-end">Thành tiền</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
            @php
              $product = $item->product;
              $price = (float)$item->price;
              $qty   = (int)$item->quantity;
              $sub   = $price * $qty;
            @endphp
            <tr>
              <td style="width:80px;">
                @if(!empty($product->image))
                  <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width:70px;height:70px;object-fit:cover;">
                @else
                  <div class="text-muted">No image</div>
                @endif
              </td>
              <td>{{ $product->name ?? 'Sản phẩm' }}</td>
              <td>{{ $product->category->name ?? '-' }}</td>
              <td class="text-center">
                <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <input type="number" name="quantity" value="{{ $qty }}" min="1" class="form-control d-inline" style="width:80px;">
                  <button type="submit" class="btn btn-sm btn-secondary mt-1">Cập nhật</button>
                </form>
              </td>
              <td class="text-end">{{ number_format($price, 0) }} VNĐ</td>
              <td class="text-end">{{ number_format($sub, 0) }} VNĐ</td>
              <td class="text-center">
                <form action="{{ route('user.cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Xoá sản phẩm này?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-3">
      <a href="{{ route('user.products.index') }}" class="btn btn-outline-primary">⬅️ Tiếp tục mua sắm</a>

      <div class="text-end">
        <h5 class="mb-3">Tổng tiền: <strong>{{ number_format($total, 0) }} VNĐ</strong></h5>

        <form action="{{ route('user.cart.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá toàn bộ giỏ hàng?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-outline-danger me-2">🧹 Xoá giỏ hàng</button>
        </form>

        {{-- Form đặt hàng (Lab05) --}}
        <form action="{{ route('user.orders.store') }}" method="POST" class="mt-3">
          @csrf
          <div class="row g-2 align-items-center">
            <div class="col-auto">
              <label for="payment_method" class="col-form-label">Phương thức thanh toán:</label>
            </div>
            <div class="col-auto">
              <select name="payment_method" id="payment_method" class="form-select">
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="online">Thanh toán trực tuyến</option>
              </select>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-success">Đặt hàng</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  @else
    <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
    <a href="{{ route('user.products.index') }}" class="btn btn-primary">Bắt đầu mua sắm</a>
  @endif
</div>
@endsection
