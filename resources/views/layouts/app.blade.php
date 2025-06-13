<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('book-icon.png') }}?v=2" type="image/png">
    <title>My Bookstore - @yield('title')</title>

    <!-- ========================================================== -->
    <!-- 📌 FONT AWESOME FOR ICONS -->
    <!-- ========================================================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* ========================================================== */
        /* 🌟 GENERAL BODY STYLING */
        /* ========================================================== */
        body {
    background: url('{{ asset("images/allinone.jpg") }}') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

        /* ========================================================== */
        /* 🌟 NAVIGATION BAR - Neon Glass Effect */
        /* ========================================================== */
        .navbar {
            display: flex;
            justify-content: space-between; /* Aligns logo on left & links on right */
            align-items: center;
            background: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Blurring background behind navbar */
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(0, 255, 255, 0.5); /* Neon blue border */
        }

        /* ========================================================== */
        /* 🌟 STORE TITLE IN NAVBAR */
        /* ========================================================== */
        .navbar h1 {
            margin: 0;
            font-size: 1.8em;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .navbar h1 i {
            margin-right: 10px; /* Space between icon and text */
        }

        /* ========================================================== */
        /* 🌟 NAVIGATION LINKS */
        /* ========================================================== */
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            position: relative; /* For positioning the red line */
            transition: color 0.3s ease;
        }

        /* 🌟 Navbar Link Hover Effect */
        .navbar a:hover {
            color: #d3cfcf;
        }

        /* Red line effect on hover */
        .navbar a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: red;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        .navbar a:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* ========================================================== */
        /* 🌟 FOOTER STYLING - Neon Glass Effect */
        /* ========================================================== */
        .footer {
            text-align: center;
            background: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Blurring background behind footer */
            color: white;
            padding: 10px;
            position: relative;
            margin-top: 20px; /* Ensures footer has space above */
            border-radius: 10px;
            border: 2px solid rgba(0, 255, 255, 0.5); /* Neon blue border */
        }

        /* ========================================================== */
        /* 🌟 CART COUNT STYLING */
        /* ========================================================== */
        .cart-link {
            position: relative;
        }

        .cart-count {
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            padding: 3px 7px;
            position: absolute;
            top: -8px;
            right: -12px;
        }

        /* ========================================================== */
        /* 🌟 LOGOUT BUTTON STYLING */
        /* ========================================================== */
        .logout-button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        /* ========================================================== */
        /* 🌟 PAGE CONTENT */
        /* ========================================================== */
        .content {
            padding: 20px;
        }
    </style>

    <!-- Yield custom styles from individual pages -->
    @yield('styles')
</head>
<body>
    <!-- Include Font Awesome again if needed -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- ========================================================== -->
    <!-- 🌟 NAVBAR SECTION -->
    <!-- ========================================================== -->
    <div class="navbar">
        <h1><i class="fas fa-book"></i> My Bookstore</h1> <!-- 📚 Added Book Icon -->

        <!-- ========================================================== -->
        <!-- 🌟 NAVIGATION LINKS -->
        <!-- ========================================================== -->
        <div>
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
            <a href="{{ route('products.list') }}"><i class="fas fa-store"></i> Shop</a>

            <!-- ========================================================== -->
            <!-- 🌟 CART LINK WITH DYNAMIC COUNT -->
            <!-- ========================================================== -->
            <a href="{{ route('cart.view') }}" class="cart-link">
                🛒 Cart <span class="cart-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>

            <!-- ========================================================== -->
            <!-- 🌟 USER AUTHENTICATION LINKS -->
            <!-- ========================================================== -->
            @if(auth()->check())
                <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profile</a>

                <!-- ========================================================== -->
                <!-- 🌟 LOGOUT BUTTON FORM -->
                <!-- ========================================================== -->
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
            @endif
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- 🌟 DYNAMIC PAGE CONTENT -->
    <!-- ========================================================== -->
    <div class="content">
        @yield('content') <!-- Page-specific content will be inserted here -->
    </div>

    <!-- ========================================================== -->
    <!-- 🌟 FOOTER SECTION -->
    <!-- ========================================================== -->
    <div class="footer">
        <p>&copy; 2025 MyBookstore | Designed for Book Lovers 📖</p>
    </div>

    <!-- Yield custom scripts from individual pages -->
    @yield('scripts')
</body>
</html>
