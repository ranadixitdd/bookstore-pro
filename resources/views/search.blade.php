@extends('layouts.app')

@section('content')
<style>
    /* ==========================================================
       Search Container Styles
       ========================================================== */
    .search-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .search-container h1 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* ==========================================================
       Search Box Styles
       ========================================================== */
    .search-box {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .search-box input {
        width: 70%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .search-box button {
        padding: 8px 15px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-box button:hover {
        background: #0056b3;
    }

    /* ==========================================================
       Search Results List Styles
       ========================================================== */
    .search-results {
        list-style: none;
        padding: 0;
    }

    .search-results li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .search-results img {
        width: 100px;
        height: auto;
        border-radius: 5px;
        margin-right: 15px;
    }

    /* ==========================================================
       Book Details Styles
       ========================================================== */
    .book-details {
        flex-grow: 1;
    }

    .book-title {
        font-weight: bold;
    }

    .book-price {
        color: #d9534f;
        font-weight: bold;
    }

    /* ==========================================================
       Buttons Section Styles
       ========================================================== */
    .book-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .book-buttons a {
        text-decoration: none;
        font-size: 14px;
        margin: 5px 0;
        padding: 6px 12px;
        border-radius: 4px;
        width: 100px;
        text-align: center;
    }

    /* View Button */
    .view-btn {
        background: #28a745;
        color: white;
    }

    .view-btn:hover {
        background: #218838;
    }

    /* Checkout Button */
    .check-btn {
        background: #ffc107;
        color: black;
    }

    .check-btn:hover {
        background: #e0a800;
    }

    /* Add to Cart Button */
    .cart-btn {
        background: #007bff;
        color: white;
    }

    .cart-btn:hover {
        background: #0056b3;
    }
</style>

<div class="search-container">
    <!-- ==========================================================
         Search Title
         ========================================================== -->
    <h1>Search Results for "{{ request()->query('query') }}"</h1>

    <!-- ==========================================================
         Search Form
         ========================================================== -->
         <form action="{{ route('product.search') }}" method="GET">
            <input type="text" name="query" placeholder="Search for books...">
            <button type="submit">🔍 Search</button>
        </form>
        
    <!-- ==========================================================
         Search Results List
         ========================================================== -->
    <h3>Results:</h3>
    <ul class="search-results">
        @forelse($books as $book)
            <li>
                <!-- Book Image -->
                <a href="{{ route('products.details', $book->id) }}">
                    @if($book->image && file_exists(public_path('images/' . $book->image)))
                        <img src="{{ asset('images/' . $book->image) }}" alt="{{ $book->title }}">
                   
                    @endif
                </a>

                <!-- Book Details -->
                <div class="book-details">
                    <p class="book-title">{{ $book->title }}</p>
                    <p>by {{ $book->author }}</p>
                    <p class="book-price">₹{{ $book->price }}</p>
                </div>

                <!-- Book Action Buttons -->
                <div class="book-buttons">
                    <a href="{{ route('products.details', $book->id) }}" class="view-btn">View</a>
                    {{-- <a href="{{ route('checkout', $book->id) }}" class="check-btn">Check</a> --}}
                    <a href="{{ route('cart.add', $book->id) }}" class="cart-btn">Add to Cart</a>
                </div>
            </li>
        @empty
            <p>No books found.</p>
        @endforelse
    </ul>
</div>
@endsection
