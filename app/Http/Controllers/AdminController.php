<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan form pemilihan admin
    public function showSelectAdminForm()
    {
        $admins = Admin::all(); // Ambil semua admin untuk dropdown
        return view('auth.select-admin', compact('admins'));
    }

    // Proses pemilihan admin
    public function selectAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
        ]);

        $admin = Admin::findOrFail($request->admin_id);

        // Login menggunakan Auth (sesi)
        Auth::guard('admin')->login($admin);

        // Redirect ke halaman items
        return redirect()->route('items.index')->with('success', 'Successfully selected admin: ' . $admin->username);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.select.form')->with('success', 'Logged out successfully');
    }
}