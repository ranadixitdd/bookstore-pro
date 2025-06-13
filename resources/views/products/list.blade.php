@extends('layouts.app')

@section('title', 'All Books')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

  body {
    font-family: 'Roboto', sans-serif;
    background: url('{{ asset("images/home-bg.jpg") }}') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
  }

  .catalog-container {
    max-width: 1600px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 20px;
    background: rgb(0 0 0 / 15%);
    backdrop-filter: blur(10px);
    box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .catalog-header h1 {
    font-size: 2.8rem;
    color: #00ffff;
    text-shadow: 0 0 10px #00ffff;
  }

  .catalog-header p {
    color: #ccc;
  }

  .filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    margin: 30px 0;
  }

  .filter-bar input,
  .filter-bar select {
    padding: 10px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border: 1px solid #00ffff;
    backdrop-filter: blur(5px);
    width: 220px;
  }

  .filter-bar option {
    color: #000; /* Options inside dropdown are black */
  }

  .filter-bar button {
    background: #00ffff;
    color: #000;
    font-weight: bold;
    border-radius: 10px;
    padding: 10px 20px;
    border: none;
    box-shadow: 0 0 10px #00ffff;
  }

  .book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 25px;
  }

  .book-card {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .book-card:hover {
    transform: scale(1.03);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
  }

  .book-card img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .book-card-content {
    padding: 15px;
  }

  .book-card-content h3 {
    font-size: 1.3rem;
    color: #00ffff;
    margin-bottom: 8px;
    text-shadow: 0 0 6px #00ffff;
  }

  .rating {
    color: #ffc107;
    margin-bottom: 8px;
  }

  .book-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #00ff88;
    margin-bottom: 10px;
  }

  .btn {
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
    margin-top: 8px;
    display: inline-block;
  }

  .btn-view {
    background-color: #00bfff;
    color: #000;
    box-shadow: 0 0 10px #00bfff;
  }

  .btn-add-cart {
    background-color: #00ff88;
    color: #000;
    box-shadow: 0 0 10px #00ff88;
  }

  .btn-view:hover { background-color: #0099cc; }
  .btn-add-cart:hover { background-color: #00cc66; }

  .pagination {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .pagination .page-link {
    background: rgba(255, 255, 255, 0.1);
    color: #00ffff;
    padding: 10px 14px;
    border-radius: 8px;
    box-shadow: 0 0 5px #00ffff;
    font-weight: bold;
    text-decoration: none;
  }

  .pagination .active .page-link {
    background: #00ff88;
    color: #000;
    box-shadow: 0 0 8px #00ff88;
  }

  .pagination .disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>

<div class="catalog-container">
  <div class="catalog-header text-center">
    <h1>Browse Books</h1>
    <p>Explore your favorite categories and genres</p>
  </div>

  <div class="filter-bar">
    <form action="{{ route('products.list') }}" method="GET">
      <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}">

      <select name="category">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>

      <select name="sort">
        <option value="">Sort By</option>
        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Name: A to Z</option>
        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Name: Z to A</option>
        <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Rating: High to Low</option>
        <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Rating: Low to High</option>
      </select>

      <button type="submit">Search</button>
    </form>
  </div>

  <div class="book-grid">
    @forelse ($products as $product)
      <div class="book-card">
        <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/no-image.png') }}" alt="{{ $product->title }}">
        <div class="book-card-content">
          <h3>{{ $product->title }}</h3>
          <div class="rating">
            @for ($i = 1; $i <= 5; $i++)
              <span class="{{ $i <= round($product->average_rating ?? 0) ? 'fas' : 'far' }} fa-star"></span>
            @endfor
          </div>
          <p class="book-price">₹{{ number_format($product->price, 2) }}</p>

          <a href="{{ route('products.details', $product->id) }}" class="btn btn-view">View</a>

          <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-add-cart">🛒 Add to Cart</button>
          </form>
        </div>
      </div>
    @empty
      <p>No books found for your criteria. Try adjusting the filters.</p>
    @endforelse
  </div>

  <div class="pagination">
    {!! $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
  </div>
</div>

@endsection
