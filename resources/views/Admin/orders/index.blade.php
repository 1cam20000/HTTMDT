@extends('layouts.app')

@section('content')
<div class="container">
  <h3>Quản lý đơn hàng</h3>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Mã đơn</th>
          <th>Khách hàng</th>
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
          <td>{{ $order->user->name ?? 'N/A' }}</td>
          <td>{{ number_format($order->total, 0) }} VNĐ</td>
          <td>{{ ucfirst($order->status) }}</td>
          <td>{{ $order->payment_method }}</td>
          <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
          <td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.show', $order) }}">Xem</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $orders->links() }}
</div>
@endsection
