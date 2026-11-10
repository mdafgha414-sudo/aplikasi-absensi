<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerusahaanController extends Controller
{
    // ==========================================
    // 1. FUNGSI UNTUK ADMIN (Daftar, Tambah, Edit, Hapus)
    // ==========================================
    public function index()
    {
        $perusahaans = Perusahaan::with(['users' => function($query) {
            $query->orderBy('role', 'asc')->orderBy('name', 'asc');
        }])->orderBy('nama_perusahaan', 'asc')->get();
        
        return view('dashboard.perusahaan.index', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:10',
        ]);

        Perusahaan::create($request->all());
        return back()->with('success', 'Perusahaan PKL berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:10',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());
        
        return back()->with('success', 'Data Perusahaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();
        
        return back()->with('success', 'Perusahaan berhasil dihapus!');
    }

    // ==========================================
    // 2. FUNGSI KHUSUS PEMBIMBING (Hanya Edit Perusahaan Sendiri)
    // ==========================================
    
    // Menampilkan form edit perusahaan milik pembimbing
    public function editPerusahaanSendiri()
    {
        $user = Auth::user();
        
        // Pastikan yang login adalah pembimbing dan punya perusahaan
        if ($user->role !== 'pembimbing' || is_null($user->perusahaan_id)) {
            abort(403, 'Anda tidak memiliki akses atau belum terhubung ke perusahaan.');
        }

        $perusahaan = Perusahaan::findOrFail($user->perusahaan_id);
        return view('pembimbing.edit_perusahaan', compact('perusahaan'));
    }

    // Menyimpan perubahan perusahaan milik pembimbing
    public function updatePerusahaanSendiri(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'pembimbing' || is_null($user->perusahaan_id)) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $perusahaan = Perusahaan::findOrFail($user->perusahaan_id);

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:1',
        ]);

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return redirect()->back()->with('success', 'Data perusahaan berhasil diperbarui!');
    }
}