<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman utama admin (Daftar Perusahaan)
    public function index()
    {
        // Hanya hitung total user untuk ditampilkan di header
        $totalUser = User::count();

        return view('dashboard.admin', compact('totalUser'));
    }

    // 2. FUNGSI BARU: Menampilkan Detail Perusahaan (Anggota & Absensi)
    public function detailPerusahaan($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        
        // Ambil user HANYA dari perusahaan ini
        $semuaPengguna = User::with('sekolah')
                             ->where('perusahaan_id', $id)
                             ->orderBy('role', 'asc')
                             ->orderBy('name', 'asc')
                             ->paginate(10, ['*'], 'page_pengguna'); // Pagination terpisah

        // Ambil data absensi user di perusahaan ini
        $semuaAbsensi = Absensi::whereHas('user', function($q) use ($id) {
                                $q->where('perusahaan_id', $id);
                             })
                             ->with('user')
                             ->orderBy('tanggal', 'desc')
                             ->paginate(10, ['*'], 'page_absensi'); // Pagination terpisah

        $totalUser = User::where('perusahaan_id', $id)->count();

        return view('dashboard.admin_detail', compact('perusahaan', 'semuaPengguna', 'semuaAbsensi', 'totalUser'));
    }

    // 3. FUNGSI KHUSUS PEMBIMBING
    public function manajemenSiswa()
    {
        $user = Auth::user();

        $query = User::with('sekolah', 'perusahaan')
                     ->where('perusahaan_id', $user->perusahaan_id)
                     ->orderBy('role', 'asc')
                     ->orderBy('name', 'asc');

        $semuaPengguna = $query->paginate(10);
        $totalUser = User::where('perusahaan_id', $user->perusahaan_id)->count();

        return view('dashboard.manajemen_siswa', compact('semuaPengguna', 'totalUser'));
    }

        // FUNGSI BARU: Manajemen Siswa Global (Khusus Admin)
    public function manajemenSiswaAdmin(Request $request)
    {
        $query = User::with('sekolah', 'perusahaan');

        // Filter berdasarkan Role
        if ($request->filled('role') && $request->role != 'Semua') {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan Sekolah
        if ($request->filled('sekolah') && $request->sekolah != 'Semua') {
            $query->where('sekolah_id', $request->sekolah);
        }

        // Filter berdasarkan Perusahaan
        if ($request->filled('perusahaan') && $request->perusahaan != 'Semua') {
            $query->where('perusahaan_id', $request->perusahaan);
        }

        // Pencarian Nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $semuaPengguna = $query->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $totalUser = $query->count();
        
        $daftarSekolah = Sekolah::orderBy('nama_sekolah')->get();
        $daftarPerusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        return view('dashboard.manajemen_siswa_admin', compact('semuaPengguna', 'totalUser', 'daftarSekolah', 'daftarPerusahaan'));
    }

    // 4. Fungsi untuk menampilkan form tambah user
    public function createUser()
    {
        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        $daftarPerusahaan = Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        return view('dashboard.tambah_user', compact('daftarSekolah', 'daftarPerusahaan'));
    }

    // 5. Fungsi untuk menyimpan user baru ke database
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
            'perusahaan_id' => 'nullable|exists:perusahaans,id',
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

        // KEAMANAN: Paksa perusahaan_id sesuai role yang login
        $perusahaanId = Auth::user()->role === 'pembimbing' 
                        ? Auth::user()->perusahaan_id 
                        : $request->perusahaan_id;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
            'sekolah_id' => $request->sekolah_id,
            'perusahaan_id' => $perusahaanId,
            'kode_kartu' => $kode_kartu, 
        ]);

        // Redirect dinamis
        if (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.siswa.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
        }
        return redirect('/admin/dashboard')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // 6. Menampilkan form edit
    public function editUser($id)
    {
        $pengguna = User::findOrFail($id);
        
        // KEAMANAN: Pembimbing tidak boleh mengedit user dari perusahaan lain
        if (Auth::user()->role === 'pembimbing' && $pengguna->perusahaan_id !== Auth::user()->perusahaan_id) {
            return back()->with('error', 'Anda tidak memiliki akses ke user ini.');
        }

        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        $daftarPerusahaan = Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        
        return view('dashboard.edit_user', compact('pengguna', 'daftarSekolah', 'daftarPerusahaan'));
    }

    // 7. Menyimpan perubahan data
    public function updateUser(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        // KEAMANAN: Pembimbing tidak boleh mengedit user dari perusahaan lain
        if (Auth::user()->role === 'pembimbing' && $pengguna->perusahaan_id !== Auth::user()->perusahaan_id) {
            return back()->with('error', 'Anda tidak memiliki akses ke user ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id, 
            'role' => [
                'required',
                'string',
                Rule::in(Auth::user()->role === 'admin' ? ['user', 'guru', 'pembimbing'] : ['user', 'guru'])
            ],
            'sekolah_id' => 'nullable|exists:sekolahs,id',
            'perusahaan_id' => 'nullable|exists:perusahaans,id',
        ], [
            'role.in' => 'Anda tidak memiliki izin untuk mengubah ke role ini.'
        ]);

        // KEAMANAN: Paksa perusahaan_id sesuai role yang login
        $perusahaanId = Auth::user()->role === 'pembimbing' 
                        ? Auth::user()->perusahaan_id 
                        : $request->perusahaan_id;

        $dataUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, 
            'sekolah_id' => $request->sekolah_id,
            'perusahaan_id' => $perusahaanId,
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

    // 8. Menghapus data
    public function destroyUser($id)
    {
        $pengguna = User::findOrFail($id);

        // KEAMANAN: Pembimbing tidak boleh menghapus user dari perusahaan lain
        if (Auth::user()->role === 'pembimbing' && $pengguna->perusahaan_id !== Auth::user()->perusahaan_id) {
            return back()->with('error', 'Anda tidak memiliki akses ke user ini.');
        }

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