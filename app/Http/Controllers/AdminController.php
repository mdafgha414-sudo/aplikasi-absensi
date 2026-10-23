<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman utama admin
    public function index()
    {
        // Ambil semua data absensi
        $semuaAbsensi = Absensi::with('user')->orderBy('tanggal', 'desc')->paginate(10);

        // Ambil SEMUA user (Siswa DAN Guru) agar ditampilkan di tabel
        $semuaPengguna = User::orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10);

        // Hitung total user (Siswa + Guru)
        $totalUser = User::count();

        // Kirim variabel ke view
        return view('dashboard.admin', compact('semuaAbsensi', 'semuaPengguna', 'totalUser'));
    }

    // 2. Fungsi untuk menampilkan form tambah user
    public function createUser()
    {
        return view('dashboard.tambah_user');
    }

    // 3. Fungsi untuk menyimpan user baru ke database
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,guru', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);

        return redirect('/admin/dashboard')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit
    public function editUser($id)
    {
        $pengguna = User::findOrFail($id);
        return view('dashboard.edit_user', compact('pengguna'));
    }

    // 5. Menyimpan perubahan data (Termasuk Role)
    public function updateUser(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id, 
            'role' => 'required|in:user,guru', // Tambahkan validasi role
        ]);

        $pengguna->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Tambahkan update role
        ]);

        return redirect('/admin/dashboard')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // 6. Menghapus data
    public function destroyUser($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();

        return redirect('/admin/dashboard')->with('success', 'Pengguna berhasil dihapus!');
    }
}