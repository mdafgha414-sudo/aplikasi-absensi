<?php

namespace App\Http\Controllers;

use App\Models\AlasanKeterlambatan;
use Illuminate\Http\Request;

class AlasanKeterlambatanController extends Controller
{
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
            ]
        );

        return back()->with('success', 'Alasan keterlambatan berhasil disimpan.');
    }
}