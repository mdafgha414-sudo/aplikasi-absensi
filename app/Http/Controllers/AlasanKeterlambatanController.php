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
    // GURU & PEMBIMBING: MELIHAT DAFTAR ALASAN
    // ==========================================
    public function index(Request $request)
    {
        // Izinkan Guru dan Pembimbing
        abort_unless(
            in_array($request->user()->role, ['guru', 'pembimbing']),
            403
        );

        $daftarAlasan = AlasanKeterlambatan::with('user')
            ->orderByRaw("FIELD(status, 'Menunggu', 'Diterima', 'Ditolak')")
            ->orderByDesc('tanggal')
            ->get();

        // KITA ARAHKAN KE FOLDER 'dashboard' KARENA FILE-NYA ADA DI SANA
        if ($request->user()->role === 'guru') {
            return view('dashboard.alasan_keterlambatan', compact('daftarAlasan'));
        }

        // Pembimbing
        return view('dashboard.alasan_keterlambatan', compact('daftarAlasan'));
    }

    // ==========================================
    // GURU & PEMBIMBING: MENERIMA ALASAN
    // ==========================================
    public function terima(Request $request, $id)
    {
        // Izinkan Guru dan Pembimbing
        abort_unless(
            in_array($request->user()->role, ['guru', 'pembimbing']),
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
    // GURU & PEMBIMBING: MENOLAK ALASAN
    // ==========================================
    public function tolak(Request $request, $id)
    {
        // Izinkan Guru dan Pembimbing
        abort_unless(
            in_array($request->user()->role, ['guru', 'pembimbing']),
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