<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // View Cart
    public function viewCart()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please login to view your cart');
        }

        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);

        $relatedBooks = Product::whereNotIn('id', $productIds)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('cart.index', compact('cart', 'relatedBooks'));
    }

    // Add to Cart
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $key = (string)$id;
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                "book_id"  => $id,
                "name"     => $product->title,
                "price"    => $product->price,
                "quantity" => $quantity,
                "image"    => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }

    // Remove from Cart
    // Remove from Cart
public function removeFromCart(Request $request, $id)
{
    $cart = session()->get('cart', []);
    $key = (string)$id;

    if (isset($cart[$key])) {
        unset($cart[$key]);
        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        // If this is an AJAX/JSON request:
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('cart.view')->with('success', 'Item removed.');
    }

    if ($request->wantsJson()) {
        return response()->json(['success' => false, 'error' => 'Item not found'], 404);
    }

    return redirect()->route('cart.view')->with('error', 'Item not found.');
}


    // Update Cart
    public function updateCart(Request $request)
{
    $cart = session()->get('cart', []);
    foreach ($request->quantities as $id => $qty) {
        $key = (string)$id;
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $qty;
        }
    }
    session()->put('cart', $cart);

    if ($request->wantsJson()) {
        return response()->json(['success' => true]);
    }

    return redirect()->back()->with('success', 'Cart updated!');
}



    // Alternate add method (if needed)
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $key = (string)$id;
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                "book_id"  => $id,
                "name"     => $product->title,
                "price"    => $product->price,
                "quantity" => $quantity,
                "image"    => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
