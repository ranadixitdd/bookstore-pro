<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class AdminOrderController extends Controller
{
    // 🟢 Show all orders in admin panel
    public function index(Request $request)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/')->with('error', 'Access Denied');
    }

    // Get filter value from request (default: all)
    $filter = $request->input('status');

    // Fetch orders based on filter
    $query = Order::orderBy('created_at', 'desc');

    if (!empty($filter)) {
        $query->where('status', $filter);
    }

    $orders = $query->paginate(10); // Paginate results

    return view('admin.orders.index', compact('orders', 'filter'));
}


    // 🟢 View details of a specific order
    public function view($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }

        $order = Order::with(['orderItems.book'])->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    // 🟢 Update order status (e.g., pending -> shipped)
    public function updateStatus(Request $request, $id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/')->with('error', 'Access Denied');
    }

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    // ✅ Redirect back to the previous page (or default to orders list)
    return redirect($request->input('prev', route('admin.orders.index')))
        ->with('success', 'Order status updated successfully!');
}

}
