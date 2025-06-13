<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    // Show checkout form (for cart & Buy Now)
    public function showCheckoutForm()
    {
        $buyNowProduct = session()->get('buy_now_product');
        if ($buyNowProduct) {
            return view('checkout.index', compact('buyNowProduct'));
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    // Alias for showCheckoutForm.
    public function index()
    {
        return $this->showCheckoutForm();
    }

    // (Optional) Handle Buy Now checkout separately if needed.
    public function checkout()
    {
        $buyNowProduct = session()->get('buy_now_product');
        if (!$buyNowProduct) {
            return redirect()->route('cart.view')->with('error', 'Invalid product selection.');
        }
        return view('checkout.index', compact('buyNowProduct'));
    }

    // Process checkout (for both cart & Buy Now)
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'address'          => 'required|string|max:500',
            'shipping_address' => 'nullable|string|max:255',
            'payment_method'   => 'required|in:Credit Card,PayPal,Cash on Delivery',
        ]);

        $buyNowProduct = session()->get('buy_now_product');

        if ($buyNowProduct) {
            // Read quantity from the request for Buy Now orders.
            $quantity = $request->input('quantity', 1);
            // Build a cart array using the Buy Now product with user-selected quantity.
            $cart = [
                (string)$buyNowProduct->id => [
                    'book_id'  => $buyNowProduct->id,
                    'name'     => $buyNowProduct->title,
                    'price'    => $buyNowProduct->price,
                    'quantity' => $quantity,
                    'image'    => $buyNowProduct->image,
                ]
            ];
            session()->forget('buy_now_product'); // Clear Buy Now session after purchase.
        } else {
            $cart = session()->get('cart', []);
        }

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        // Calculate total price properly (price * quantity)
        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Use provided shipping_address if available; otherwise use the default address.
        $shippingAddress = $request->input('shipping_address', $request->address);

        // Create new order including both the billing address and shipping address.
        $order = Order::create([
            'user_id'         => auth()->id(),
            'name'            => $request->name,
            'address'         => $request->address, // default or billing address.
            'shipping_address'=> $shippingAddress,  // override if provided.
            'payment_method'  => $request->payment_method,
            'total_price'     => $totalPrice,
        ]);

        // Add order items.
        foreach ($cart as $item) {
            $product = Product::find($item['book_id']);
            if (!$product) {
                return redirect()->route('cart.view')->with('error', 'One or more products in your cart no longer exist.');
            }
            OrderItem::create([
                'order_id' => $order->id,
                'book_id'  => $item['book_id'],
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
            ]);
        }

        // Clear cart if this wasn’t a Buy Now order.
        if (!$buyNowProduct) {
            session()->forget('cart');
            session()->save();
        }

        return redirect()->route('checkout.confirm')->with('success', 'Your order has been placed successfully!');
    }
}
