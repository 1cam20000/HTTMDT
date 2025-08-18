@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trang quản trị Admin</h2>
    <p>Xin chào, {{ Auth::user()->name }}</p>
</div>
@endsection
