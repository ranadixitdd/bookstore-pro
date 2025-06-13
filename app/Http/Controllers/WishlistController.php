<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page for the logged-in user.
     */
    public function index()

    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->latest()->get(); // Load products
        $wishlistCount = $wishlists->count();
    
        return view('wishlist', compact('wishlists', 'wishlistCount'));
    }
    
    /**
     * Add or remove a book from the wishlist using AJAX.
     */
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthorized']); // User must be logged in
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->where('book_id', $request->book_id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']); // Return JSON response
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
            ]);
            return response()->json(['status' => 'added']); // Return JSON response
        }
    }
}
