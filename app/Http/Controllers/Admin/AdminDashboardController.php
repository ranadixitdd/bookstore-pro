<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Book;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // ==========================================================
    // Admin Dashboard Overview
    // ==========================================================
    public function index()
    {
        // ==========================================================
        // Total Revenue Calculation (Include soft-deleted orders)
        // ==========================================================
        $totalRevenue = Order::withTrashed()->where('status', 'Delivered')->sum('total_price');

        // ==========================================================
        // Profit/Loss Calculation (Include soft-deleted orders)
        // ==========================================================
        $totalCost = Order::withTrashed()->where('status', 'Delivered')->sum('total_price') * 0.7;
        $profitLoss = $totalRevenue - $totalCost;

        // ==========================================================
        // Total Users Count (Excluding Admins)
        // ==========================================================
        $totalUsers = User::where('is_admin', false)->count();

        // ==========================================================
        // Total Orders & Canceled Orders Count (Including soft-deletes)
        // ==========================================================
        $totalOrders = Order::withTrashed()->count();
        $canceledOrders = Order::withTrashed()->where('status', 'Canceled')->count();

        // ==========================================================
        // Orders This Month & Last Month
        // ==========================================================
        $ordersThisMonth = Order::withTrashed()->whereMonth('created_at', Carbon::now()->month)->count();
        $ordersLastMonth = Order::withTrashed()->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        // ==========================================================
        // Best-Selling Book Calculation
        // ==========================================================
        $bestSeller = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->selectRaw('books.id, books.title, books.price, books.stock, books.author, books.description, SUM(order_items.quantity) as total_sold')
            ->groupBy('books.id', 'books.title', 'books.price', 'books.stock', 'books.author', 'books.description')
            ->orderByDesc('total_sold')
            ->first();

        $bestSellerTitle = $bestSeller ? $bestSeller->title : 'No Best Seller Yet';

        // ==========================================================
        // Low Stock Books Count
        // ==========================================================
        $lowStockCount = Book::where('stock', '<', 5)->count();
        $lowStockBooks = Book::where('stock', '<', 5)->get();


        // ==========================================================
        // Fetch Recent Orders (Including soft-deletes)
        // ==========================================================
        $recentOrders = Order::withTrashed()->latest()->take(5)->get();

        // ==========================================================
        // Pass All Data to the View
        // ==========================================================
        return view('admin.dashboard', compact(
            'totalRevenue',
            'profitLoss',
            'totalUsers',
            'totalOrders',
            'canceledOrders',
            'ordersThisMonth',
            'ordersLastMonth',
            'bestSellerTitle',
            'lowStockCount',
            'lowStockBooks',
            'recentOrders'
        ));

    }
}
