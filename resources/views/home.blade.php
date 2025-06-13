<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Set character encoding -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive viewport -->
  <title>Bookstore - Home</title><link rel="icon" href="{{ asset('book-icon.png') }}?v=2" type="image/png">
  <!-- Include Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Basic body styling */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      line-height: 1.6;
    }

    /* Navbar styling */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #2C3E50;
      padding: 15px 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .navbar h1 {
      margin: 0;
      font-size: 1.8em;
      color: #fff;
    }
    .navbar a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      position: relative;
      transition: color 0.3s ease;
    }
    .navbar a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background-color: red;
      bottom: -5px;
      left: 0;
      transition: width 0.3s ease;
    }
    .navbar a:hover::after {
      width: 100%;
    }

    /* Hero section styling */
    .header {
      text-align: center;
      padding: 50px;
      background: url('{{ asset("images/home-bg.jpg") }}') no-repeat center center / cover;
      color: rgba(0, 0, 0, 0.75);
    }
    .header h2 {
      font-size: 2.5em;
      margin-bottom: 10px;
    }
    .header p {
      font-size: 1.2em;
    }

    /* Search bar styling */
    .search-bar {
      display: flex;
      justify-content: center;
      margin: 20px 0;
    }
    .search-bar input[type="text"] {
      padding: 10px;
      width: 300px;
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 1em;
    }
    .search-bar button {
      padding: 10px 15px;
      background-color: #2C3E50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 1em;
      margin-left: 5px;
    }
    .search-bar button:hover {
      background-color: #1A252F;
    }

    /* Product grid styling */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 30px;
      padding: 20px;
    }
    @media (max-width: 1200px) {
      .product-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }
    @media (max-width: 768px) {
      .product-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    /* Product card styling */
    .product-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .price {
      font-size: 1.5em;
      color: #D35400;
    }
    .btn {
      background-color: #0080ff;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 15px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 1em;
    }
    .btn:hover {
      transform: translateY(-2px);
    }

    /* Pagination container styling */
    .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
    }
    .pagination a {
      color: #2C3E50;
      background-color: #fff;
      padding: 10px 15px;
      margin: 0 5px;
      border: 1px solid #ddd;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .pagination a:hover {
      background-color: #2C3E50;
      color: #fff;
    }
    .pagination a.active {
      background-color: #2C3E50;
      color: #fff;
    }

    /* Footer styling */
    .footer {
      background-color: #2C3E50;
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
    .footer a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
    }
    .footer a:hover {
      color: #ffd700;
    }

    /* Navbar link hover effect */
    .navbar-link {
      color: rgb(255, 255, 255);
      text-decoration: none;
      font-weight: bold;
      padding: 5px 10px;
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
    }
    .navbar-link:hover {
      color: #ffd700;
      background: #444;
      border-radius: 5px;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: '🎉 Welcome!',
                text: '{{ session('success') }}',
                icon: 'success',
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#0f172a',
                color: '#fff',
                iconColor: '#22c55e'
            });

            });
    </script>
    @endif


  <!-- Navbar -->
  <div class="navbar">
    <h1>📚 MyBookStore</h1> <!-- Store title -->
    <div style="display: flex; align-items: center; gap: 15px;">
      @if(auth()->check())
        <!-- Welcome -->
<span class="navbar-link">
  Welcome,
  <a href="{{ route('profile') }}" class="navbar-link" style="color: #ffd700;">
    {{ auth()->user()->name }}
  </a>
</span>

<!-- Shop Icon -->
<a href="{{ route('shop') }}" class="navbar-link">
  <i class="fas fa-store"></i> Shop
</a>

<!-- Cart Icon -->
<a href="{{ route('cart.view') }}" class="navbar-link">
  🛒 Cart <span class="cart-count" style="background: red; color: white; font-size: 12px; font-weight: bold; border-radius: 50%; padding: 3px 7px; position: absolute; top: -8px; right: -12px;">{{ session('cart') ? count(session('cart')) : 0 }}</span>
</a>

<!-- Order History -->
<a href="{{ route('order') }}" class="navbar-link">
  <i class="fas fa-history"></i> Orders
</a>

<!-- Logout Button -->
<form action="{{ route('logout') }}" method="POST" style="display: inline;">
  @csrf
  <button type="submit" class="navbar-link" style="background: none; border: none; cursor: pointer;">
    <i class="fas fa-sign-out-alt"></i> Logout
  </button>
</form>
      @else
        <a href="{{ route('login') }}">Login</a>
      @endif
    </div>
  </div>

  <!-- Hero Section -->
  <div class="header">
    <h2>Find Your Next Favorite Book</h2> <!-- Main heading -->
    <p>Browse thousands of books in different categories</p> <!-- Subheading -->
  </div>

  <!-- Search Bar -->
  <div class="search-bar">
    <form action="{{ route('products.list') }}" method="GET">
      <input type="text" name="search" placeholder="Search books..." required> <!-- Search input -->
      <button type="submit">Search</button> <!-- Search button -->
    </form>
  </div>

  <!-- Product Grid: Display books in a 6-column layout -->
  <div class="product-grid">
    @if($books->isEmpty())
      <p style="text-align: center; font-size: 18px; color: #777;">No books available at the moment. Check back later!</p>
    @else
      @foreach($books as $product) <!-- Loop through each book -->
        <div class="product-card">
          @if($product->image && file_exists(public_path('images/' . $product->image)))
            <img src="{{ asset('images/' . $product->image) }}" alt="Product Image"> <!-- Book image -->
          @else
            <p>No Image Available</p> <!-- Fallback if no image -->
          @endif
          <h3>{{ $product->title }}</h3> <!-- Book title -->
          <p>{{ $product->description }}</p> <!-- Book description -->
          <p class="price">₹{{ number_format($product->price, 2) }}</p> <!-- Book price -->
          <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn">Add to Cart</button> <!-- Add to cart button -->
          </form>
          <!-- View Details Button -->
          <a href="{{ route('products.details', ['id' => $product->id, 'type' => 'book']) }}"
             style="display: inline-block; background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; transition: background-color 0.3s ease, transform 0.3s ease; margin-top: 10px;"
             onmouseover="this.style.backgroundColor='#28a745'; this.style.transform='translateY(-2px)';"
             onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='translateY(0)';">
            View Details
          </a>
        </div>
      @endforeach
    @endif
  </div>

  <!-- Pagination container for client-side pagination -->
  <div class="pagination">
    <!-- Pagination links generated by JavaScript -->
  </div>

  <!-- Footer Section -->
  <div class="footer">
    <p>&copy; 2025 MyBookStore | Designed for Book Lovers 📖</p> <!-- Footer text -->
    <div>
      <a href="{{ route('about') }}">About Us</a> <!-- About link -->
      <a href="{{ route('contact') }}">Contact Us</a> <!-- Contact link -->
      <a href="{{ route('privacy') }}">Privacy Policy</a> <!-- Privacy Policy link -->
      <a href="{{ route('terms') }}">Terms of Service</a> <!-- Terms of Service link -->
    </div>
  </div>

  <!-- JavaScript for client-side pagination -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const itemsPerPage = 18; // 15 items per page (5 columns x 3 rows)
      const productCards = document.querySelectorAll('.product-card'); // Get all product cards
      const totalItems = productCards.length; // Total number of books
      const totalPages = Math.ceil(totalItems / itemsPerPage); // Calculate total pages
      const paginationContainer = document.querySelector('.pagination'); // Container for page links

      // Function to show only the cards for a specific page
      function showPage(page) {
        productCards.forEach((card, index) => {
          card.style.display = 'none'; // Hide all cards
          if (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) {
            card.style.display = 'block'; // Show cards for current page
          }
        });
      }

      // Function to setup pagination links dynamically
      function setupPagination() {
        for (let i = 1; i <= totalPages; i++) {
          const pageLink = document.createElement('a');
          pageLink.href = '#';
          pageLink.innerText = i; // Set page number as link text
          pageLink.addEventListener('click', function(e) {
            e.preventDefault();
            showPage(i); // Show the selected page
            // Remove active class from all links and add to the clicked one
            document.querySelectorAll('.pagination a').forEach(a => a.classList.remove('active'));
            this.classList.add('active');
          });
          paginationContainer.appendChild(pageLink);
        }
      }

      if (totalPages > 1) {
        setupPagination(); // Create pagination links if more than one page
        showPage(1); // Initially display first page
        const firstPageLink = paginationContainer.querySelector('a');
        if (firstPageLink) {
          firstPageLink.classList.add('active'); // Highlight first page link
        }
      } else {
        // If only one page, display all items
        productCards.forEach(card => card.style.display = 'block');
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>

@section('content')
<!-- Content section for blade (if extending layout) -->
@endsection
