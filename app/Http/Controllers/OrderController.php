<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class OrderController extends Controller
{
        // Alias: if any route calls index(), we forward to orderHistory().
          // Alias: if any route calls index(), we forward to orderHistory().
    public function index()
    {
        return $this->orderHistory();
    }

    // ✅ Show Order Details for the authenticated user.
    public function show($id)
{
    // eager‑load the user and the books on each order item
    $order = Order::with(['user', 'orderItems.book'])
                  ->where('id', $id)
                  ->where('user_id', Auth::id())
                  ->first();

    if (! $order) {
        return redirect()
            ->route('orders.history')
            ->with('error', 'Order not found.');
    }

    return view('orders.show', compact('order'));
}


    // ✅ Order History (Listing Orders) – use one method consistently
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('orders.history', compact('orders'));
    }

    // ✅ Confirm Order (e.g., for Admin use remains unchanged)
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Order confirmed successfully.');
    }

    // ✅ Place Order
    public function placeOrder(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to place an order.');
    }

    if (!$request->has('cart_items') || empty($request->cart_items)) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Calculate the total price
    $total_price = 0;
    foreach ($request->cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Retrieve the user
    $user = Auth::user();

    // Check if the shipping address is provided via the checkout form,
    // otherwise fall back to the user's default address (assumed to be stored in, for example, $user->address)
    // Adjust the property name as needed.
    $shippingAddress = $request->input('shipping_address', $user->address);

    DB::beginTransaction();
    try {
        // Create the order including shipping address and payment status if needed.
        $order = Order::create([
            'user_id'         => $user->id,
            'total_price'     => $total_price,
            'payment_method'  => $request->payment_method,
            'status'          => 'pending',
            'shipping_address'=> $shippingAddress,
            // Optionally include a payment_status field if you're handling it:
            'payment_status'  => $request->input('payment_status', 'pending'),
        ]);

        // Loop through the cart items and create related order items
        foreach ($request->cart_items as $item) {
            $order->orderItems()->create([
                'book_id'  => $item['book_id'],
                'quantity' => $item['quantity'],
                'price'    => $item['price']
            ]);
        }

        // Clear the cart from the session
        $request->session()->forget('cart');
        DB::commit();

        return redirect()->route('orders.details', ['id' => $order->id])
                         ->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error placing order.');
    }
}


    // ✅ Checkout Page
    public function checkout()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('checkout.index', compact('orders'));
    }

    // ✅ Cancel Order via AJAX (returns JSON)
    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        if ($order->status === 'canceled') {
            return response()->json(['error' => 'Order is already canceled.'], 400);
        }

        // if (!$order->isCancellable()) {
        //     return response()->json(['error' => 'Order cannot be canceled.'], 400);
        // }

        DB::beginTransaction();
        try {
            $order->update(['status' => 'canceled']);
            // Optionally, process refund here

            DB::commit();
            return response()->json(['success' => 'Order has been canceled.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error canceling order.'], 500);
        }
    }
    public function buyNow($id)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed.');
        }

        // Fetch the product details
        $product = Product::findOrFail($id);

        // Redirect to checkout page with product data (skip cart)
        session()->put('buy_now_product', $product);
        return redirect()->route('checkout.index');
    }
     // Update the order status.
     public function update(Request $request, $id)
     {
         $request->validate([
             'status' => 'required|in:pending,shipped,delivered,Canceled',
         ]);

         $order = Order::where('id', $id)
                       ->where('user_id', Auth::id())
                       ->first();

         if (!$order) {
             return redirect()->route('orders.history')->with('error', 'Order not found.');
         }

         $order->status = $request->input('status');
         $order->save();

         return redirect()->route('orders.details', $order->id)
                          ->with('success', 'Order status updated successfully.');
     }
}
