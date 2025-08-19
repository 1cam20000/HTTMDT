@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Xác thực email</h3>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <p>Vui lòng kiểm tra email của bạn để xác thực tài khoản.</p>
    <p>Nếu chưa nhận được email, bạn có thể yêu cầu gửi lại:</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Gửi lại email xác thực</button>
    </form>
</div>
@endsection
