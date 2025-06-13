<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review; // Ensure you have this model created
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve reviews along with user and product info (if defined in relationships)
        $reviews = Review::with(['user', 'product'])->orderBy('id', 'desc')->paginate(10); // You can set the number of items per page


        return view('admin.reviews.index', compact('reviews'));
    }
    public function approve($id)
{
    $review = Review::findOrFail($id);
    $review->status = 1;
    $review->save();

    return redirect()->back()->with('success', 'Review approved successfully.');
}

public function destroy($id)
{
    Review::destroy($id);
    return redirect()->back()->with('success', 'Review deleted.');
}

public function reply(Request $request, $id)
{
    $review = Review::findOrFail($id);
    $review->admin_reply = $request->input('reply');
    $review->save();

    return redirect()->back()->with('success', 'Reply added.');
}

}
