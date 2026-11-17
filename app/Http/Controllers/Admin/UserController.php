<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        $totalUsers = User::count();

        $totalAdmins = User::where(
            'role',
            'admin'
        )->count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        return view(
            'admin.users.index',
            compact(
                'users',
                'totalUsers',
                'totalAdmins',
                'totalCustomers'
            )
        );
    }

    public function update(
        Request $request,
        User $user
    ) {

        $request->validate([
            'role' => 'required|in:admin,customer'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with(
            'success',
            'Role user berhasil diubah'
        );
    }

    public function destroy(User $user)
    {
        if (
            auth()->id() === $user->id
        ) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun sendiri.'
            );

        }

        $user->delete();

        return back()->with(
            'success',
            'User berhasil dihapus.'
        );
    }
}