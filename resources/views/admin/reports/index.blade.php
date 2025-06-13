@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">📊 Admin Dashboard Report</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Overview Cards -->
        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">👥 Total Users</h2>
            <p class="text-3xl text-blue-600">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">🛍️ Total Products</h2>
            <p class="text-3xl text-green-600">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">📦 Total Orders</h2>
            <p class="text-3xl text-purple-600">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">⭐ Pending Reviews</h2>
            <p class="text-3xl text-yellow-500">{{ $pendingReviews }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">✅ Active Products</h2>
            <p class="text-3xl text-green-700">{{ $activeProducts }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <h2 class="text-xl font-semibold">🚫 Inactive Products</h2>
            <p class="text-3xl text-red-600">{{ $inactiveProducts }}</p>
        </div>
    </div>

    <!-- User Activity -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">🧑‍💻 Recent User Activities</h2>
        <ul class="divide-y">
            @forelse($recentActivities as $activity)
                <li class="py-2">{{ $activity->user_name }} - {{ $activity->action }} at {{ $activity->created_at->format('d M Y, H:i') }}</li>
            @empty
                <li class="py-2 text-gray-500">No recent activities.</li>
            @endforelse
        </ul>
    </div>

    <!-- Feedback Section -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">💬 Latest Feedback / Complaints</h2>
        <ul class="divide-y">
            @forelse($feedbacks as $feedback)
                <li class="py-2">
                    <strong>{{ $feedback->user_name }}:</strong> {{ Str::limit($feedback->message, 100) }}
                </li>
            @empty
                <li class="py-2 text-gray-500">No feedback found.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
