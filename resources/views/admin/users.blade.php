@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')

<!-- 🌌 GLASSIFIED STYLING -->
<style>
    body {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 25px;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
        color: #fff;
    }

    h2 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 25px;
        color: #00fff7;
        text-shadow: 0 0 5px #00fff7;
    }

    .search-filter {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-filter input,
    .search-filter select {
        padding: 10px;
        font-size: 14px;
        border-radius: 10px;
        border: none;
        width: 100%;
        max-width: 300px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        backdrop-filter: blur(5px);
        outline: none;
    }

    .search-filter button {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 10px;
        border: none;
        background: #00fff7;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 0 10px #00fff7;
        transition: 0.3s;
    }

    .search-filter button:hover {
        background: #00d4d1;
        box-shadow: 0 0 20px #00fff7;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    th {
        background: rgba(0, 255, 247, 0.2);
        text-shadow: 0 0 5px #00fff7;
    }

    .status-active {
        color: #00ff8c;
        font-weight: bold;
        text-shadow: 0 0 5px #00ff8c;
    }

    .status-blocked {
        color: #ff4c4c;
        font-weight: bold;
        text-shadow: 0 0 5px #ff4c4c;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn {
        padding: 8px 14px;
        font-size: 13px;
        border-radius: 8px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: 0.3s ease;
        color: #000;
    }

    .block-btn {
        background: #ffc107;
        box-shadow: 0 0 8px #ffc107;
    }

    .block-btn:hover {
        background: #e0a800;
        box-shadow: 0 0 16px #ffc107;
    }

    .unblock-btn {
        background: #28a745;
        box-shadow: 0 0 8px #28a745;
    }

    .unblock-btn:hover {
        background: #218838;
        box-shadow: 0 0 16px #28a745;
    }

    .delete-btn {
        background: #dc3545;
        box-shadow: 0 0 8px #dc3545;
        color: white;
    }

    .delete-btn:hover {
        background: #c82333;
        box-shadow: 0 0 16px #dc3545;
    }

    .pagination {
        text-align: center;
        margin-top: 25px;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        margin: 0 6px;
        padding: 8px 14px;
        background: rgba(255, 255, 255, 0.1);
        color: #00fff7;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.3s;
    }

    .pagination a:hover {
        background: #00fff7;
        color: #000;
        box-shadow: 0 0 12px #00fff7;
    }
</style>

<!-- 🧊 MANAGE USERS SECTION -->
<div class="container">
    <h2>👥 Manage Users</h2>

    <form method="GET" action="{{ route('admin.users') }}" class="search-filter">
        <input type="text" name="search" placeholder="🔍 Search users by name or email..." value="{{ request('search') }}">
        {{-- <select name="role">
            <option value="">All Roles</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="seller">Seller</option>
            <option value="admin">Admin</option>
        </select> --}}
        <button type="submit">🔄 Apply </button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($users->isEmpty())
                <tr><td colspan="7">🚫 No users found.</td></tr>
            @else
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <span class="{{ $user->is_blocked ? 'status-blocked' : 'status-active' }}">
                            {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="action-buttons">
                        @if($user->is_blocked)
                            <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" onsubmit="return confirm('Unblock this user?');">
                                @csrf
                                <button type="submit" class="btn unblock-btn">Unblock</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST" onsubmit="return confirm('Block this user?');">
                                @csrf
                                <button type="submit" class="btn block-btn">Block</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                            @csrf
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

@endsection
