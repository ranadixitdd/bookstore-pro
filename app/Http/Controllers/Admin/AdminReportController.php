<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;

class AdminReportController extends Controller
{
    public function showReport()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();
        // $pendingReviews = Review::where('status', 'pending')->count();
        $totalOrders = Order::count();

        $recentActivities = User::latest()->take(5)->get();

        return view('admin_report', compact(
            'totalUsers',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            // 'pendingReviews',
            'totalOrders',
            'recentActivities'
        ));
    }
}
