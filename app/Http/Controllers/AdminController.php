<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman utama admin
    public function index()
    {
        $semuaAbsensi = Absensi::with('user')->orderBy('tanggal', 'desc')->paginate(10);
        $semuaPengguna = User::with('sekolah')->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10);
        $totalUser = User::count();

        return view('dashboard.admin', compact('semuaAbsensi', 'semuaPengguna', 'totalUser'));
    }

    // 2. FUNGSI KHUSUS PEMBIMBING: Hanya menampilkan Manajemen Siswa (Tanpa Tab Absensi)
    public function manajemenSiswa()
    {
        $semuaPengguna = User::with('sekolah')->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10);
        $totalUser = User::count();

        // Arahkan ke view baru yang lebih sederhana
        return view('dashboard.manajemen_siswa', compact('semuaPengguna', 'totalUser'));
    }

    // 3. Fungsi untuk menampilkan form tambah user
    public function createUser()
    {
        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        return view('dashboard.tambah_user', compact('daftarSekolah'));
    }

    // 4. Fungsi untuk menyimpan user baru ke database
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => [
                'required',
                'string',
                Rule::in(Auth::user()->role === 'admin' ? ['user', 'guru', 'pembimbing'] : ['user', 'guru'])
            ],
            'sekolah_id' => 'nullable|exists:sekolahs,id',
        ], [
            'role.in' => 'Anda tidak memiliki izin untuk membuat role ini.'
        ]);

        // LOGIKA OTOMATIS KODE KARTU
        $kode_kartu = null;
        if ($request->role === 'user') {
            $lastSiswa = User::where('role', 'user')
                             ->whereNotNull('kode_kartu')
                             ->orderBy('id', 'desc')
                             ->first();

            if ($lastSiswa) {
                $lastNumber = (int) substr($lastSiswa->kode_kartu, 6); 
                $newNumber = $lastNumber + 1;
                $kode_kartu = 'SISWA-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                $kode_kartu = 'SISWA-001';
            }
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
            'sekolah_id' => $request->sekolah_id,
            'kode_kartu' => $kode_kartu, 
        ]);

        // Redirect dinamis
        if (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.siswa.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
        }
        return redirect('/admin/dashboard')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // 5. Menampilkan form edit
    public function editUser($id)
    {
        $pengguna = User::findOrFail($id);
        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        
        return view('dashboard.edit_user', compact('pengguna', 'daftarSekolah'));
    }

    // 6. Menyimpan perubahan data
    public function updateUser(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id, 
            'role' => [
                'required',
                'string',
                Rule::in(Auth::user()->role === 'admin' ? ['user', 'guru', 'pembimbing'] : ['user', 'guru'])
            ],
            'sekolah_id' => 'nullable|exists:sekolahs,id',
        ], [
            'role.in' => 'Anda tidak memiliki izin untuk mengubah ke role ini.'
        ]);

        $dataUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, 
            'sekolah_id' => $request->sekolah_id,
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

        // Redirect dinamis
        if (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.siswa.index')->with('success', 'Data pengguna berhasil diperbarui!');
        }
        return redirect('/admin/dashboard')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // 7. Menghapus data
    public function destroyUser($id)
    {
        $pengguna = User::findOrFail($id);

        if (strtolower($pengguna->role) === 'admin') {
            return back()->with('error', 'Akun Admin tidak boleh dihapus!');
        }

        $pengguna->delete();

        // Redirect dinamis
        if (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.siswa.index')->with('success', 'Pengguna berhasil dihapus!');
        }
        return redirect('/admin/dashboard')->with('success', 'Pengguna berhasil dihapus!');
    }
}