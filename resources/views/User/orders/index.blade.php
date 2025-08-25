@extends('layouts.user')

@section('content')
<div class="container">
  <h3>📦 Đơn hàng của bạn</h3>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  @if($orders->count())
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Mã đơn</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Ngày tạo</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ number_format($order->total, 0) }} VNĐ</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->payment_method }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>
              {{-- Nếu có trang chi tiết --}}
              {{-- <a class="btn btn-sm btn-outline-primary" href="{{ route('user.orders.show', $order) }}">Xem</a> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $orders->links() }}
  @else
    <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <a href="{{ route('user.products.index') }}" class="btn btn-primary">Bắt đầu mua sắm</a>
  @endif
</div>
@endsection
