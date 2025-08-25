@extends('layouts.user')
@section('content')
<div class="container">
    <h2>Danh mục sản phẩm</h2>
    <ul class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item">
                {{ $category->name }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
