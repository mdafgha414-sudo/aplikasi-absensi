@extends('layouts.app')

@section('content')
<div style="padding: 30px; max-width: 800px; margin: auto;">
    <h2 style="font-weight: 800; margin-bottom: 20px;">Edit Perusahaan Saya</h2>

    @if(session('success'))
        <div style="background: #e2f8ec; color: #168553; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fff0f0; color: #c73939; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembimbing.perusahaan.update') }}" method="POST" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2ebf8;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" value="{{ $perusahaan->nama_perusahaan }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Latitude (Garis Lintang)</label>
            <input type="text" name="latitude" value="{{ $perusahaan->latitude }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <small style="color: #666;">Contoh: -6.200000</small>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Longitude (Garis Bujur)</label>
            <input type="text" name="longitude" value="{{ $perusahaan->longitude }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <small style="color: #666;">Contoh: 106.816666</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Radius (Meter)</label>
            <input type="number" name="radius" value="{{ $perusahaan->radius }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <small style="color: #666;">Jarak maksimal siswa bisa absen dari titik pusat (contoh: 300)</small>
        </div>

        <button type="submit" style="background: #2878f0; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection