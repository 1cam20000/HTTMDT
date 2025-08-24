<!-- Layout user đã được load -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shop ban vay'</title>
  
  <!-- Bootstrap 4 CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Shop váy công sở</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.categories.index') }}">📂 Danh mục</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.cart.index') }}">🛒 Giỏ hàng</a></li>
        @auth
          <li class="nav-item">
            <span class="nav-link">👋 Xin chào, {{ Auth::user()->name }}</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
              @csrf
            </form>
          </li>
        @endauth
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Đăng ký</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
        @endguest
      </ul>
    </div>
  </nav>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      </ul>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-4">
    @yield('content')
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-XUZDqKHgRuGgE58dXc9RtUg+KXG9CvylZulZz6KM99ZoNkJgkHyk0zVpO+93tr9U" 
          crossorigin="anonymous"></script>
</body>
</html>