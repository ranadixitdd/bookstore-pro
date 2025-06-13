<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        // Show the "forgot password" form
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        // Validate email
        $request->validate(['email' => 'required|email']);

        // Check if user exists
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Create token manually (for demo)
        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Return the reset link directly
        $link = url(route('password.reset', ['token' => $token, 'email' => $request->email], false));

        return back()->with('status', 'Reset link generated below.')->with('reset_link', $link);
    }
}
