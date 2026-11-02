<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu PKL - {{ $siswa->name }}</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            background-color: #f1f5f9; 
        }
        .card-id { 
            width: 320px; 
            background: white; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            overflow: hidden; 
            text-align: center; 
            border: 2px solid #0284c7; 
            position: relative; 
        }
        .card-header { 
            background-color: #0284c7; 
            color: white; 
            padding: 20px 15px; 
            font-size: 18px; 
            font-weight: bold; 
            letter-spacing: 1px; 
        }
        .card-body { 
            padding: 25px 20px; 
        }
        .qr-box { 
            background: #fff; 
            padding: 10px; 
            border: 2px dashed #cbd5e1; 
            display: inline-block; 
            border-radius: 10px; 
            margin-bottom: 15px; 
        }
        .nama-siswa { 
            font-size: 22px; 
            font-weight: 800; 
            color: #0f172a; 
            margin: 0 0 5px 0; 
            text-transform: uppercase; 
        }
        .kode-kartu { 
            font-size: 14px; 
            color: #0284c7; 
            background: #e0f2fe; 
            display: inline-block; 
            padding: 5px 15px; 
            border-radius: 20px; 
            font-weight: bold; 
            letter-spacing: 2px; 
        }
        .card-footer { 
            background: #f8fafc; 
            padding: 12px; 
            font-size: 12px; 
            color: #94a3b8; 
            border-top: 1px solid #e2e8f0; 
            font-weight: 600; 
        }
        
        /* Pengaturan saat di-print */
        @media print {
            body { background: white; }
            .card-id { box-shadow: none; border: 1px solid #ccc; }
            .no-print { display: none !important; }
        }
        
        .floating-actions { 
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            display: flex; 
            gap: 10px; 
        }
        .btn-action { 
            padding: 12px 24px; 
            border-radius: 8px; 
            font-weight: bold; 
            text-decoration: none; 
            border: none; 
            cursor: pointer; 
            font-size: 16px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        .btn-print { background: #0284c7; color: white; }
        .btn-print:hover { background: #0369a1; }
        .btn-back { background: #64748b; color: white; }
        .btn-back:hover { background: #475569; }
    </style>
</head>
<body>

    <div class="card-id">
        <div class="card-header">
            KARTU SISWA PKL
        </div>
        <div class="card-body">
            <div class="qr-box">
                {{-- Menampilkan QR Code yang di-generate dari Controller --}}
                {!! $qrCode !!}
            </div>
            <h3 class="nama-siswa">{{ $siswa->name }}</h3>
            <div class="kode-kartu">{{ $siswa->kode_kartu }}</div>
        </div>
        <div class="card-footer">
            TIMETRIX ATTENDANCE SYSTEM
        </div>
    </div>

    {{-- Tombol Aksi (Hanya muncul di layar, hilang saat di-print) --}}
    <div class="floating-actions no-print">
        <a href="{{ route('qr.index') }}" class="btn-action btn-back">Kembali</a>
        <button onclick="window.print()" class="btn-action btn-print">🖨️ Cetak Sekarang</button>
    </div>

</body>
</html>