<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHAN

class SekolahController extends Controller
{
    public function index()
    {
        // 1. Cek role user yang login
        if (Auth::user()->role === 'pembimbing') {
            // Pembimbing: Hanya lihat sekolah yang DIA buat
            $sekolahs = Sekolah::where('user_id', Auth::id())
                               ->orderBy('nama_sekolah', 'asc')
                               ->get();
        } else {
            // Admin: Lihat SEMUA sekolah beserta nama pembuatnya
            $sekolahs = Sekolah::with('user')
                               ->orderBy('nama_sekolah', 'asc')
                               ->get();
        }

        return view('dashboard.sekolah.index', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_sekolah' => 'required|string|unique:sekolahs,nama_sekolah']);
        
        // 2. Simpan nama sekolah beserta user_id pembuatnya
        Sekolah::create([
            'nama_sekolah' => $request->nama_sekolah,
            'user_id' => Auth::id(), // <-- Penting!
        ]);
        
        return back()->with('success', 'Sekolah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // 3. KEAMANAN: Pembimbing tidak boleh edit sekolah buatan orang lain
        if (Auth::user()->role === 'pembimbing' && $sekolah->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengedit sekolah ini.');
        }

        $request->validate(['nama_sekolah' => 'required|string|unique:sekolahs,nama_sekolah,' . $id]);
        
        $sekolah->update(['nama_sekolah' => $request->nama_sekolah]);
        
        return back()->with('success', 'Data sekolah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // 4. KEAMANAN: Pembimbing tidak boleh hapus sekolah buatan orang lain
        if (Auth::user()->role === 'pembimbing' && $sekolah->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak menghapus sekolah ini.');
        }

        $sekolah->delete();
        return back()->with('success', 'Sekolah berhasil dihapus!');
    }

    public function assignSiswaForm($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // KEAMANAN: Pastikan hanya pembuatnya yang bisa atur siswa
        if (Auth::user()->role === 'pembimbing' && $sekolah->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengatur siswa di sekolah ini.');
        }

        $siswas = \App\Models\User::where('role', 'user')
                    ->orderByRaw('sekolah_id IS NOT NULL ASC')
                    ->orderBy('name', 'asc')
                    ->get();
                    
        return view('dashboard.sekolah.assign', compact('sekolah', 'siswas'));
    }

    public function assignSiswaStore(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // KEAMANAN
        if (Auth::user()->role === 'pembimbing' && $sekolah->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengatur siswa di sekolah ini.');
        }
        
        $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:users,id'
        ]);

        \App\Models\User::where('sekolah_id', $id)->update(['sekolah_id' => null]);

        if ($request->has('siswa_ids')) {
            \App\Models\User::whereIn('id', $request->siswa_ids)
                            ->update(['sekolah_id' => $id]);
        }

        // Redirect dinamis (karena admin dan pembimbing punya route index sendiri)
        if (Auth::user()->role === 'pembimbing') {
            return redirect()->route('pembimbing.sekolah.index')->with('success', 'Data siswa berhasil diperbarui.');
        }
        return redirect()->route('admin.sekolah.index')->with('success', 'Data siswa berhasil diperbarui untuk sekolah ' . $sekolah->nama_sekolah);
    }
}