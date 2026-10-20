<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Memproses data login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            // Jika berhasil, buat session baru
            $request->session()->regenerate();

            // --- LOGIKA PENGALIHAN BERDASARKAN ROLE ---
            
            // Jika Admin
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } 
            // Jika Guru (Pastikan berada di dalam blok if Auth::attempt)
            elseif (Auth::user()->role === 'guru') {
                return redirect()->intended('/guru/dashboard');
            }

            // Jika User biasa (Siswa)
            return redirect()->intended('/dashboard');
        }

        // Jika gagal login (email/password salah)
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}