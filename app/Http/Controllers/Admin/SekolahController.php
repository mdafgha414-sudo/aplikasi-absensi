<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SekolahController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pembimbing') {
            $sekolahs = Sekolah::where(function($query) use ($user) {
                            $query->where('user_id', $user->id)
                                  ->orWhereHas('users', function($q) use ($user) {
                                      $q->where('perusahaan_id', $user->perusahaan_id);
                                  });
                        })
                        ->with('user')
                        ->orderBy('nama_sekolah', 'asc')
                        ->get();
        } else {
            $sekolahs = Sekolah::with('user')->orderBy('nama_sekolah', 'asc')->get();
        }

        return view('dashboard.sekolah.index', compact('sekolahs'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_sekolah' => 'required|string|unique:sekolahs,nama_sekolah']);
        
        Sekolah::create([
            'nama_sekolah' => $request->nama_sekolah,
            'user_id' => Auth::id(),
        ]);
        
        return back()->with('success', 'Sekolah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

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

        if (Auth::user()->role === 'pembimbing' && $sekolah->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak menghapus sekolah ini.');
        }

        $sekolah->delete();
        return back()->with('success', 'Sekolah berhasil dihapus!');
    }

    public function assignSiswaForm($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $user = Auth::user();

        $querySiswa = User::where('role', 'user');

        if ($user->role === 'pembimbing') {
            $querySiswa->where('perusahaan_id', $user->perusahaan_id);
        }

        $siswas = $querySiswa->orderByRaw('sekolah_id IS NOT NULL ASC')
                    ->orderBy('name', 'asc')
                    ->get();
                    
        return view('dashboard.sekolah.assign', compact('sekolah', 'siswas'));
    }

    public function assignSiswaStore(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $user = Auth::user();
        
        $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:users,id'
        ]);

        $validSiswaIds = [];
        if ($request->has('siswa_ids')) {
            $validSiswaIds = User::whereIn('id', $request->siswa_ids)
                                 ->where('role', 'user')
                                 ->when($user->role === 'pembimbing', function($q) use ($user) {
                                     return $q->where('perusahaan_id', $user->perusahaan_id);
                                 })
                                 ->pluck('id')
                                 ->toArray();
        }

        User::where('sekolah_id', $id)
            ->when($user->role === 'pembimbing', function($q) use ($user) {
                return $q->where('perusahaan_id', $user->perusahaan_id);
            })
            ->update(['sekolah_id' => null]);

        if (!empty($validSiswaIds)) {
            User::whereIn('id', $validSiswaIds)
                ->update(['sekolah_id' => $id]);
        }

        // ===============================================
        // INI BAGIAN YANG SAYA UBAH (PAKAI URL LANGSUNG)
        // ===============================================
        if ($user->role === 'pembimbing') {
            return redirect('/pembimbing/sekolah')->with('success', 'Data siswa berhasil diperbarui.');
        }
        return redirect('/admin/sekolah')->with('success', 'Data siswa berhasil diperbarui untuk sekolah ' . $sekolah->nama_sekolah);
    }
}