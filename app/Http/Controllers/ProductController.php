<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;

class ProductController extends Controller
{
    // ==========================================================
    // SHOW BOOK & PRODUCT CATALOG
    // ==========================================================
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $categoryId = $request->input('category');
        $sort       = $request->input('sort');

        $query = Product::with('category')
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->withCount('approvedReviews');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'rating_high':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('average_rating', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products   = $query->paginate(24)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.list', compact('products', 'categories'));
    }

    // ==========================================================
    // SHOW PRODUCT DETAILS
    // ==========================================================
    public function show($id)
    {
        $product = Product::with('approvedReviews', 'category')->findOrFail($id);

        $relatedBooks = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        return view('products.details', [
            'product'       => $product,
            'relatedBooks'  => $relatedBooks
        ]);
    }

    // ==========================================================
    // SEARCH FUNCTIONALITY
    // ==========================================================
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        return view('search', compact('products'));
    }

    // ==========================================================
    // FILTER BOOKS BY CATEGORY
    // ==========================================================
    public function filterByCategory($category)
    {
        $products = Product::where('category_id', $category)->paginate(24);
        return view('products.list', ['products' => $products]);
    }

    // ==========================================================
    // DISPLAY LATEST BOOKS
    // ==========================================================
    public function latestBooks()
    {
        $products = Product::orderBy('created_at', 'desc')->limit(10)->get();
        return view('products.list', compact('products'));
    }

    // ==========================================================
    // DISPLAY BEST-SELLING BOOKS
    // ==========================================================
    public function bestSellers()
    {
        $products = Product::orderBy('sales', 'desc')->limit(10)->get();
        return view('products.list', compact('products'));
    }

    // ==========================================================
    // RECOMMEND BOOKS BASED ON CATEGORY
    // ==========================================================
    public function recommendations($id)
    {
        $product = Product::findOrFail($id);
        $recommendedBooks = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(5)
            ->get();

        return view('products.details', [
            'product'          => $product,
            'relatedBooks'     => $recommendedBooks
        ]);
    }

    // ==========================================================
    // HOME PAGE
    // ==========================================================
    public function home()
{
    $books = Product::all(); // or use pagination/sorting if needed
    return view('home', compact('books'));
}


    // ==========================================================
    // STORE REVIEW (WITH STATUS = 0 FOR ADMIN APPROVAL)
    // ==========================================================
    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $productId,
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'comment'    => $request->content,
            'status'     => 0, // Pending approval
        ]);

        return back()->with('success', 'Review submitted for approval!');
    }
}
