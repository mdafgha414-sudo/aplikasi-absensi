
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Alasan Keterlambatan</h3>
            <p class="text-muted mb-0">
                Periksa dan berikan keputusan atas alasan keterlambatan siswa.
            </p>
        </div>

        <a href="{{ url('/pembimbing/dashboard') }}"
           class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Catatan Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($daftarAlasan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $item->user->name ?? 'Pengguna tidak ditemukan' }}
                                </td>

                                <td>
                                    {{ $item->tanggal->format('d-m-Y') }}
                                </td>

                                <td style="min-width: 200px;">
                                    {{ $item->alasan }}
                                </td>

                                <td>
                                    @if($item->status === 'Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($item->status === 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $item->catatan_pembimbing ?? '-' }}
                                </td>

                                <td style="min-width: 220px;">
                                    @if($item->status === 'Menunggu')
                                        <form action="{{ route('pembimbing.alasan.terima', $item->id) }}"
                                              method="POST"
                                              class="mb-2">
                                            @csrf
                                            @method('PUT')

                                            <input type="text"
                                                   name="catatan_pembimbing"
                                                   class="form-control form-control-sm mb-2"
                                                   placeholder="Catatan (opsional)">

                                            <button type="submit"
                                                    class="btn btn-success btn-sm w-100"
                                                    onclick="return confirm('Terima alasan keterlambatan ini?')">
                                                Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('pembimbing.alasan.tolak', $item->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="text"
                                                   name="catatan_pembimbing"
                                                   class="form-control form-control-sm mb-2"
                                                   placeholder="Alasan penolakan (opsional)">

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm w-100"
                                                    onclick="return confirm('Tolak alasan keterlambatan ini?')">
                                                Tolak
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">
                                            Sudah diperiksa
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada alasan keterlambatan dari siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
