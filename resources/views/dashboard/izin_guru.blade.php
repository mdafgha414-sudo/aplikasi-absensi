@extends('layouts.app')

@section('content')

<style>
    /* CSS PERSIS SEPERTI GAMBAR */
    .rekap-page {
        background: #f4f7fc;
        min-height: 100vh;
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .rekap-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        padding: 30px;
    }

    /* HEADER */
    .rekap-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .header-icon {
        width: 50px; height: 50px; background: #e8f0fe; color: #1a73e8;
        border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px;
    }
    .header-title { font-size: 24px; font-weight: 700; color: #202124; margin: 0 0 5px 0; }
    .header-desc { font-size: 14px; color: #5f6368; margin: 0; }

    /* FILTER BAR (Bulan, Tahun, Search, Kelas) */
    .filter-bar { display: flex; gap: 15px; margin-bottom: 25px; flex-wrap: wrap; }
    .filter-group {
        display: flex; align-items: center; background: #fff; border: 1px solid #dadce0;
        border-radius: 8px; padding: 0 15px; height: 45px; color: #3c4043;
    }
    .filter-group i { color: #5f6368; margin-right: 10px; font-size: 18px; }
    .filter-group select, .filter-group input {
        border: none; outline: none; background: transparent; font-size: 14px; color: #3c4043; width: 100%; height: 100%;
    }
    
    .filter-bulan { width: 180px; }
    .filter-tahun { width: 120px; }
    .filter-search { flex: 1; min-width: 250px; }
    .filter-kelas { width: 200px; }

    /* TABEL MATRIKS */
    .table-responsive { overflow-x: auto; border: 1px solid #e0e0e0; border-radius: 8px; }
    .rekap-table { width: 100%; border-collapse: collapse; min-width: 900px; text-align: center; }
    
    .rekap-table th, .rekap-table td { border: 1px solid #e0e0e0; padding: 15px 10px; }
    
    .rekap-table thead th { background: #f8f9fa; font-weight: 600; color: #3c4043; font-size: 14px; }
    .rekap-table thead th .day-name { display: block; font-size: 12px; color: #80868b; font-weight: 400; margin-top: 3px; }
    
    .rekap-table td:first-child, .rekap-table th:first-child { text-align: center; width: 50px; font-weight: 600; color: #3c4043; }
    .rekap-table td:nth-child(2), .rekap-table th:nth-child(2) { text-align: left; padding-left: 20px; min-width: 200px; }

    /* AVATAR & NAMA */
    .student-info { display: flex; align-items: center; gap: 12px; }
    .avatar-circle {
        width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; color: #fff;
    }
    .bg-av-1 { background: #a8c0ff; color: #1a3b8b; }
    .bg-av-2 { background: #d4b4ff; color: #5b2c8b; }
    .bg-av-3 { background: #ffb4c0; color: #8b2c3d; }
    .bg-av-4 { background: #b4ffd4; color: #2c8b5b; }

    .student-name { font-weight: 500; color: #202124; font-size: 14px; }

    /* STATUS ICONS (KOTAK MEMBULAT) */
    .status-box {
        width: 28px; height: 28px; border-radius: 6px; display: inline-flex;
        align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;
        text-decoration: none; transition: transform 0.2s;
    }
    .status-box.clickable:hover { transform: scale(1.15); cursor: pointer; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
    
    .status-hadir { background: #1e8e3e; } /* Hijau */
    .status-izin { background: #1a73e8; }  /* Biru */
    .status-sakit { background: #f9ab00; } /* Kuning */
    .status-alpa { background: #d93025; }  /* Merah */
    .status-empty { background: #f1f3f4; color: #bdc1c6; } /* Abu-abu */

    /* LEGENDA BAWAH */
    .legend-bar {
        display: flex; gap: 20px; margin-top: 20px; padding: 15px 20px;
        background: #f8f9fa; border-radius: 8px; border: 1px solid #e0e0e0;
        font-size: 14px; color: #3c4043; font-weight: 500;
    }
    .legend-item { display: flex; align-items: center; gap: 8px; }
    .legend-icon {
        width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;
    }

    .scroll-hint {
        text-align: right; font-size: 12px; color: #80868b; margin-top: 15px;
    }
</style>

<div class="rekap-page">
    <div class="rekap-card">
        
        <!-- HEADER -->
        <div class="rekap-header">
            <div class="header-icon">
                <i class="bi bi-calendar3"></i>
            </div>
            <div>
                <h2 class="header-title">Rekap Kehadiran Siswa</h2>
                <p class="header-desc">Pantau status kehadiran siswa berdasarkan tanggal. Klik kotak Izin (I) atau Sakit (S) untuk melihat lampiran.</p>
            </div>
        </div>

        <!-- FILTER BAR -->
        <form action="" method="GET" class="filter-bar">
            <div class="filter-group filter-bulan">
                <i class="bi bi-calendar-event"></i>
                <select name="bulan" onchange="this.form.submit()">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="filter-group filter-tahun">
                <i class="bi bi-calendar-range"></i>
                <select name="tahun" onchange="this.form.submit()">
                    @for ($i = date('Y') - 2; $i <= date('Y') + 5; $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="filter-group filter-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa...">
            </div>

            <div class="filter-group filter-kelas">
                <i class="bi bi-people"></i>
                <select>
                    <option>Semua Kelas</option>
                </select>
            </div>
        </form>

        <!-- TABEL MATRIKS -->
        <div class="table-responsive">
            <table class="rekap-table" id="rekapTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        @foreach($tanggalList as $tgl)
                            <th>
                                {{ $tgl->format('d') }}
                                <span class="day-name">{{ $tgl->format('D') }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                        <tr class="student-row">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="student-info">
                                    <div class="avatar-circle bg-av-{{ ($index % 4) + 1 }}">
                                        {{ strtoupper(substr($s->name, 0, 2)) }}
                                    </div>
                                    <span class="student-name">{{ $s->name }}</span>
                                </div>
                            </td>
                            @foreach($tanggalList as $tgl)
                                @php
                                    $key = $s->id . '-' . $tgl->format('d');
                                    $statusAbsen = isset($absensi[$key]) ? $absensi[$key]->status : null;
                                    $dataIzin = isset($izin[$key]) ? $izin[$key] : null;
                                    
                                    // Prioritas Izin, lalu Absensi
                                    $finalStatus = $dataIzin ? $dataIzin->jenis_izin : $statusAbsen;
                                    if (!$finalStatus && $tgl->isWeekend()) $finalStatus = 'Libur';
                                    
                                    // Siapkan data JSON untuk modal (jika ada izin)
                                    $jsonIzin = '';
                                    if ($dataIzin) {
                                        $jsonIzin = json_encode([
                                            'nama' => $s->name,
                                            'tanggal' => $tgl->format('d M Y'),
                                            'jenis' => $dataIzin->jenis_izin,
                                            'alasan' => $dataIzin->alasan,
                                            'lampiran' => $dataIzin->lampiran ? asset('storage/' . $dataIzin->lampiran) : null
                                        ]);
                                    }
                                @endphp
                                <td>
                                    @if($finalStatus == 'Hadir' || $finalStatus == 'Tepat Waktu')
                                        <span class="status-box status-hadir"><i class="bi bi-check-lg"></i></span>
                                    @elseif($finalStatus == 'Izin')
                                        <a href="javascript:void(0)" class="status-box status-izin clickable" onclick="showDetailIzin({{ $jsonIzin }})">I</a>
                                    @elseif($finalStatus == 'Sakit')
                                        <a href="javascript:void(0)" class="status-box status-sakit clickable" onclick="showDetailIzin({{ $jsonIzin }})">S</a>
                                    @elseif($finalStatus == 'Alpa' || $finalStatus == 'Tidak Hadir')
                                        <span class="status-box status-alpa">A</span>
                                    @elseif($finalStatus == 'Libur')
                                        <span class="status-box status-empty"><i class="bi bi-dot" style="font-size:24px; line-height:0;"></i></span>
                                    @else
                                        <span class="status-box status-empty"><i class="bi bi-dot" style="font-size:24px; line-height:0;"></i></span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- LEGENDA BAWAH -->
        <div class="legend-bar">
            <div class="legend-item">
                <div class="legend-icon status-hadir"><i class="bi bi-check-lg"></i></div> Hadir
            </div>
            <div class="legend-item">
                <div class="legend-icon status-izin">I</div> Izin <span style="font-size: 11px; color: #80868b; margin-left: 5px;">(Bisa diklik)</span>
            </div>
            <div class="legend-item">
                <div class="legend-icon status-sakit">S</div> Sakit <span style="font-size: 11px; color: #80868b; margin-left: 5px;">(Bisa diklik)</span>
            </div>
            <div class="legend-item">
                <div class="legend-icon status-alpa">A</div> Alpa
            </div>
        </div>

        <div class="scroll-hint">
            <i class="bi bi-info-circle"></i> Geser horizontal untuk melihat tanggal lainnya
        </div>

    </div>
</div>

<!-- MODAL POP-UP UNTUK LAMPIRAN -->
<div id="modalIzin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 25px; border-radius: 12px; width: 90%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 18px; color: #202124;">Detail Izin/Sakit</h3>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #5f6368;">&times;</button>
        </div>
        
        <div style="font-size: 14px; color: #3c4043; line-height: 1.6;">
            <p style="margin: 0 0 8px 0;"><strong>Nama:</strong> <span id="modalNama"></span></p>
            <p style="margin: 0 0 8px 0;"><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
            <p style="margin: 0 0 8px 0;"><strong>Jenis:</strong> <span id="modalJenis"></span></p>
            <p style="margin: 0 0 15px 0;"><strong>Alasan:</strong> <span id="modalAlasan"></span></p>
            
            <div id="modalLampiranContainer" style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">
                <strong>Lampiran Bukti:</strong><br>
                <a id="modalLampiranLink" href="#" target="_blank" style="display: inline-block; margin-top: 8px; padding: 8px 15px; background: #e8f0fe; color: #1a73e8; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    <i class="bi bi-paperclip"></i> Lihat Surat/Foto
                </a>
                <span id="modalTidakAdaLampiran" style="display: none; color: #d93025; font-weight: 600;">Tidak ada lampiran</span>
            </div>
        </div>
        
        <div style="margin-top: 25px; text-align: right;">
            <button onclick="closeModal()" style="padding: 8px 20px; background: #f1f3f4; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; color: #3c4043;">Tutup</button>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL DAN PENCARIAN -->
<script>
// Fungsi Pencarian Nama
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.student-row');

    searchInput.addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        
        rows.forEach(row => {
            const name = row.querySelector('.student-name').textContent.toLowerCase();
            if (name.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

// Fungsi Buka Modal
function showDetailIzin(data) {
    document.getElementById('modalNama').innerText = data.nama;
    document.getElementById('modalTanggal').innerText = data.tanggal;
    document.getElementById('modalJenis').innerText = data.jenis;
    document.getElementById('modalAlasan').innerText = data.alasan;

    const btnLampiran = document.getElementById('modalLampiranLink');
    const textNoLampiran = document.getElementById('modalTidakAdaLampiran');

    if (data.lampiran) {
        btnLampiran.href = data.lampiran;
        btnLampiran.style.display = 'inline-block';
        textNoLampiran.style.display = 'none';
    } else {
        btnLampiran.style.display = 'none';
        textNoLampiran.style.display = 'inline-block';
    }

    const modal = document.getElementById('modalIzin');
    modal.style.display = 'flex';
}

// Fungsi Tutup Modal
function closeModal() {
    document.getElementById('modalIzin').style.display = 'none';
}
</script>

@endsection