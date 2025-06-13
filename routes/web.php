<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\ReviewController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
});


Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// ==========================================================
// 🔑 Authentication Routes
// ==========================================================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // Show registration form
Route::post('/register', [AuthController::class, 'register']); // Handle registration submission
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Process login credentials

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Log the user out

// ==========================================================
// 🔄 Password Reset Routes
// ==========================================================
// ( for password reset functionality)
// Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request'); // Show forgot password form
// Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email'); // Send password reset link

// ==========================================================
// 🛒 Cart & Checkout Routes
// ==========================================================
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'viewCart'])->name('cart.view'); // View current cart items
    Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add'); // Add a product to cart by id
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
 // Remove a product from cart by id
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update'); // Update quantities in the cart
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'showCheckoutForm'])->name('checkout'); // Show the checkout form
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout'); // Alternate checkout page route

    Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process'); // Process checkout details
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('checkout.placeOrder'); // Place the order after checkout
});

// ==========================================================
// 📦 Order Routes (User)
// ==========================================================
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order'); // List all orders for the user
    Route::get('/{id}', [OrderController::class, 'viewOrder'])->name('order.view'); // View details for a specific order
    Route::get('/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm'); // Confirm an order

    // Route::get('/details/{id}', [OrderController::class, 'orderDetails'])->name('order.details'); // (Commented) Possibly to show additional order details
});

// ==========================================================
// 👤 User Profile Routes
// ==========================================================
Route::prefix('profile')->group(function () {
    Route::get('/', [AuthController::class, 'profile'])->name('profile'); // Show the user's profile
    Route::post('/update', [AuthController::class, 'updateProfile'])->name('profile.update'); // Update user profile information
});

// ==========================================================
// 🔐 Admin Routes
// ==========================================================
Route::prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); // Admin logout

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); // Admin dashboard

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.index'); // List admin products
        Route::get('/add', [AdminProductController::class, 'add'])->name('admin.products.add'); // Show form to add a product
        Route::post('/store', [AdminProductController::class, 'store'])->name('admin.products.store'); // Store new product
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit'); // Edit product by id
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update'); // Update product by id
        Route::post('/delete/{id}', [AdminProductController::class, 'softDelete'])->name('admin.products.delete'); // Soft delete a product by id
    });
});


// ==========================================================
// Admin Order Management Routes
// ==========================================================
Route::prefix('admin')->group(function () {
    // ✅ Show all orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index'); // List all orders for admin

    // ✅ View specific order details
    Route::get('/orders/{id}', [AdminOrderController::class, 'view'])->name('admin.orders.view'); // View a specific order by id

    // ✅ Update order status (e.g., pending → shipped)
    Route::post('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update'); // Update status of an order by id
});

// ==========================================================
// 🌟 ADMIN USER MANAGEMENT ROUTES
// ==========================================================

// 🏠 View Users List (with search & filter)
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users'); // Show list of users for admin

// 🚫 Block User
Route::post('/admin/users/{id}/block', [AuthController::class, 'blockUser'])->name('admin.users.block');
Route::post('/admin/users/{id}/unblock', [AuthController::class, 'unblockUser'])->name('admin.users.unblock');

// ✅ Unblock User
Route::post('/admin/users/{id}/unblock', [AdminUserController::class, 'unblockUser'])->name('admin.users.unblock'); // Unblock a user by id

// ❌ Delete User
Route::post('/admin/users/{id}/delete', [AdminUserController::class, 'deleteUser'])->name('admin.users.delete'); // Delete a user by id


// ==========================================================
// 🖥️ Admin Dashboard Routes
// ==========================================================
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); // Admin dashboard (duplicate route for clarity)
});

// ===================== 👤 Normal User Routes =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile'); // Show authenticated user's profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit'); // Edit authenticated user's profile
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update'); // Update profile for authenticated user
});
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.index'); // Checkout page for non-grouped route

Route::post('/buy-now/{id}', [OrderController::class, 'buyNow'])->name('buynow'); // Immediate purchase action

Route::prefix('checkout')->group(function () {
    Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process'); // Process checkout (duplicate route for clarity)
    Route::get('/confirm', function () {
        return view('checkout.confirmation');
    })->name('checkout.confirm'); // Show checkout confirmation page
});
Route::get('/shop', function () {
    return redirect()->route('products.list');
})->name('shop'); // Redirect '/shop' to product listing

// ==========================================================
// Static Pages & Others
// ==========================================================

// About Us Page
Route::get('/about', [PageController::class, 'about'])->name('about'); // About us page

// Contact Us Page
Route::get('/contact', [PageController::class, 'contact'])->name('contact'); // Contact us page

// Privacy Policy Page
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy'); // Privacy policy page

// Terms of Service Page
Route::get('/terms-of-service', [PageController::class, 'terms'])->name('terms'); // Terms of service page

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index'); // View wishlist (authenticated users)
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle'); // Toggle wishlist item via AJAX
});

use App\Http\Controllers\Admin\ProductImportController;

Route::get('/admin/import', [ProductImportController::class, 'showImportForm'])->name('admin.import.form'); // Show product import form for admin
Route::post('/admin/import', [ProductImportController::class, 'import'])->name('admin.import'); // Process product import

// Routes for authenticated users (My Orders and Cancel)
Route::middleware('auth')->group(function () {
    // My Orders page (order history)
    Route::get('/my-orders', [OrderController::class, 'orderHistory'])->name('orders.history'); // Show order history for user

    // Cancel an order via AJAX
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel'); // Cancel an order by id
});

// Public route for order details (shows order details via show())
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show'); // Publicly display order details

// Additional routes under the "order" prefix
Route::prefix('order')->group(function () {
    // When visiting /order, show order history (same as my-orders)
    Route::get('/', [OrderController::class, 'orderHistory'])->name('order'); // Order history overview

    // For order details, use the show() method (since viewOrder() doesn't exist)
    Route::get('/{id}', [OrderController::class, 'show'])->name('order.view'); // Display order details by id

    // Confirm order route (calls confirmOrder())
    Route::get('/confirm/{id}', [OrderController::class, 'confirmOrder'])->name('order.confirm'); // Confirm order by id
});

Route::get('/admin/report', [AdminReportController::class, 'showReport'])->name('admin.report');




Route::middleware(['auth'])->group(function () {
    // Order Details for the authenticated user.
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.details');

    // Update order status.
    Route::post('orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    // Order history listing route:
    Route::get('orders', [OrderController::class, 'orderHistory'])->name('orders.history');
});
Route::patch('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
Route::post('/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('admin.reviews.reply');



// ==========================================================
// 🏠 Home & Dashboard (Public)
// ==========================================================
Route::get('/', [ProductController::class, 'home'])->name('home'); // Homepage
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard'); // Dashboard

// ==========================================================
// 🛍️ Product Routes (Public & User)
// ==========================================================
Route::prefix('products')->group(function () {
    // Product list
    Route::get('/', [ProductController::class, 'index'])->name('products.list');
    Route::get('/list', fn() => redirect()->route('products.list')); // redirect to keep legacy links working

    // Product detail: with or without optional type
    Route::get('/{id}/{type?}', [ProductController::class, 'show'])->name('products.details');

    // Search (duplicate removed below)
    Route::get('/search', [ProductController::class, 'search'])->name('product.search');
});

// ==========================================================
// 📚 Book Routes (Admin & Public)
// ==========================================================
Route::prefix('books')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('books.index');

    // CRUD
    Route::post('/add', [ProductController::class, 'store'])->name('books.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('books.edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('books.update');
    Route::post('/delete/{id}', [ProductController::class, 'destroy'])->name('books.delete');

    // Book utilities
    Route::get('/search', [ProductController::class, 'search'])->name('books.search');
    Route::get('/category/{category}', [ProductController::class, 'filterByCategory'])->name('books.category');
    Route::get('/latest', [ProductController::class, 'latestBooks'])->name('books.latest');
    Route::get('/best-sellers', [ProductController::class, 'bestSellers'])->name('books.bestSellers');
    Route::get('/recommend/{id}', [ProductController::class, 'recommendations'])->name('books.recommendations');
});

// ==========================================================
// 📝 Review Route
// ==========================================================
Route::post('/review/store/{book}', [ProductController::class, 'storeReview'])->name('review.store');


Route::delete('/admin/products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('admin.products.bulkDelete');

Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
