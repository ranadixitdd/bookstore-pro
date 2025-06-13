<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">📊 Admin Dashboard Report</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">👥 Total person</h2>
                <p class="text-3xl text-blue-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">🛍️ Total Products</h2>
                <p class="text-3xl text-green-600">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">📦 Total Orders</h2>
                <p class="text-3xl text-purple-600">{{ $totalOrders }}</p>
            </div>
            {{-- <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">⭐ Reviews</h2>
                <p class="text-3xl text-yellow-500">{{ $pendingReviews }}</p>
            </div> --}}
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">✅ Active Products</h2>
                <p class="text-3xl text-green-700">{{ $activeProducts }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold">🚫 Inactive Products</h2>
                <p class="text-3xl text-red-600">{{ $inactiveProducts }}</p>
            </div>
        </div>

        <!-- 📊 Bar Chart -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">📈 Overview Chart</h2>
            <canvas id="reportChart" height="100"></canvas>
        </div>

        <!-- 🧑‍💻 User Activity -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-semibold mb-4">🧑‍💻 Recent User Registrations</h2>
            <ul class="divide-y">
                @forelse($recentActivities as $activity)
                    <li class="py-2">
                        {{ $activity->name ?? 'Unknown User' }} —
                        Registered at {{ $activity->created_at?->format('d M Y, H:i') ?? 'Unknown time' }}
                    </li>
                @empty
                    <li class="py-2 text-gray-500">No recent activities.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('reportChart').getContext('2d');
        const reportChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Users', 'Products', 'Orders', 'Active Products', 'Inactive Products', 'Pending Reviews'],
                datasets: [{
                    label: 'Total Count',
                    data: [
                        {{ $totalUsers }},
                        {{ $totalProducts }},
                        {{ $totalOrders }},
                        {{ $activeProducts }},
                        {{ $inactiveProducts }},
                        
                    ],
                    backgroundColor: [
                        '#3b82f6',
                        '#10b981',
                        '#8b5cf6',
                        '#22c55e',
                        '#ef4444',
                        '#facc15'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
</body>
</html>
