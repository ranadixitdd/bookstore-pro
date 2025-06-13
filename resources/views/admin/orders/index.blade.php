@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1000px;
        margin: auto;
        padding: 30px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
    }

    h2 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 30px;
        color: #00f7ff;
        text-shadow: 0 0 8px #00f7ff;
    }

    .filter-section {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-section input,
    .filter-section select {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #00f7ff;
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        backdrop-filter: blur(6px);
        transition: all 0.3s ease;
    }

    .filter-section button {
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        background-color: #00f7ff;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 0 10px #00f7ff;
        transition: background 0.3s ease;
    }

    .filter-section button:hover {
        background-color: #00c4cc;
        box-shadow: 0 0 15px #00f7ff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        overflow: hidden;
        backdrop-filter: blur(6px);
    }

    th, td {
        padding: 14px;
        border: 1px solid rgba(0, 255, 255, 0.1);
        text-align: center;
    }

    th {
        background-color: rgba(0, 247, 255, 0.1);
        color: #00f7ff;
        text-shadow: 0 0 5px #00f7ff;
    }

    td {
        color: #ddd;
    }

    .status {
        font-weight: bold;
        padding: 6px 10px;
        border-radius: 5px;
        display: inline-block;
    }

    .status-pending { background-color: orange; color: #000; }
    .status-processing { background-color: #007bff; color: #fff; }
    .status-shipped { background-color: #6f42c1; color: #fff; }
    .status-delivered { background-color: #28a745; color: #fff; }
    .status-canceled { background-color: #dc3545; color: #fff; }

    .btn {
        padding: 8px 16px;
        border: none;
        background-color: transparent;
        color: #00f7ff;
        border: 2px solid #00f7ff;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 0 5px #00f7ff;
    }

    .btn:hover {
        background-color: #00f7ff;
        color: #000;
        box-shadow: 0 0 15px #00f7ff;
    }

    p.no-orders {
        text-align: center;
        font-size: 18px;
        color: #aaa;
        margin-top: 20px;
    }

  .pagination {
  list-style: none; /* 🔥 this removes the black bullets */
  padding: 0;
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 10px;
}

.pagination li {
  list-style: none; /* also ensures no bullets on li */
}

  .pagination .page-link {
    padding: 8px 12px;
    background: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
  }

  .pagination .active .page-link {
    background: #28a745;
  }

  .pagination .disabled .page-link {
    background: #ccc;
    cursor: not-allowed;
  }

</style>

<div class="container">
    <h2>📦 Manage Orders</h2>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-section">
        <input type="text" name="search" placeholder="🔍 Search by Name or Order ID..." value="{{ request('search') }}">
        <select name="status">
            <option value="">Filter by Status</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
            <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Canceled</option>
        </select>
        <button type="submit">Apply</button>
    </form>

    @if($orders->isEmpty())
        <p class="no-orders">😢 No orders found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Guest User' }}</td>
                        <td>₹{{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <span class="status status-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.view', $order->id) }}" class="btn">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination can be re-enabled here --}}
        {{-- <div class="pagination-wrapper mt-4">
            {{ $orders->links() }}
        </div> --}}
    @endif
</div>

{!! $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}

@endsection
