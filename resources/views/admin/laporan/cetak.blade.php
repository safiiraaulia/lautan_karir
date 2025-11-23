<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Rekrutmen</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 2px 5px; border-radius: 3px; border: 1px solid #ccc; font-size: 10px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAUTAN KARIR - LAPORAN REKRUTMEN</h2>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <div class="info">
        <p><strong>Filter Laporan:</strong></p>
        <ul style="list-style-type: none; padding: 0;">
            <li style="margin-bottom: 5px;">
                <strong>Lowongan:</strong> 
                @if(isset($selectedLowongan) && $selectedLowongan)
                    {{ $selectedLowongan->posisi->nama_posisi }} - {{ $selectedLowongan->dealer->nama_dealer }} ({{ $selectedLowongan->dealer->kota }})
                @else
                    Semua Lowongan
                @endif
            </li>
            <li style="margin-bottom: 5px;">
                <strong>Status:</strong> {{ request('status') ? request('status') : 'Semua Status' }}
            </li>
            <li>
                <strong>Periode:</strong> 
                @if(request('tgl_awal') && request('tgl_akhir'))
                    {{ \Carbon\Carbon::parse(request('tgl_awal'))->format('d M Y') }} s/d {{ \Carbon\Carbon::parse(request('tgl_akhir'))->format('d M Y') }}
                @else
                    Semua Periode
                @endif
            </li>
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Tanggal</th>
                <th>Nama Pelamar</th>
                <th>Posisi</th>
                <th>Dealer</th>
                {{-- [BARU] HEADER KOLOM NILAI --}}
                <th style="text-align: center;">Nilai Seleksi (SAW)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $lamaran)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                    <td>{{ $lamaran->pelamar->nama }}</td>
                    <td>{{ $lamaran->lowongan->posisi->nama_posisi }}</td>
                    <td>{{ $lamaran->lowongan->dealer->singkatan }}</td>
                    
                    {{-- [BARU] ISI KOLOM NILAI --}}
                    <td style="text-align: center;">
                        {{-- Menampilkan nilai jika ada, jika kosong strip --}}
                        {{ $lamaran->nilai_saw ?? '-' }}
                    </td>

                    <td>{{ $lamaran->status }}</td>
                </tr>
            @empty
                <tr>
                    {{-- [UPDATE] Colspan jadi 7 karena tambah 1 kolom --}}
                    <td colspan="7" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>