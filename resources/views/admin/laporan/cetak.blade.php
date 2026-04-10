<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Rekrutmen - Lautan Karir</title>
    <style>
        /* Pengaturan Kertas dan Font */
        body { font-family: sans-serif; font-size: 10px; color: #000; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 14px; }
        .header p { margin: 3px 0; font-size: 10px; }
        
        .info { margin-bottom: 15px; font-size: 9px; }
        
        /* Tabel Cetak */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 5px 4px; word-wrap: break-word; vertical-align: top; }
        
        /* Header Tabel (Mirip gaya Dealer tapi versi Cetak) */
        th { 
            background-color: #f2f2f2; 
            text-align: center; 
            text-transform: uppercase; 
            font-size: 8px; 
            font-weight: bold;
        }
        
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }
        .italic-muted { font-style: italic; color: #555; font-size: 8px; }
        
        /* Orientasi Landscape otomatis saat cetak */
        @media print { 
            @page { size: landscape; margin: 1cm; }
            .no-print { display: none; } 
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAUTAN KARIR - LAPORAN REKRUTMEN</h2>
        <p>PT. Lautan Teduh Interniaga</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <div class="info">
        <strong>FILTER LAPORAN:</strong><br>
        Lowongan: {{ isset($selectedLowongan) ? $selectedLowongan->posisi->nama_posisi . " (" . $selectedLowongan->dealer->singkatan . ")" : 'Semua Lowongan' }} |
        Status: {{ request('status') ?: 'Semua Status' }} |
        Periode: {{ request('tgl_awal') && request('tgl_akhir') ? request('tgl_awal').' s/d '.request('tgl_akhir') : 'Semua Periode' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="25">No</th>
                <th width="60">Tanggal</th>
                <th width="110">Nama & Posisi</th>
                <th width="40">Dealer</th>
                <th width="50">Skor</th>
                {{-- KOLOM DIPISAH: DISC & PAPI --}}
                <th>Kesimpulan DISC</th>
                <th>Kesimpulan PAPI-KOSTICK</th>
                <th width="70">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $lamaran)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                    <td>
                        <div class="fw-bold">{{ $lamaran->pelamar->nama }}</div>
                        <div style="font-size: 8px; text-transform: uppercase;">{{ $lamaran->lowongan->posisi->nama_posisi }}</div>
                    </td>
                    <td class="text-center">{{ $lamaran->lowongan->dealer->singkatan }}</td>
                    
                    <td class="text-center fw-bold">
                        {{ $lamaran->skor_akhir_saw !== null ? number_format($lamaran->skor_akhir_saw, 4) : '0.0000' }}
                    </td>

                    <td class="">
                        {{ $lamaran->kesimpulan_disc ?? 'Belum ada kesimpulan' }}
                    </td>
                    <td class="">
                        {{ $lamaran->kesimpulan_papi ?? 'Belum ada kesimpulan' }}
                    </td>

                    <td class="text-center text-uppercase fw-bold" style="font-size: 8px;">
                        {{ str_replace(' Seleksi', '', $lamaran->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data rekrutmen tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>