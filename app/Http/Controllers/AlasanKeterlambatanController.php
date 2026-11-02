<?php

namespace App\Http\Controllers;

use App\Models\AlasanKeterlambatan;
use Illuminate\Http\Request;

class AlasanKeterlambatanController extends Controller
{
    // ==========================================
    // SISWA: MENYIMPAN ALASAN KETERLAMBATAN
    // ==========================================
    public function simpan(Request $request)
    {
        $data = $request->validate([
            'alasan' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        AlasanKeterlambatan::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'tanggal' => now('Asia/Jakarta')->toDateString(),
            ],
            [
                'alasan' => $data['alasan'],
                'is_approved' => false, 
            ]
        );

        return back()->with('success', 'Alasan keterlambatan berhasil disimpan dan dikirim ke pembimbing.');
    }

    // ==========================================
    // PEMBIMBING: MELIHAT DAFTAR (VERSI KHUSUS)
    // ==========================================
    public function indexPembimbing()
    {
        // Diperbaiki: Variabel diubah menjadi $daftarAlasan agar sesuai dengan View
        $daftarAlasan = AlasanKeterlambatan::with('user')->latest()->get();
        
        return view('dashboard.alasan_keterlambatan', compact('daftarAlasan'));
    }

    // ==========================================
    // PEMBIMBING: VERIFIKASI ALASAN
    // ==========================================
    public function verifyPembimbing($id)
    {
        $keterlambatan = AlasanKeterlambatan::findOrFail($id);
        $keterlambatan->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Alasan keterlambatan siswa berhasil disetujui.');
    }

    // ==========================================
    // GURU & PEMBIMBING: MELIHAT DAFTAR ALASAN
    // ==========================================
    public function index(Request $request)
    {
        abort_unless(in_array($request->user()->role, ['guru', 'pembimbing']), 403);

        $daftarAlasan = AlasanKeterlambatan::with('user')
           
            ->orderByDesc('tanggal')
            ->get();

        return view('dashboard.alasan_keterlambatan', compact('daftarAlasan'));
    }

    // ==========================================
    // GURU & PEMBIMBING: MENERIMA ALASAN
    // ==========================================
    public function terima(Request $request, $id)
    {
        abort_unless(in_array($request->user()->role, ['guru', 'pembimbing']), 403);

        $data = $request->validate([
            'catatan_pembimbing' => ['nullable', 'string', 'max:1000'],
        ]);

        $alasan = AlasanKeterlambatan::findOrFail($id);

        $alasan->update([
            'status' => 'Diterima',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now('Asia/Jakarta'),
            'catatan_pembimbing' => $data['catatan_pembimbing'] ?? null,
        ]);

        return back()->with('success', 'Alasan keterlambatan berhasil diterima.');
    }

    // ==========================================
    // GURU & PEMBIMBING: MENOLAK ALASAN
    // ==========================================
    public function tolak(Request $request, $id)
    {
        abort_unless(in_array($request->user()->role, ['guru', 'pembimbing']), 403);

        $data = $request->validate([
            'catatan_pembimbing' => ['nullable', 'string', 'max:1000'],
        ]);

        $alasan = AlasanKeterlambatan::findOrFail($id);

        $alasan->update([
            'status' => 'Ditolak',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now('Asia/Jakarta'),
            'catatan_pembimbing' => $data['catatan_pembimbing'] ?? null,
        ]);

        return back()->with('success', 'Alasan keterlambatan berhasil ditolak.');
    }
}