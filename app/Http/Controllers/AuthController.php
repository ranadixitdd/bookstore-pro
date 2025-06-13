<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // ============================ UPDATE PROFILE ============================

    public function updateProfile(Request $request)
    {
        // * Get the authenticated user
        $user = auth()->user();

        // * Check if a profile image is uploaded
        if ($request->hasFile('profile_image')) {
            // * Validate the uploaded image
            $request->validate([
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image types and limit size
            ]);

            // * Delete old profile image (if it exists) from the storage
            if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                Storage::delete('public/profile_images/' . $user->profile_image); // Delete previous image
            }

            // * Store the new profile image with a unique name (timestamp-based)
            $imageName = time() . '.' . $request->profile_image->extension(); // Generate a new name based on timestamp
            $request->profile_image->storeAs('public/profile_images', $imageName); // Store the image in the 'public/profile_images' folder

            // * Update the user's profile image in the database
            $user->profile_image = $imageName;
            $user->save(); // Save the updated user record
        }

        // * Redirect back with a success message
        return back()->with('success', 'Profile updated successfully!');
    }

    // ============================ SHOW LOGIN FORM ============================

    public function showLoginForm()
    {
        return view('auth.login'); // Return the login view (make sure this Blade file exists)
    }

    // ============================ HANDLE LOGIN REQUEST ============================

    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists
        if (!$user) {
            return back()->with('error', 'No account found with this email.');
        }

           // Check if the account is blocked
    if ($user->is_blocked) { // Assuming `is_blocked` is a boolean column
        return back()->with('error', 'Your account has been blocked. Please contact support.');
    }

        // Check if the password matches
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password. Please try again.');
        }

        // Log in the user
        Auth::login($user, $request->has('remember')); // Optional: remember me

        // Check if user is admin
        if ($user->is_admin) {
            session(['admin_id' => $user->id]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        return redirect()->route('home')->with('success', 'Welcome back!');
    }


    // ============================ SHOW REGISTRATION FORM ============================

    public function showRegister()
    {
        return view('auth.register'); // Return the registration view
    }

    // ============================ HANDLE REGISTRATION ============================

    public function register(Request $request)
    {


        //
        //registration form inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Name is required and should be a string
            'email' => 'required|email|unique:users|max:255', // Email must be unique and valid
            'password' => 'required|min:6|confirmed' // Password must be at least 6 characters and confirmed
        ]);

        // * If validation fails, return with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(); // Return to the form with validation errors
        }

        // * Create a new user record in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt password before storing
            'status' => 'active' // Set user status as active
        ]);

        // * Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Account created! Please log in.');
    }

    // ============================ LOGOUT USER ============================
    
    public function logout()
    {
        // * Log out the authenticated user
        Auth::logout();

        // * Invalidate the session to ensure complete logout
        session()->invalidate();

        // * Redirect to login page with success message
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    // ============================ SHOW PROFILE ============================
    
    public function profile()
    {
        // * Check if the user is logged in
        if (auth()->check()) {
            // * Retrieve orders related to the authenticated user
            $orders = Order::where('user_id', auth()->id())->get(); // Fetch orders associated with the user

            // * Return the profile view with the user's orders
            return view('user.profile', compact('orders'));
        }

        // * If the user is not logged in, redirect to the login page with error message
        return redirect()->route('login')->with('error', 'You must be logged in to view the profile.');
    }

    public function blockUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_blocked = true; // Set `is_blocked` to true
            $user->save();
            return redirect()->back()->with('success', 'User has been blocked successfully.');
        }
        return redirect()->back()->with('error', 'User not found.');
    }

    public function unblockUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_blocked = false; // Set `is_blocked` to false
            $user->save();
            return redirect()->back()->with('success', 'User has been unblocked successfully.');
        }
        return redirect()->back()->with('error', 'User not found.');
    }
}

