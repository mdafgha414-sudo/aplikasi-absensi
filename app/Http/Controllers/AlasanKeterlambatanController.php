<?php

namespace App\Http\Controllers;

use App\Models\AlasanKeterlambatan;
use Illuminate\Http\Request;

class AlasanKeterlambatanController extends Controller
{
    // Disimpan oleh siswa dari form dashboard siswa
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
                'is_approved' => false, // Reset status jadi belum disetujui jika diperbarui
            ]
        );

        return back()->with('success', 'Alasan keterlambatan berhasil disimpan dan dikirim ke pembimbing.');
    }

    // Ditampilkan di Dashboard Pembimbing
    public function indexPembimbing()
    {
        $dataKeterlambatan = AlasanKeterlambatan::with('user')->latest()->get();
        
        return view('pembimbing.keterlambatan', compact('dataKeterlambatan'));
    }

    // Verifikasi oleh Pembimbing
    public function verifyPembimbing($id)
    {
        $keterlambatan = AlasanKeterlambatan::findOrFail($id);
        
        $keterlambatan->update([
            'is_approved' => true
        ]);

        return redirect()->back()->with('success', 'Alasan keterlambatan siswa berhasil disetujui.');
    }
}