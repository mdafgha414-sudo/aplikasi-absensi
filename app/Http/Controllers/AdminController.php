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
            'role' => 'required|in:user,guru,pembimbing', 
        ]);

        // LOGIKA OTOMATIS KODE KARTU
        $kode_kartu = null;
        if ($request->role === 'user') {
            $lastSiswa = User::where('role', 'user')
                             ->whereNotNull('kode_kartu')
                             ->orderBy('id', 'desc')
                             ->first();

            if ($lastSiswa) {
                // Ambil 3 digit angka terakhir dari kode (misal "SISWA-001" -> 001)
                $lastNumber = (int) substr($lastSiswa->kode_kartu, 6); 
                $newNumber = $lastNumber + 1;
                $kode_kartu = 'SISWA-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                // Jika ini siswa pertama
                $kode_kartu = 'SISWA-001';
            }
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
            'kode_kartu' => $kode_kartu, // Simpan kode kartu yang baru dibuat
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
            'role' => 'required|in:user,guru,pembimbing', 
        ]);

        $dataUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, 
        ];

        // LOGIKA TAMBAHAN: Jika role diubah jadi 'user' tapi belum punya kode_kartu
        if ($request->role === 'user' && empty($pengguna->kode_kartu)) {
            $lastSiswa = User::where('role', 'user')
                             ->whereNotNull('kode_kartu')
                             ->orderBy('id', 'desc')
                             ->first();

            if ($lastSiswa) {
                $lastNumber = (int) substr($lastSiswa->kode_kartu, 6); 
                $newNumber = $lastNumber + 1;
                $dataUpdate['kode_kartu'] = 'SISWA-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                $dataUpdate['kode_kartu'] = 'SISWA-001';
            }
        }

        $pengguna->update($dataUpdate);

        return redirect('/admin/dashboard')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // 6. Menghapus data
    public function destroyUser($id)
    {
        $pengguna = User::findOrFail($id);

        if (strtolower($pengguna->role) === 'admin') {
            return back()->with(
                'error',
                'Akun Admin tidak boleh dihapus!'
            );
        }

        // Lanjutkan proses penghapusan yang sudah ada.
        $pengguna->delete();

        return redirect('/admin/dashboard')->with('success', 'Pengguna berhasil dihapus!');
    }
}