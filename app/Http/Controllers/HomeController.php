<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Book;        // ← Make sure you have this model
use App\Models\Category;    // ← Import your Category model

class HomeController extends Controller
{
    // Redirect index to home
    public function index()
    {
        return $this->home();
    }

    // Show the storefront
    public function home()
    {
        // 1) Redirect to login if not authenticated
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2) If admin, send to dashboard
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // 3) Fetch all books and categories
        $books      = Book::all();
        $categories = Category::all();

        // 4) (Optional) your cart logic
        $cartItems  = Session::get('cart', []);

        // 5) Pass them to the view
        return view('home', compact('books', 'categories', 'cartItems'));
    }
}
