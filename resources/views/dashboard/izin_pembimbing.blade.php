@extends('layouts.app')

@section('content')
<style>
    .inbox-header {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #eef2f9;
    }
    .inbox-title { font-size: 22px; font-weight: 750; color: #1e293b; margin-bottom: 5px; }
    .inbox-subtitle { color: #64748b; font-size: 14px; margin: 0; }
    
    /* Toolbar Pencarian & Filter */
    .inbox-toolbar { display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap; align-items: center; }
    .inbox-search { position: relative; flex: 1; min-width: 200px; }
    .inbox-search i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .inbox-search input { width: 100%; padding: 10px 15px 10px 45px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 14px; background: #f8fafc; transition: 0.2s; }
    .inbox-search input:focus { border-color: #3b82f6; background: white; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .filter-group { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .filter-group select, .filter-group input[type="month"] { padding: 10px 15px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc; font-size: 14px; color: #334155; cursor: pointer; }
    
    /* Tombol Quick Filter */
    .quick-filter { 
        display: inline-flex; padding: 8px 15px; border-radius: 8px; border: 1px solid #e2e8f0; 
        background: white; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; 
        text-decoration: none; transition: 0.2s;
    }
    .quick-filter:hover { background: #f1f5f9; }
    .quick-filter.active { background: #eff6ff; border-color: #3b82f6; color: #2563eb; }

    /* Kartu Pengajuan */
    .approval-card {
        background: white; border: 1px solid #eef2f9; border-radius: 15px; padding: 18px 20px;
        margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: 0.2s;
        display: flex; justify-content: space-between; align-items: center; gap: 15px;
    }
    .approval-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-color: #dbeafe; }
    
    .student-info { display: flex; align-items: center; gap: 15px; flex: 1; }
    .student-avatar { width: 45px; height: 45px; border-radius: 10px; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0; }
    .student-details h5 { margin: 0 0 3px; font-weight: 700; color: #1e293b; font-size: 15px; }
    .student-details .meta { font-size: 12px; color: #64748b; margin-bottom: 3px; }
    .student-details .reason { font-size: 13px; color: #475569; font-style: italic; margin: 0; }
    
    .badge-jenis { display: inline-block; padding: 2px 6px; border-radius: 5px; font-size: 10px; font-weight: 700; margin-left: 5px; }
    .badge-sakit { background: #fef9c3; color: #854d0e; }
    .badge-izin { background: #dbeafe; color: #1e40af; }

    .action-buttons { display: flex; gap: 8px; flex-shrink: 0; }
    .btn-approve { background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.2s; }
    .btn-approve:hover { background: #059669; }
    .btn-reject { background: #f43f5e; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.2s; }
    .btn-reject:hover { background: #e11d48; }
    
    .status-badge { padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
    .status-disetujui { background: #dcfce7; color: #166534; }
    .status-ditolak { background: #fee2e2; color: #991b1b; }
</style>

<div class="container-fluid py-3">
    
    <!-- Header & Toolbar -->
    <div class="inbox-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4 class="inbox-title"><i class="bi bi-inbox-fill text-primary me-2"></i> Persetujuan Izin Siswa</h4>
                <p class="inbox-subtitle">Kelola pengajuan izin, lihat alasan, dan berikan keputusan.</p>
            </div>
            <span class="badge bg-warning text-dark fs-6 rounded-pill px-3 py-2">
                {{ $jumlahMenunggu }} Menunggu
            </span>
        </div>

        <!-- Form Filter -->
        <form action="/pembimbing/izin" method="GET" class="inbox-toolbar">
            <div class="inbox-search">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa...">
            </div>
            
            <div class="filter-group">
                <select name="status" onchange="this.form.submit()">
                    <option value="Semua" {{ request('status') == 'Semua' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">Cari</button>
            <a href="/pembimbing/izin" class="btn btn-light border px-3" style="border-radius: 10px;">Reset</a>
        </form>

        <!-- Quick Filter Tanggal -->
        <div class="mt-3 d-flex gap-2 flex-wrap align-items-center">
            <a href="/pembimbing/izin?waktu=semua" class="quick-filter {{ request('waktu') == 'semua' || !request('waktu') ? 'active' : '' }}">Semua Waktu</a>
            <a href="/pembimbing/izin?waktu=hari_ini" class="quick-filter {{ request('waktu') == 'hari_ini' ? 'active' : '' }}">Hari Ini</a>
            <a href="/pembimbing/izin?waktu=7_hari" class="quick-filter {{ request('waktu') == '7_hari' ? 'active' : '' }}">7 Hari Terakhir</a>
            <a href="/pembimbing/izin?waktu=bulan_ini" class="quick-filter {{ request('waktu') == 'bulan_ini' ? 'active' : '' }}">Bulan Ini</a>
            
            <!-- TAMBAHAN: Bulan Lalu & Pilih Bulan -->
            <a href="/pembimbing/izin?waktu=bulan_lalu" class="quick-filter {{ request('waktu') == 'bulan_lalu' ? 'active' : '' }}">Bulan Lalu</a>
            
            <form action="/pembimbing/izin" method="GET" class="d-flex gap-2 ms-2">
                <input type="hidden" name="waktu" value="pilih_bulan">
                <input type="month" name="bulan_filter" value="{{ request('bulan_filter') }}" class="form-control form-control-sm" style="border-radius: 8px; padding: 8px 10px;">
                <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">Lihat</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <!-- Daftar Pengajuan -->
    @forelse($semuaIzin as $izin)
        <div class="approval-card">
            <div class="student-info">
                <div class="student-avatar">
                    {{ strtoupper(substr($izin->user->name ?? '?', 0, 1)) }}
                </div>
                <div class="student-details">
                    <h5>
                        {{ $izin->user->name ?? 'Siswa' }}
                        <span class="badge-jenis {{ strtolower($izin->jenis_izin) == 'sakit' ? 'badge-sakit' : 'badge-izin' }}">
                            {{ $izin->jenis_izin }}
                        </span>
                    </h5>
                    <div class="meta">
                        <i class="bi bi-calendar3 me-1"></i> Izin: {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}
                        <span class="mx-2">•</span>
                        Diajukan: {{ $izin->created_at->format('d M Y H:i') }}
                    </div>
                    <p class="reason">"{{ $izin->alasan }}"</p>
                    @if($izin->lampiran)
                        <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank" class="small text-decoration-none fw-bold text-primary mt-1 d-inline-block">
                            <i class="bi bi-paperclip"></i> Lampiran
                        </a>
                    @endif
                </div>
            </div>

            <div class="action-buttons">
                @if($izin->status == 'Menunggu')
                    <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Disetujui">
                        <button type="submit" class="btn-approve"><i class="bi bi-check-lg"></i> Setujui</button>
                    </form>
                    <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="btn-reject"><i class="bi bi-x-lg"></i> Tolak</button>
                    </form>
                @else
                    <span class="status-badge {{ $izin->status == 'Disetujui' ? 'status-disetujui' : 'status-ditolak' }}">
                        {{ $izin->status }}
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted bg-white rounded-4 border" style="border-color: #eef2f9 !important;">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
            <h5 class="fw-bold text-dark">Tidak Ada Data</h5>
            <p class="mb-0">Tidak ada pengajuan izin yang sesuai dengan filter Anda.</p>
        </div>
    @endforelse

    <!-- Tombol Pagination -->
    @if($semuaIzin->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $semuaIzin->links() }}
        </div>
    @endif

</div>
@endsection