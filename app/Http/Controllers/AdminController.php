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

        // Ambil semua karyawan (role user)
        $semuaKaryawan = User::where('role', 'user')->orderBy('name', 'asc')->paginate(10);

        // Hitung total user
        $totalUser = User::where('role', 'user')->count();

        // Kirim SEMUA variabel ke view dalam satu return
        return view('dashboard.admin', compact('semuaAbsensi', 'semuaKaryawan', 'totalUser'));
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
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // TAMBAHKAN INI: Agar setelah simpan, kembali ke dashboard
        return redirect('/admin/dashboard')->with('success', 'Karyawan baru berhasil ditambahkan!');
    }

    // 4. Menampilkan form edit
    public function editUser($id)
    {
        $karyawan = User::findOrFail($id);
        return view('dashboard.edit_user', compact('karyawan'));
    }

    // 5. Menyimpan perubahan data
    public function updateUser(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id, 
        ]);

        $karyawan->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/admin/dashboard')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // 6. Menghapus data
    public function destroyUser($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect('/admin/dashboard')->with('success', 'Karyawan berhasil dihapus!');
    }
}