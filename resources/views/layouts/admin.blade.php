<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel – @yield('title')</title>
  <link rel="icon" href="{{ asset('book-icon.png') }}?v=2" type="image/png">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  @yield('styles')

  <!-- 🌈 Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      color: #f8f9fa;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background: rgba(255, 255, 255, 0.05);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      transition: width 0.3s;
      z-index: 1000;
      box-shadow: 2px 0 30px rgba(0, 0, 0, 0.3);
    }

    .sidebar .menu a {
      display: flex;
      align-items: center;
      padding: 1rem 1.2rem;
      color: #e0f7fa;
      text-decoration: none;
      transition: background 0.2s, transform 0.2s;
    }

    .sidebar .menu a:hover {
      background: rgba(255, 255, 255, 0.08);
      transform: scale(1.03);
    }

    .sidebar .menu a i {
      font-size: 1.25rem;
      text-shadow: 0 0 6px rgba(0, 255, 255, 0.4);
    }

    .sidebar .menu a span {
      margin-left: 1rem;
      white-space: nowrap;
      font-weight: 600;
      text-shadow: 0 0 4px rgba(255, 255, 255, 0.1);
    }

    .sidebar-collapsed .sidebar {
      width: 80px;
    }

    .sidebar-collapsed .sidebar .menu a span {
      display: none;
    }

    .sidebar-collapsed .sidebar .menu a {
      justify-content: center;
    }

    /* Main content */
    .main {
      margin-left: 250px;
      transition: margin-left 0.3s;
      padding: 2rem;
    }

    .sidebar-collapsed .main {
      margin-left: 80px;
    }

    /* Toggle button */
    #toggleBtn {
      background: none;
      border: none;
      font-size: 1.5rem;
      width: 100%;
      text-align: right;
      padding: 1rem;
      color: #ffffffcc;
      cursor: pointer;
    }

    #toggleBtn:hover {
      color: #00d4ff;
      text-shadow: 0 0 10px rgba(0, 212, 255, 0.6);
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <button id="toggleBtn"><i class="bi bi-list"></i></button>
    <div class="menu">
      <a href="{{ route('admin.dashboard') }}">
        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
      </a>
      <a href="{{ route('admin.products.index') }}">
        <i class="bi bi-book"></i><span>Products</span>
      </a>
      <a href="{{ route('admin.orders.index') }}">
        <i class="bi bi-cart4"></i><span>Orders</span>
      </a>
      <a href="{{ route('admin.users') }}">
        <i class="bi bi-people"></i><span>Users</span>
      </a>
      <a href="{{ route('admin.reviews.index') }}">
        <i class="bi bi-star-fill"></i><span>Reviews</span>
      </a>
      <a class="nav-link" href="{{ route('admin.import.form') }}" >
        <i class="bi bi-upload"></i>
        <span style="margin-left: 1rem; white-space: nowrap;">Import Books</span>
      </a>


      <!-- ✅ Logout Link with Hidden Form -->
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i><span>Logout</span>
      </a>
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

    </div>
  </div>

  <div class="main">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  @yield('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btn = document.getElementById('toggleBtn');
      btn.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-collapsed');
      });
    });
  </script>
</body>
</html>
