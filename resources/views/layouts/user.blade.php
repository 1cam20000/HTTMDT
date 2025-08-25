<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shop Váy Công Sở - @yield('title', 'Trang người dùng')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .nav-link-btn {
      background: none;
      border: none;
      padding: 0;
      margin: 0;
      color: #007bff;
      cursor: pointer;
    }

    .nav-link-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <a class="navbar-brand" href="{{ route('welcome') }}">Shop váy công sở</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarUser">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('user.products.index') }}">🛍️ Sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.cart.index') }}">🛒 Giỏ hàng</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.orders.index') }}">📜 Đơn hàng của tôi</a></li>
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
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
        @endauth
      </ul>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-4">
    @yield('content')
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
