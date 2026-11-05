<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        // Ambil perusahaan beserta user-nya (Eager Loading)
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
}