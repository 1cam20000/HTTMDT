@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Đơn hàng #{{ $order->id }}</h3>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'N/A' }}</p>
  <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0) }} VNĐ</p>
  <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
  <p><strong>Thanh toán:</strong> {{ $order->payment_method }}</p>
  <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

  <h5 class="mt-4">Sản phẩm</h5>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Sản phẩm</th>
          <th>Số lượng</th>
          <th>Đơn giá</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product->name ?? ('#'.$item->product_id) }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{{ number_format($item->price, 0) }} VNĐ</td>
          <td>{{ number_format($item->price * $item->quantity, 0) }} VNĐ</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <form class="mt-3" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row g-2 align-items-center">
      <div class="col-auto">
        <label for="status" class="col-form-label">Cập nhật trạng thái:</label>
      </div>
      <div class="col-auto">
        <select name="status" id="status" class="form-select">
          <option value="processing" @selected($order->status==='processing')>Processing</option>
          <option value="paid"       @selected($order->status==='paid')>Paid</option>
          <option value="cancelled"  @selected($order->status==='cancelled')>Cancelled</option>
        </select>
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" type="submit">Lưu</button>
      </div>
    </div>
  </form>
</div>
@endsection
