<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Absensi;
use App\Models\AlasanKeterlambatan;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // =====================================
        // DASHBOARD ADMIN
        // =====================================
        if ($user->role === 'admin') {

            // Hitung jumlah seluruh pengguna
            $totalUser = User::count();

            // Ambil data pengguna dengan pagination
            $semuaPengguna = User::orderBy('id', 'desc')
                ->paginate(10, ['*'], 'pengguna_page');

            // Ambil laporan absensi beserta data pengguna
            $semuaAbsensi = Absensi::with('user')
                ->orderBy('tanggal', 'desc')
                ->paginate(10, ['*'], 'absensi_page');

            // Kirim seluruh variabel yang diperlukan
            // oleh dashboard admin
            return view('dashboard.admin', compact(
                'totalUser',
                'semuaPengguna',
                'semuaAbsensi'
            ));
        }

        // =====================================
        // DASHBOARD USER
        // =====================================

        // Ambil alasan keterlambatan hari ini
        $alasanTerlambatHariIni = AlasanKeterlambatan::query()
            ->where('user_id', $user->id)
            ->whereDate(
                'tanggal',
                now('Asia/Jakarta')->toDateString()
            )
            ->value('alasan');

        // Tampilkan dashboard pengguna
        return view('dashboard.user', compact(
            'alasanTerlambatHariIni'
        ));
    }
}