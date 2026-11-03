<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::orderBy('nama_sekolah', 'asc')->get();
        return view('dashboard.sekolah.index', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_sekolah' => 'required|string|unique:sekolahs,nama_sekolah']);
        Sekolah::create(['nama_sekolah' => $request->nama_sekolah]);
        return back()->with('success', 'Sekolah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_sekolah' => 'required|string|unique:sekolahs,nama_sekolah,' . $id]);
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update(['nama_sekolah' => $request->nama_sekolah]);
        return back()->with('success', 'Data sekolah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->delete();
        return back()->with('success', 'Sekolah berhasil dihapus!');
    }

    
        // Menampilkan form untuk mengatur siswa ke sekolah tertentu
    public function assignSiswaForm($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        // Ambil semua siswa, urutkan dari yang belum punya sekolah
        $siswas = \App\Models\User::where('role', 'user')
                    ->orderByRaw('sekolah_id IS NOT NULL ASC') // Yang NULL (belum punya) di atas
                    ->orderBy('name', 'asc')
                    ->get();
                    
        return view('dashboard.sekolah.assign', compact('sekolah', 'siswas'));
    }

    // Menyimpan hasil assign massal
    public function assignSiswaStore(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);
        
        $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:users,id'
        ]);

        // 1. Reset siswa yang sebelumnya terdaftar di sekolah ini (opsional, agar bisa update)
        \App\Models\User::where('sekolah_id', $id)->update(['sekolah_id' => null]);

        // 2. Masukkan siswa yang dicentang ke sekolah ini
        if ($request->has('siswa_ids')) {
            \App\Models\User::whereIn('id', $request->siswa_ids)
                            ->update(['sekolah_id' => $id]);
        }

        return redirect()->route('admin.sekolah.index')->with('success', 'Data siswa berhasil diperbarui untuk sekolah ' . $sekolah->nama_sekolah);
    }
}