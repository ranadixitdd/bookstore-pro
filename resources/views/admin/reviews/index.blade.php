@extends('layouts.admin')

@section('title', 'User Reviews & Ratings')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        color: #fff;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    h1 {
        font-size: 30px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #00d4ff;
        text-align: center;
        text-shadow: 0 0 10px rgba(0, 212, 255, 0.6);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        backdrop-filter: blur(4px);
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background-color: rgba(0, 212, 255, 0.2);
    }

    th, td {
        padding: 14px 18px;
        text-align: center;
        color: #e0f7fa;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        vertical-align: middle;
    }

    tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
        transition: background 0.3s ease;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
        border: 1px solid transparent;
    }

    .badge-success {
        background-color: rgba(40, 167, 69, 0.3);
        border-color: #28a745;
        color: #28ff9c;
        text-shadow: 0 0 8px rgba(40, 255, 156, 0.4);
    }

    .badge-warning {
        background-color: rgba(255, 193, 7, 0.2);
        border-color: #ffc107;
        color: #ffd45e;
        text-shadow: 0 0 6px rgba(255, 212, 94, 0.5);
    }

    .text-center {
        text-align: center;
    }

    textarea {
        width: 100%;
        resize: vertical;
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: 1px solid #00d4ff;
        border-radius: 8px;
        padding: 8px;
    }

    .btn {
        padding: 6px 10px;
        font-size: 12px;
        border-radius: 6px;
        margin-top: 4px;
        cursor: pointer;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }
</style>
<style>
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper nav {
        display: flex;
        gap: 8px;
    }

    .pagination-wrapper span,
    .pagination-wrapper a {
        padding: 6px 12px;
        background: rgba(0, 255, 204, 0.08);
        border-radius: 8px;
        border: 1px solid #00ffd5;
        color: #00ffd5;
        font-size: 14px;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .pagination-wrapper .active span {
        background: #00ffd5;
        color: #0f0c29;
        font-weight: bold;
    }

    .pagination-wrapper a:hover {
        background: rgba(0, 255, 204, 0.2);
        box-shadow: 0 0 5px #00ffd5;
    }
    </style>


<div class="container">
    <h1><i class="fa-solid fa-star"></i> User Reviews & Ratings</h1>
    <table>
        <thead>
            <tr>
                <th>#ID</th>
                <th><i class="fa-solid fa-user"></i> User</th>
                <th><i class="fa-solid fa-book"></i> Product</th>
                <th><i class="fa-solid fa-comment-dots"></i> Comment</th>
                <th><i class="fa-solid fa-star-half-stroke"></i> Rating</th>
                <th><i class="fa-solid fa-toggle-on"></i> Status</th>
                <th><i class="fa-regular fa-clock"></i> Submitted At</th>
                <th><i class="fa-solid fa-wrench"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->user->name ?? 'N/A' }}</td>
                <td>{{ $review->product->name ?? 'N/A' }}</td>
                <td>{{ $review->comment }}</td>
                <td>{{ $review->rating }}</td>
                <td>
                    @if($review->status === '1')
                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Approved</span>
                    @else
                        <span class="badge badge-warning"><i class="fa-solid fa-clock"></i> Pending</span>
                    @endif
                </td>
                <td>{{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                <td>
                    @if($review->status === '0')
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('PATCH')
                            <button class="btn btn-success"><i class="fa-solid fa-check"></i> Approve</button>
                        </form>
                    @endif

                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No reviews found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">
    {{ $reviews->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection
