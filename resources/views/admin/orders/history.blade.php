@extends('layouts.admin')

@section('title', 'Order History')

@section('content')
    <h2>Deleted Order History</h2>

    @if($orders->isEmpty())
        <p>No deleted orders found.</p>
    @else
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Deleted At</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->deleted_at }}</td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
