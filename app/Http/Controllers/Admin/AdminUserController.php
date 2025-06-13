<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AdminUserController extends Controller
{
    // ==========================================================
    // ✅ DISPLAY ALL USERS WITH SEARCH & ROLE FILTERS
    // ==========================================================
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        // 📌 Fetch only non-admin users
        $users = User::where('role', '!=', 'admin')  // ✅ Exclude admins
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->paginate(10);

        return view('admin.users', compact('users'));  // ✅ Corrected Blade file path
    }

    // ==========================================================
    // ✅ BLOCK USER (UPDATE STATUS TO BLOCKED)
    // ==========================================================
    public function blockUser($id)
{
    $user = User::findOrFail($id);
    $user->update(['is_blocked' => 1]); // ✅ Change status to blocked
    return back()->with('success', 'User has been blocked.');
}

    // ==========================================================
    // ✅ UNBLOCK USER (UPDATE STATUS TO ACTIVE)
    // ==========================================================
    public function unblockUser($id)
{
    $user = User::findOrFail($id);
    $user->update(['is_blocked' => 0]); // ✅ Change status to active
    return back()->with('success', 'User has been unblocked.');
}

    // ==========================================================
    // ✅ DELETE USER (SOFT DELETE)
    // ==========================================================
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();  // ✅ Soft delete the user
        Session::flash('success', 'User deleted successfully.');
        return back();
    }

    // ==========================================================
    // ✅ RESTORE DELETED USER
    // ==========================================================
    public function restoreUser($id)
{
    $user = User::withTrashed()->findOrFail($id);  // ✅ Fetch deleted users
    $user->restore();  // ✅ Restore user
    Session::flash('success', 'User restored successfully.');
    return back();
}
}
