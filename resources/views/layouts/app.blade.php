<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quản trị - @yield('title', 'MyShop Admin')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Shop váy công sở – Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">🏠 Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.products.index') }}">👗 Quản lý Sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.categories.index') }}">📂 Quản lý Danh mục</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.orders.index') }}">📦 Quản lý Đơn hàng</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        @auth
          <li class="nav-item">
            <span class="nav-link">👋 Xin chào, {{ Auth::user()->name }}</span>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-link nav-link">🚪 Đăng xuất</button>
            </form>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
        @endauth
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    @yield('content')
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
