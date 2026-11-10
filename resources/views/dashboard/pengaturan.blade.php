@extends('layouts.app')

@section('content')
<div style="padding: 30px; max-width: 1000px; margin: auto;">
    <h2 style="font-weight: 800; margin-bottom: 20px;">Pengaturan Jadwal Absensi</h2>

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

    <form action="{{ url('/admin/setting') }}" method="POST" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2ebf8;">
        @csrf
        
        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari)
            <div style="display: flex; gap: 20px; margin-bottom: 15px; align-items: center; border-bottom: 1px solid #f0f4f9; padding-bottom: 15px;">
                <div style="width: 100px; font-weight: bold; text-transform: capitalize;">{{ $hari }}</div>
                
                <div>
                    <label style="font-size: 12px; color: #666;">Masuk</label><br>
                    <input type="time" name="jam_masuk_{{ $hari }}" value="{{ $jadwal[$hari]['masuk'] }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; color: #666;">Telat</label><br>
                    <input type="time" name="jam_telat_{{ $hari }}" value="{{ $jadwal[$hari]['telat'] }}" required>
                </div>
                <div>
                    <label style="font-size: 12px; color: #666;">Pulang</label><br>
                    <input type="time" name="jam_pulang_{{ $hari }}" value="{{ $jadwal[$hari]['pulang'] }}" required>
                </div>
            </div>
        @endforeach

        <div style="margin-top: 20px;">
            <button type="submit" style="background: #2878f0; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection