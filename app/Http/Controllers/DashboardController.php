<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Cek role-nya
        if ($user->role === 'admin') {
            // Jika admin, tampilkan view dashboard/admin.blade.php
            return view('dashboard.admin'); 
        }

        // Jika user biasa, tampilkan view dashboard/user.blade.php
        return view('dashboard.user'); 
    }
}