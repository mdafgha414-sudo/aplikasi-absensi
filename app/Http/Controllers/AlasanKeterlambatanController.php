<?php

namespace App\Http\Controllers;

use App\Models\AlasanKeterlambatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlasanKeterlambatanController extends Controller
{
    // ==========================================
    // SISWA: MENYIMPAN ALASAN KETERLAMBATAN
    // ==========================================
    public function simpan(Request $request)
    {
        // VALIDASI TAMBAHAN: Cegah siswa tanpa perusahaan/sekolah mengirim alasan
        if (is_null($request->user()->perusahaan_id) && is_null($request->user()->sekolah_id)) {
            return back()->with('error', 'Anda belum terdaftar di perusahaan atau sekolah manapun. Tidak bisa mengirim alasan.');
        }

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
        $pembimbing = Auth::user();
        
        $daftarAlasan = AlasanKeterlambatan::with('user')
            ->whereHas('user', function ($query) use ($pembimbing) {
                
                // PENGAMAN GANDA: Filter berdasarkan Perusahaan ATAU Sekolah
                // Kita gunakan query grouping agar logikanya (A AND B) OR (C AND D)
                $query->where(function($q) use ($pembimbing) {
                    
                    // Cek Perusahaan (Jika pembimbing punya perusahaan_id)
                    if ($pembimbing->perusahaan_id) {
                        $q->where('perusahaan_id', $pembimbing->perusahaan_id);
                    } 
                    // Cek Sekolah (Jika pembimbing punya sekolah_id)
                    elseif ($pembimbing->sekolah_id) {
                        $q->where('sekolah_id', $pembimbing->sekolah_id);
                    }

                });
                
            })
            ->latest()
            ->get();
        
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

        $user = $request->user();
        $query = AlasanKeterlambatan::with('user');

        // Filter KHUSUS jika yang login adalah Pembimbing
        if ($user->role === 'pembimbing') {
            $query->whereHas('user', function ($q) use ($user) {
                
                // Gunakan logika pengaman ganda yang sama seperti di atas
                $q->where(function($subQ) use ($user) {
                    if ($user->perusahaan_id) {
                        $subQ->where('perusahaan_id', $user->perusahaan_id);
                    } elseif ($user->sekolah_id) {
                        $subQ->where('sekolah_id', $user->sekolah_id);
                    }
                });

            });
        }

        $daftarAlasan = $query->orderByDesc('tanggal')->get();

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