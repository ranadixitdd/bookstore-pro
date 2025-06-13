<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        if ($sort = $request->input('sort')) {
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
            }
        } else {
            $query->latest(); // default
        }

        // ✅ PAGINATE RESULTS
        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }



    public function add()
    {
        // * Fetch all categories for product category selection
        $categories = Category::all();
        return view('admin.products.add', compact('categories')); // * Return the add product view with categories
    }

    // ==========================================================
    // Handle Product Submission
    // ==========================================================
    /*
    This method handles the submission of the add product form.
    It validates the input data, handles image upload, and saves the new product.
    */
    public function store(Request $request)
    {
        // * Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:10',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        // * Create a new Product instance
        $product = new Product();
        $product->title = $validatedData['title']; // ✅ Assign title
        $product->name = $validatedData['name'];
        $product->author = $validatedData['author']; // ✅ Assign author
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->category_id = $validatedData['category_id'];
        $product->stock = $validatedData['stock'];

        // * Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName); // * Move the image to the public directory
            $product->image = $imageName; // ✅ Store the image name in the database
        }

        // * Save the product to the database
        $product->save();

        // * Redirect back to the products list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // ==========================================================
    // Show Edit Form
    // ==========================================================
    /*
    This method shows the edit form for a product.
    It fetches the product by ID and passes the categories to the view for editing.
    */
    public function edit($id)
    {
        // * Fetch the product by ID
        $product = Product::findOrFail($id);
        // * Fetch all categories
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories')); // * Return the edit form with product and categories
    }

    // ==========================================================
    // Update Product
    // ==========================================================
    /*
    This method handles updating an existing product.
    It validates the updated data and handles image replacement if needed.
    */
    public function update(Request $request, $id)
    {
        // * Validate the input data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // * Find the product by ID
        $product = Product::findOrFail($id);
        // * Update the product attributes
        $product->title = $validatedData['title'];
        $product->name = $validatedData['name'];
        $product->author = $validatedData['author'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->stock = $validatedData['stock'];
        $product->category_id = $validatedData['category_id'];

        // * Handle Image Update
        if ($request->hasFile('image')) {
            // * Delete the old image if it exists
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
            // * Upload the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName); // * Move new image to public directory
            $product->image = $imageName; // ✅ Store the new image name
        }

        // * Save the updated product to the database
        $product->save();

        // * Redirect back to the products list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // ==========================================================
    // Soft Delete Product
    // ==========================================================
    /*
    This method handles soft deletion of a product.
    It does not remove the product from the database but marks it as deleted.
    */
    public function softDelete(Request $request, $id)
    {
        // * Find the product by ID
        $product = Product::findOrFail($id);
        // * Soft delete the product (mark as deleted)
        $product->delete();

        // * Redirect back to the products list with success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');

    }
    public function bulkDelete(Request $request)
{
    $ids = $request->input('ids');

    if (!$ids || !is_array($ids)) {
        return back()->with('error', 'No products selected.');
    }

    Product::whereIn('id', $ids)->delete();

    return back()->with('success', 'Selected products have been deleted successfully.');
}


}
