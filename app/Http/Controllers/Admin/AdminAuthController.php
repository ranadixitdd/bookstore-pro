<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User; 
use App\Models\Order; 
use App\Models\Product; 

class AdminAuthController extends Controller
{
    // ==========================================================
    // Show login page
    // ==========================================================
    /*
    This method will show the login page for the admin to enter credentials.
    It returns the 'admin.dashboard' view.
    */
    public function showLoginForm()
    {
        return view('admin.dashboard');
    }

    // ==========================================================
    // Handle admin login
    // ==========================================================
    /*
    This method is responsible for handling the admin login request.
    - It validates the login form data (email and password).
    - It checks if the provided email exists in the Admin model.
    - If a match is found, it verifies the password and logs the admin in by storing the admin ID in the session.
    - If successful, it redirects to the admin dashboard.
    - If login fails, it returns an error message.
    */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',    // * Validates that email is required and in the correct format
            'password' => 'required',       // * Validates that password is required
        ]);

        // Find the admin by email
        $admin = Admin::where('email', $request->email)->first(); // * Retrieves the admin using the email

        // If the admin exists and the password matches, log the admin in
        if ($admin && Hash::check($request->password, $admin->password)) { // * Password comparison with hashed value
            session(['admin_id' => $admin->id]); // * Store the admin ID in the session for authentication
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!'); // * Redirects to dashboard on success
        }

        // If login fails, return back with an error
        return back()->with('error', 'Invalid email or password.'); // * Shows error message on failure
    }

    // ==========================================================
    // Show admin dashboard
    // ==========================================================
    /*
    This method displays the admin dashboard.
    - It first checks if the admin is logged in by checking the session.
    - If not logged in, redirects to the login page with an error message.
    - If logged in, it counts the total users, orders, and products and passes that data to the view.
    */
    public function dashboard()
    {
        if (!session()->has('admin_id')) { // * Check if the session contains the admin ID to confirm login status
            return redirect()->route('login')->with('error', 'Please log in first.'); // * Redirects to login page if not logged in
        }

        // Fetch count of users, orders, and products for the dashboard
        $totalUsers = User::count(); // ✅ Count all registered users
        $totalOrders = Order::count(); // ✅ Count all orders
        $totalProducts = Product::count(); // ✅ Count all products

        // Pass the data to the dashboard view
        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'totalProducts')); // * Render the dashboard view with data
    }

    // ==========================================================
    // Handle admin logout
    // ==========================================================
    /*
    This method handles the admin logout.
    - It clears the admin's session data.
    - Then, it redirects the admin back to the login page with a success message.
    */
    public function logout()
    {
        session()->forget('admin_id'); // * Remove the admin ID from session to log out
        return redirect()->route('login')->with('success', 'Admin logged out successfully.'); // * Redirects to login with success message
    }
}
