<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        $siswas = User::where('role', 'user')->whereNotNull('kode_kartu')->orderBy('name', 'asc')->get();
        return view('qr.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = User::findOrFail($id);
        $qrCode = QrCode::size(200)->generate($siswa->kode_kartu);
        return view('qr.show', compact('siswa', 'qrCode'));
    }
}