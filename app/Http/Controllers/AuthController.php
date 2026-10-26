<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            // Jika Guru
            elseif (Auth::user()->role === 'guru') {
                return redirect()->intended('/guru/dashboard');
            }
              // Jika Pembimbing PKL (TAMBAHKAN INI)
            elseif (Auth::user()->role === 'pembimbing') {
                return redirect()->intended('/pembimbing/dashboard');
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

    // ==========================================
    // FITUR BARU: REGISTER (SIGN UP)
    // ==========================================

    // 4. Menampilkan halaman form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // 5. Memproses data register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' artinya harus ada input password_confirmation
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role untuk pendaftar baru adalah 'user' (Siswa)
        ]);

        // Otomatis login setelah berhasil daftar
        Auth::login($user);

        // Arahkan ke dashboard user
        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }
}