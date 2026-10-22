<?php
namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_izin' => 'required|in:Izin,Sakit,Keperluan Keluarga',
            'tanggal_izin' => 'required|date|after_or_equal:today',
            'alasan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')
                ->store('lampiran-izin', 'public');
        }

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'Menunggu';

        Izin::create($data);

        return redirect()->back()->with(
            'success',
            'Pengajuan izin berhasil dikirim dan sedang menunggu persetujuan.'
        );
    }
}
