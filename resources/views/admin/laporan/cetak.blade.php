<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Rekrutmen - Lautan Karir</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 4px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; text-transform: uppercase; font-size: 10px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAUTAN KARIR - LAPORAN REKRUTMEN</h2>
        <p>PT. Lautan Teduh Interniaga</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <div class="info">
        <strong>Filter Laporan:</strong><br>
        <small>
            Lowongan: {{ isset($selectedLowongan) ? $selectedLowongan->posisi->nama_posisi . " (" . $selectedLowongan->dealer->singkatan . ")" : 'Semua Lowongan' }} |
            Status: {{ request('status') ?: 'Semua Status' }} |
            Periode: {{ request('tgl_awal') && request('tgl_akhir') ? request('tgl_awal').' s/d '.request('tgl_akhir') : 'Semua Periode' }}
        </small>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25">No</th>
                <th width="70">Tanggal</th>
                <th>Nama Pelamar</th>
                <th>Posisi</th>
                <th width="50">Dealer</th>
                <th width="90">Skor SAW</th>
                <th width="100">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $lamaran)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                    <td class="fw-bold">{{ $lamaran->pelamar->nama }}</td>
                    <td>{{ $lamaran->lowongan->posisi->nama_posisi }}</td>
                    <td class="text-center">{{ $lamaran->lowongan->dealer->singkatan }}</td>
                    
                    {{-- PERBAIKAN: Menggunakan skor_akhir_saw & Format 4 Desimal --}}
                    <td class="text-center fw-bold">
                        {{ $lamaran->skor_akhir_saw !== null ? number_format($lamaran->skor_akhir_saw, 4) : '-' }}
                    </td>

                    <td class="text-center">{{ $lamaran->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data rekrutmen tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>