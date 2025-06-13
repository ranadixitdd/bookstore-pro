@extends('layouts.app')

@section('styles')
<style>
    body {
        background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
        color: #f0f0f0;
        font-family: 'Inter', sans-serif;
    }

    h2, h4 {
        text-shadow: 0 0 6px #00f7ff;
        margin-bottom: 25px;
        text-align: center;
    }

    .order-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
        margin-bottom: 30px;
        transition: 0.3s;
    }

    .order-card:hover {
        box-shadow: 0 0 15px #00f7ff;
    }

    .order-card p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .badge {
        padding: 6px 12px;
        font-size: 0.85em;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 0 8px rgba(255,255,255,0.1);
        text-shadow: 0 0 4px rgba(0,0,0,0.2);
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: #fff;
    }

    .bg-success {
        background-color: #28a745 !important;
        color: #fff;
    }

    .btn {
        font-weight: bold;
        border-radius: 8px;
        transition: 0.3s ease-in-out;
        box-shadow: 0 0 8px rgba(0,247,255,0.2);
    }

    .btn-danger {
        background: rgba(220, 53, 69, 0.8);
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background: rgba(220, 53, 69, 1);
        box-shadow: 0 0 12px #dc3545;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    ul li {
        background: rgba(0, 247, 255, 0.07);
        margin-bottom: 10px;
        padding: 10px 15px;
        border-left: 4px solid #00f7ff;
        border-radius: 8px;
        box-shadow: 0 0 8px rgba(0,247,255,0.05);
    }

    .section-block {
        margin-bottom: 25px;
    }

    .section-block h5 {
        color: #00f7ff;
        margin-bottom: 10px;
    }

    .text-warning {
        color: #ffc107 !important;
        font-weight: bold;
        text-shadow: 0 0 6px #ffc107;
    }

    @media (max-width: 768px) {
        .order-card {
            padding: 15px;
        }

        .order-card p,
        ul li {
            font-size: 14px;
        }

        .btn {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2>Order Details</h2>

    <div class="order-card">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Status:</strong>
            <span class="badge {{ $order->status === 'canceled' ? 'bg-danger' : 'bg-success' }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
        <p><strong>Total:</strong> ${{ $order->total_price }}</p>
        <p><strong>Ordered On:</strong> {{ $order->created_at->format('d M Y, H:i A') }}</p>

        @if($order->isCancellable())
            <button class="btn btn-danger cancel-order-btn" data-id="{{ $order->id }}">Cancel Order</button>
        @endif

        @if($order->status === 'canceled')
            <p class="text-warning mt-2">Refund Processed</p>
        @endif
    </div>

    <div class="section-block">
        <h4>Order Items</h4>
        <ul>
            @foreach($order->orderItems as $item)
                <li>
                    📘 <strong>{{ $item->book->title }}</strong> — {{ $item->quantity }} pcs @ ${{ $item->price }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="section-block">
        <h4>Shipping Address</h4>
        <ul>
            <li><strong>Name:</strong> {{ $order->user->name }}</li>
            <li><strong>Address:</strong> {{ $order->shipping_address }}</li>
            <li><strong>City:</strong> {{ $order->shipping_city }}</li>
            <li><strong>ZIP:</strong> {{ $order->shipping_zip }}</li>
            <li><strong>Country:</strong> {{ $order->shipping_country }}</li>
        </ul>
    </div>

    <div class="section-block">
        <h4>Payment Method</h4>
        <ul>
            <li><strong>Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</li>
            <li><strong>Status:</strong> {{ ucfirst($order->payment_status ?? 'Pending') }}</li>
        </ul>
    </div>

    {{-- Optional future section --}}
    {{--
    <div class="section-block">
        <h4>Order Timeline</h4>
        <ul>
            <li><strong>Placed:</strong> {{ $order->created_at }}</li>
            <li><strong>Processed:</strong> ... </li>
            <li><strong>Shipped:</strong> ... </li>
            <li><strong>Delivered:</strong> ... </li>
        </ul>
    </div>
    --}}
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".cancel-order-btn").forEach(button => {
        button.addEventListener("click", function () {
            let orderId = this.getAttribute("data-id");
            let csrfToken = @json(csrf_token());

            if (confirm("Are you sure you want to cancel this order?")) {
                button.textContent = "Canceling...";
                button.disabled = true;

                fetch(`/orders/${orderId}/cancel`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Order has been canceled.");
                        location.reload();
                    } else {
                        alert(data.error);
                        button.textContent = "Cancel Order";
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    button.textContent = "Cancel Order";
                    button.disabled = false;
                });
            }
        });
    });
});
</script>
@endsection
