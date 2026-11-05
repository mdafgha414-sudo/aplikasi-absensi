@extends('layouts.app')

@section('content')
<style>
    /* --- CUSTOM CSS: MODERN SOFT UI --- */
    body { 
        background-color: #f8fafc; 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    
    .inbox-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Area */
    .inbox-header {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
    }
    .inbox-title { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .inbox-subtitle { color: #64748b; font-size: 13px; margin: 0; }
    
    /* Toolbar Pencarian & Filter */
    .inbox-toolbar { display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap; align-items: center; }
    .inbox-search { position: relative; flex: 1; min-width: 200px; }
    .inbox-search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; }
    .inbox-search input { 
        width: 100%; padding: 10px 16px 10px 42px; border-radius: 10px; border: 1px solid #e2e8f0; 
        outline: none; font-size: 13px; background: #f8fafc; transition: all 0.2s; 
    }
    .inbox-search input:focus { border-color: #3b82f6; background: white; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .filter-group select { 
        padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; 
        outline: none; background: #f8fafc; font-size: 13px; color: #475569; cursor: pointer; 
        font-weight: 500; transition: all 0.2s;
    }
    .filter-group select:focus { border-color: #3b82f6; background: white; }
    
    /* Tombol Action Toolbar */
    .btn-toolbar-primary {
        background: #0f172a; color: white; border-radius: 10px; font-weight: 600; font-size: 13px;
        padding: 10px 20px; border: none; transition: 0.2s;
    }
    .btn-toolbar-primary:hover { background: #334155; color: white; }
    .btn-toolbar-secondary {
        background: white; border: 1px solid #e2e8f0; color: #475569; border-radius: 10px; font-weight: 600; font-size: 13px;
        padding: 10px 16px; transition: 0.2s;
    }
    .btn-toolbar-secondary:hover { background: #f1f5f9; color: #1e293b; }

    /* Quick Filter (Kapsul Tanggal) */
    .quick-filter { 
        display: inline-flex; padding: 6px 14px; border-radius: 50px; border: 1px solid transparent; 
        background: transparent; color: #64748b; font-size: 12px; font-weight: 600; cursor: pointer; 
        text-decoration: none; transition: all 0.2s; align-items: center;
    }
    .quick-filter:hover { background: #f1f5f9; color: #1e293b; }
    .quick-filter.active { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }

    /* Input Month */
    .input-month-custom {
        padding: 6px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 12px; color: #475569; outline: none;
    }

    /* --- KARTU PENGAJUAN --- */
    .approval-card {
        background: white; 
        border: 1px solid #f1f5f9; 
        border-radius: 16px; 
        padding: 20px 24px;
        margin-bottom: 12px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        transition: all 0.2s ease;
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 20px;
        position: relative;
        overflow: hidden;
    }
    .approval-card:hover { 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        border-color: #e2e8f0; 
        transform: translateY(-2px); 
    }

    /* Garis Aksen Kiri (Berdasarkan Status) */
    .approval-card::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 5px;
    }
    .approval-card.card-menunggu::before { background: #f59e0b; }
    .approval-card.card-disetujui::before { background: #10b981; }
    .approval-card.card-ditolak::before { background: #ef4444; }
    
    .student-info { display: flex; align-items: center; gap: 16px; flex: 1; }
    
    /* Avatar Inisial */
    .student-avatar { 
        width: 48px; height: 48px; border-radius: 12px; background: #f8fafc; color: #475569; 
        display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }
    
    /* Detail Teks */
    .student-details h5 { margin: 0 0 4px; font-weight: 700; color: #1e293b; font-size: 15px; display: flex; align-items: center; gap: 8px; }
    .student-details .meta { font-size: 12px; color: #64748b; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
    .student-details .reason { font-size: 13px; color: #475569; margin: 0; background: #f8fafc; padding: 8px 12px; border-radius: 8px; border-left: 3px solid #cbd5e1; }
    
    /* Badge Jenis Izin */
    .badge-jenis { display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-sakit { background: #fef9c3; color: #854d0e; }
    .badge-izin { background: #dbeafe; color: #1e40af; }

    /* Tombol Aksi */
    .action-buttons { display: flex; gap: 10px; flex-shrink: 0; }
    
    .btn-approve { 
        background: white; color: #059669; border: 1px solid #a7f3d0; padding: 8px 18px; border-radius: 10px; 
        font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.2s; 
        display: flex; align-items: center; gap: 6px;
    }
    .btn-approve:hover { background: #ecfdf5; border-color: #10b981; }
    
    .btn-reject { 
        background: white; color: #e11d48; border: 1px solid #fecdd3; padding: 8px 18px; border-radius: 10px; 
        font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.2s; 
        display: flex; align-items: center; gap: 6px;
    }
    .btn-reject:hover { background: #fff1f2; border-color: #f43f5e; }
    
    /* Badge Status Akhir */
    .status-badge { padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 6px; }
    .status-disetujui { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-ditolak { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
</style>

<div class="container-fluid py-4 px-lg-5">
    <div class="inbox-container">
        
        <!-- Header & Toolbar -->
        <div class="inbox-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h4 class="inbox-title">
                        Persetujuan Izin Siswa
                    </h4>
                    <p class="inbox-subtitle">Kelola pengajuan izin, lihat alasan, dan berikan keputusan.</p>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-2" style="font-size: 12px; font-weight: 700;">
                    <i class="bi bi-clock-history me-1"></i> {{ $jumlahMenunggu }} Menunggu
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
                
                <button type="submit" class="btn-toolbar-primary">Cari</button>
                <a href="/pembimbing/izin" class="btn-toolbar-secondary">Reset</a>
            </form>

            <!-- Quick Filter Tanggal -->
            <div class="mt-3 pt-3 border-top border-light d-flex gap-2 flex-wrap align-items-center">
                <a href="/pembimbing/izin?waktu=semua" class="quick-filter {{ request('waktu') == 'semua' || !request('waktu') ? 'active' : '' }}">Semua Waktu</a>
                <a href="/pembimbing/izin?waktu=hari_ini" class="quick-filter {{ request('waktu') == 'hari_ini' ? 'active' : '' }}">Hari Ini</a>
                <a href="/pembimbing/izin?waktu=7_hari" class="quick-filter {{ request('waktu') == '7_hari' ? 'active' : '' }}">7 Hari Terakhir</a>
                <a href="/pembimbing/izin?waktu=bulan_ini" class="quick-filter {{ request('waktu') == 'bulan_ini' ? 'active' : '' }}">Bulan Ini</a>
                <a href="/pembimbing/izin?waktu=bulan_lalu" class="quick-filter {{ request('waktu') == 'bulan_lalu' ? 'active' : '' }}">Bulan Lalu</a>
                
                <form action="/pembimbing/izin" method="GET" class="d-flex gap-2 ms-auto mt-2 mt-sm-0 align-items-center">
                    <input type="hidden" name="waktu" value="pilih_bulan">
                    <input type="month" name="bulan_filter" value="{{ request('bulan_filter') }}" class="input-month-custom">
                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 12px; font-weight: 600;">Lihat</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center gap-2" style="font-size: 13px;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Pengajuan -->
        @forelse($semuaIzin as $izin)
            <!-- Tambahan class dinamis untuk warna garis kiri -->
            @php
                $cardClass = '';
                if($izin->status == 'Menunggu') $cardClass = 'card-menunggu';
                elseif($izin->status == 'Disetujui') $cardClass = 'card-disetujui';
                elseif($izin->status == 'Ditolak') $cardClass = 'card-ditolak';
            @endphp
            
            <div class="approval-card {{ $cardClass }}">
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
                            <span><i class="bi bi-calendar3 me-1"></i> Izin: {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</span>
                            <span class="text-muted">•</span>
                            <span><i class="bi bi-clock me-1"></i> Diajukan: {{ $izin->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <p class="reason">"{{ $izin->alasan }}"</p>
                        @if($izin->lampiran)
                            <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank" class="small text-decoration-none fw-bold text-primary mt-2 d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                            </a>
                        @endif
                    </div>
                </div>

                <div class="action-buttons">
                    @if($izin->status == 'Menunggu')
                        <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Disetujui">
                            <button type="submit" class="btn-approve"><i class="bi bi-check2"></i> Setujui</button>
                        </form>
                        <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Ditolak">
                            <button type="submit" class="btn-reject"><i class="bi bi-x"></i> Tolak</button>
                        </form>
                    @else
                        <span class="status-badge {{ $izin->status == 'Disetujui' ? 'status-disetujui' : 'status-ditolak' }}">
                            <i class="bi {{ $izin->status == 'Disetujui' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i> {{ $izin->status }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted bg-white rounded-4 border" style="border-color: #f1f5f9 !important; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-inbox fs-2 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark" style="font-size: 15px;">Tidak Ada Data</h5>
                <p class="mb-0" style="font-size: 13px;">Tidak ada pengajuan izin yang sesuai dengan filter Anda.</p>
            </div>
        @endforelse

        <!-- Tombol Pagination -->
        @if($semuaIzin->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $semuaIzin->links() }}
            </div>
        @endif

    </div>
</div>
@endsection