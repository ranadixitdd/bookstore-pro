@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<style>
    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        font-size: 26px;
        color: #2C3E50;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #2C3E50;
        color: white;
        font-size: 16px;
    }
    td {
        font-size: 14px;
    }
    input, select, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    textarea {
        height: 80px;
    }
    .btn {
        display: inline-block;
        padding: 12px 15px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }
    .btn-place-order {
        background: #28a745;
        color: white;
        width: 100%;
        text-align: center;
    }
    .btn-place-order:hover {
        background: #218838;
    }
    .btn-back {
        background: #007bff;
        color: white;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-back:hover {
        background: #0056b3;
    }
    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="container">
    <h2>🛍️ Checkout</h2>
    @if(isset($buyNowProduct))
    <!-- Display Buy Now Product -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $buyNowProduct->title }}</td>
                <td>₹{{ number_format($buyNowProduct->price, 2) }}</td>
                <td>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $buyNowProduct->stock }}">
                </td>
                <td>₹{{ number_format($buyNowProduct->price, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @elseif(session('cart') && count(session('cart')) > 0)
        <!-- Display Cart Items -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>₹{{ number_format($item['price'], 2) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <p style="text-align: center; font-size: 18px;">Your cart is empty.</p>
        <a href="{{ route('products.list') }}" class="btn btn-back">⬅️ Continue Shopping</a>
        @php return; @endphp
    @endif

    <h3 style="margin-top: 25px;">📋 Shipping Details</h3>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        @error('name') <p class="error">{{ $message }}</p> @enderror

        <label for="address">Shipping Address</label>
        <textarea id="address" name="address" required>{{ old('address', auth()->user()->address) }}</textarea>
        @error('address') <p class="error">{{ $message }}</p> @enderror

        <label for="payment_method">Payment Method</label>
        <select id="payment_method" name="payment_method" required>
            <option value="Cash on Delivery">Cash on Delivery</option>
        </select>
        @error('payment_method') <p class="error">{{ $message }}</p> @enderror

        <button type="submit" class="btn btn-place-order">✅ Place Order</button>
    </form>
    <a href="{{ route('cart.view') }}" class="btn btn-back">⬅️ Back to Cart</a>
</div>
@endsection
