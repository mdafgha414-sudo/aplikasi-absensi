@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Atur Siswa ke Sekolah</h3>
            <p class="text-muted mb-0">Pilih siswa yang akan dimasukkan ke <strong>{{ $sekolah->nama_sekolah }}</strong>.</p>
        </div>
        <a href="{{ route('admin.sekolah.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.sekolah.assign.store', $sekolah->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="checkAll()">Pilih Semua</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="uncheckAll()">Batal Pilih</button>
                </div>

                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th width="50">Pilih</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Sekolah Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $s)
                                <tr>
                                    <td>
                                        <input class="form-check-input check-siswa" type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" 
                                            {{ $s->sekolah_id == $sekolah->id ? 'checked' : '' }}>
                                    </td>
                                    <td class="fw-bold">{{ $s->name }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>
                                        @if($s->sekolah_id)
                                            <span class="badge bg-secondary">{{ $s->sekolah->nama_sekolah ?? '-' }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function checkAll() {
        document.querySelectorAll('.check-siswa').forEach(cb => cb.checked = true);
    }
    function uncheckAll() {
        document.querySelectorAll('.check-siswa').forEach(cb => cb.checked = false);
    }
</script>
@endsection