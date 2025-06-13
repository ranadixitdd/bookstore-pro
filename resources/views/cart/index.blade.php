@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<style>
    /* --------------------
       NeonGlassPage Styling
    -------------------- */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: url('{{ asset("images/cart-bg2.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', sans-serif;
        color: #e0e0e0;
    }

    .bg-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.55);
        z-index: -1;
    }

    .page-wrapper {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        padding: 40px 20px;
    }

    .container {
        max-width: 1000px;
        margin: auto;
        background: rgba(255, 255, 255, 0.07);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    h2, h3, p, td, th {
        color: #f1f1f1;
    }

    h2 {
        font-size: 28px;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 0 0 5px #00f7ff;
    }

    h3 {
        font-size: 22px;
        margin-top: 30px;
        text-align: right;
        text-shadow: 0 0 3px #00e6e6;
    }

    p {
        font-size: 16px;
        text-align: center;
        margin-top: 10px;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 10px 14px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        box-shadow: 0 0 8px rgba(0,255,255,0.4);
    }

    .btn-update {
        background: #ffc107;
        color: #000;
    }

    .btn-update:hover {
        background: #e0a800;
    }

    .btn-remove {
        background: #ff3c5f;
        color: #fff;
    }

    .btn-remove:hover {
        background: #c82333;
    }

    .btn-checkout {
        background: #00ffaa;
        color: #000;
        width: 260px;
        margin: 20px auto;
        display: block;
        font-size: 16px;
        box-shadow: 0 0 12px #00ffaa;
    }

    .btn-checkout:hover {
        background: #00dd99;
    }

    .continue-shopping {
        background: #3399ff;
        color: #fff;
        padding: 10px 14px;
        border-radius: 5px;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
        margin-top: 25px;
    }

    .continue-shopping:hover {
        background: #0066cc;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255,255,255,0.1);
        color: #e0e0e0;
    }

    th, td {
        padding: 12px;
        border: 1px solid rgba(255,255,255,0.1);
        text-align: center;
    }

    th {
        background: rgba(0, 191, 255, 0.6);
        color: #fff;
        font-size: 16px;
        text-shadow: 0 0 2px #000;
    }

    td {
        font-size: 14px;
    }

    .cart-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid rgba(255,255,255,0.2);
    }

    input[type="number"] {
        width: 60px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        text-align: center;
    }

    /* Related Books */
    .related-books {
        margin-top: 50px;
        text-align: center;
    }

    .related-books h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #fff;
        text-shadow: 0 0 3px #00f7ff;
    }

    .related-container {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .related-item {
        background: rgba(255, 255, 255, 0.15);
        padding: 10px;
        border-radius: 10px;
        width: 180px;
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
        transition: transform 0.3s;
    }

    .related-item:hover {
        transform: scale(1.05);
    }

    .related-item img {
        width: 100%;
        border-radius: 8px;
    }

    .related-item p {
        font-size: 14px;
        margin: 8px 0;
        color: #fff;
    }

    .view-btn {
        background: #00cfff;
        color: #000;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
    }

    .view-btn:hover {
        background: #00aacc;
    }
</style>

<div class="bg-overlay"></div>

<div class="page-wrapper">
  <div class="main-content">
    <div class="container">
      <h2>🛒 Your Shopping Cart</h2>

      @if(! auth()->check())
        <p>Please log in to view your cart.</p>
        <a href="{{ route('login') }}" class="btn btn-checkout">Login</a>

      @elseif(session('cart') && count(session('cart')) > 0)
        @php $total = 0; @endphp
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Image</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody>
            @foreach(session('cart') as $id => $item)
              @php
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
              @endphp
              <tr>
                <td>{{ $item['name'] }}</td>
                <td>
                  <img src="{{ asset('images/' . $item['image']) }}" class="cart-image">
                </td>
                <td>₹{{ $item['price'] }}</td>
                <td>
                  <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1">
                    <button type="submit" class="btn btn-update">Update</button>
                  </form>
                </td>
                <td>₹{{ $subtotal }}</td>
                <td>
                  <form action="{{ route('cart.remove', ['id' => $id]) }}" method="POST" onsubmit="return confirmRemove();">
                    @csrf
                    <button type="submit" class="btn btn-remove">Remove</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <h3>Total: ₹{{ $total }}</h3>
        <a href="{{ route('checkout') }}" class="btn btn-checkout">Proceed to Checkout</a>

      @else
        <p>Your cart is empty.</p>
      @endif

      <div class="cart-options" style="text-align:center;">
        <a href="{{ route('products.list') }}" class="continue-shopping">🛒 Continue Shopping</a>
      </div>

      @if(isset($relatedBooks) && $relatedBooks->count())
        <div class="related-books">
          <h3>📚 You Might Also Like</h3>
          <div class="related-container">
            @foreach($relatedBooks as $book)
              <div class="related-item">
                <img src="{{ asset('images/' . $book->image) }}" alt="{{ $book->title }}">
                <p>{{ $book->title }}</p>
                <a href="{{ route('products.details', $book->id) }}" class="view-btn">👀 View</a>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </div>
</div>

<script>
  function confirmRemove() {
    return confirm('Are you sure you want to remove this item from your cart?');
  }
</script>
@endsection
