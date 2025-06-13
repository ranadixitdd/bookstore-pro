<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ Show User Profile
    public function showProfile()
    {
        return view('user.profile');  // Return the view to display user's profile
    }

    // ✅ Edit Profile Page
    public function editProfile()
    {
        return view('user.edit');  // Return the view to edit the user's profile
    }

   // ==========================================================
// ✅ UPDATE USER PROFILE
// ==========================================================
public function update(Request $request)
{
    $request->validate([
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:500', // Validation for bio
        'old_password' => 'required_with:password|string|min:6',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user = auth()->user();

    // Check if the old password is correct
    // Check if the old password is correct
if (!Hash::check($request->old_password, $user->password)) {
    return back()->withErrors(['old_password' => 'The provided password does not match our records.']);
}
    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Delete old image if exists
        if ($user->profile_image && file_exists(public_path($user->profile_image))) {
            unlink(public_path($user->profile_image));
        }

        // Store new image
        $path = $request->file('profile_image')->store('images', 'public');
        $user->profile_image = 'storage/' . $path; // Save the path to the database
    }

    // Update other user details
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;

    // Update password if provided
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('profile')->with('success', 'Profile updated successfully.');
}
}
