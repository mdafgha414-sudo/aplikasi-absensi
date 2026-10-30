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

                // Jika alasan diedit, persetujuan harus diulang
                'status' => 'Menunggu',
                'reviewed_by' => null,
                'reviewed_at' => null,
                'catatan_pembimbing' => null,
            ]
        );

        return back()->with(
            'success',
            'Alasan keterlambatan berhasil disimpan.'
        );
    }

    // ==========================================
    // PEMBIMBING: MELIHAT DAFTAR ALASAN
    // ==========================================
    public function index(Request $request)
    {
        abort_unless(
            $request->user()->role === 'pembimbing',
            403
        );

        $daftarAlasan = AlasanKeterlambatan::with('user')
            ->orderByRaw("FIELD(status, 'Menunggu', 'Diterima', 'Ditolak')")
            ->orderByDesc('tanggal')
            ->get();

        return view('dashboard.alasan_keterlambatan', compact('daftarAlasan'));
    }

    // ==========================================
    // PEMBIMBING: MENERIMA ALASAN
    // ==========================================
    public function terima(Request $request, $id)
    {
        abort_unless(
            $request->user()->role === 'pembimbing',
            403
        );

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

        return back()->with(
            'success',
            'Alasan keterlambatan berhasil diterima.'
        );
    }

    // ==========================================
    // PEMBIMBING: MENOLAK ALASAN
    // ==========================================
    public function tolak(Request $request, $id)
    {
        abort_unless(
            $request->user()->role === 'pembimbing',
            403
        );

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

        return back()->with(
            'success',
            'Alasan keterlambatan berhasil ditolak.'
        );
    }
}
