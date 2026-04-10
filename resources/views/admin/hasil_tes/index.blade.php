@extends('layouts.admin')

@section('content')
<style>
    .table-container { position: relative; height: 75vh; overflow: auto; border: 1px solid #000; background: #fff; }
    .custom-table { border-collapse: separate; border-spacing: 0; width: auto; min-width: 100%; font-size: 10px; border-left: 1px solid #000; border-top: 1px solid #000; }
    
    .custom-table thead th { position: sticky; top: 0; z-index: 10; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center; height: 35px; white-space: nowrap; }
    .sticky-left { position: sticky; left: 0; background-color: #fff !important; z-index: 20; border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important; white-space: nowrap; padding: 5px 10px; }
    .sticky-top-left { position: sticky; top: 0; left: 0; z-index: 30 !important; background-color: #f8f9fa !important; border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important; }

    .header-soal-blue { background-color: #d1ecf1 !important; color: #000; font-weight: bold; } 
    .header-ml-yellow { background-color: #fff3cd !important; color: #000; font-weight: bold; } 
    .bg-yellow-fixed { background-color: #ffff00 !important; font-weight: bold; }
    .bg-green-fixed { background-color: #00ff00 !important; font-weight: bold; }
    .cell-n-red { background-color: #ff0000 !important; color: white !important; font-weight: bold; }

    .border-inner-dashed { border-right: 1px dashed #666 !important; border-bottom: 1px solid #000 !important; }
    .border-group-solid { border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important; }

    .custom-table td { padding: 4px; white-space: nowrap; 
    }
</style>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-navy">Rekapitulasi Jawaban Psikotes Pelamar</h4>
        <div>
            {{-- Spasi Tombol (Margin Right) --}}
            <button class="btn btn-success btn-sm" style="margin-right: 15px;" onclick="exportToExcel('table-disc', 'Rekap_DISC_LautanKarir')">
                <i class="fas fa-file-excel me-1"></i> Export DISC
            </button>
            <button class="btn btn-success btn-sm" onclick="exportToExcel('table-papi', 'Rekap_PAPI_LautanKarir')">
                <i class="fas fa-file-excel me-1"></i> Export PAPI
            </button>
        </div>
    </div>

    <ul class="nav nav-tabs border-0" id="rekapTab">
        <li class="nav-item"><a class="nav-link active fw-bold" data-toggle="tab" href="#disc">TABEL DATA DISC</a></li>
        <li class="nav-item"><a class="nav-link fw-bold" data-toggle="tab" href="#papi">TABEL DATA PAPI</a></li>
    </ul>

    <div class="tab-content border p-2 bg-white shadow-sm rounded-bottom">
        {{-- PANEL DISC --}}
        <div class="tab-pane fade show active" id="disc">
            <div class="table-container">
                <table class="custom-table text-center" id="table-disc">
                    <thead>
                        <tr>
                            <th class="sticky-top-left">No. Soal</th>
                            @for ($i = 1; $i <= 24; $i++)
                                <th colspan="2" class="header-soal-blue" bgcolor="#d1ecf1">{{ $i }}</th>
                            @endfor
                            <th style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f8f9fa !important;">ASPEK</th>
                        </tr>
                        <tr>
                            <th class="sticky-top-left" style="top: 35px;">No. Peserta</th>
                            @for ($i = 1; $i <= 24; $i++)
                                <th class="header-ml-yellow border-inner-dashed" bgcolor="#fff3cd">M</th>
                                <th class="header-ml-yellow border-group-solid" bgcolor="#fff3cd">L</th>
                            @endfor
                            <th style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f8f9fa !important; top: 35px;">HASIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peserta as $p)
                            @foreach($labels as $idx => $lbl)
                            <tr>
                                @if($idx == 0)
                                    <td rowspan="5" class="sticky-left fw-bold">
                                        {{ $loop->parent->iteration }}. {{ Str::limit($p->nama, 10) }}
                                    </td>
                                @endif
                                @for ($i = 1; $i <= 24; $i++)
                                    @php $j = $p->jawabanTes->where('soal_id', $i)->whereNotNull('most')->first(); @endphp
                                    <td class="border-inner-dashed @if($lbl == 'N') cell-n-red @endif" @if($lbl == 'N') bgcolor="#ff0000" @endif>{{ ($j && $j->most == $lbl) ? '1' : '' }}</td>
                                    <td class="border-group-solid @if($lbl == 'N') cell-n-red @endif" @if($lbl == 'N') bgcolor="#ff0000" @endif>{{ ($j && $j->least == $lbl) ? '1' : '' }}</td>
                                @endfor
                                <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight: bold;" class="@if($lbl == 'N') cell-n-red @endif" @if($lbl == 'N') bgcolor="#ff0000" @endif>{{ $lbl }}</td>
                            </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="51" class="py-5">Data kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PANEL PAPI --}}
        <div class="tab-pane fade" id="papi">
            <div class="table-container">
                <table class="custom-table text-center" id="table-papi">
                    <thead>
                        <tr>
                            <th class="sticky-top-left bg-yellow-fixed" bgcolor="#ffff00" style="width: 180px;">No. Test / No. Soal</th>
                            @foreach($peserta as $p)
                                <th class="bg-green-fixed" bgcolor="#00ff00" style="min-width: 80px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{ $loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @for ($s = 1; $s <= 90; $s++)
                        <tr>
                            <td class="sticky-left bg-yellow-fixed" bgcolor="#ffff00">{{ $s }}</td>
                            @foreach($peserta as $p)
                                @php 
                                    $real_id = $s + 24;
                                    $jwb = $p->jawabanTes->where('soal_id', $real_id)->whereNotNull('jawaban_papikostik')->first(); 
                                @endphp
                                <td style="border-right: 1px solid #000; border-bottom: 1px solid #000;">{{ $jwb ? $jwb->jawaban_papikostik : '' }}</td>
                            @endforeach
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Fungsi Ekspor
     */
    function exportToExcel(tableID, filename = '') {
        var table = document.getElementById(tableID).cloneNode(true);
        
        var cells = table.querySelectorAll('th, td');
        cells.forEach(function(cell) {
            cell.style.border = '1px solid #000000';
            cell.style.fontFamily = 'Arial, sans-serif';
            cell.style.fontSize = '10pt';
            cell.style.textAlign = 'center';
            cell.style.verticalAlign = 'middle';
            
            if(cell.className.includes('border-inner-dashed')) {
                cell.style.borderRight = '1px dashed #666666';
            }
        });

        var html = table.outerHTML;

        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">' +
            '<head>' +
            '<style>table { border-collapse: collapse; } </style></head>' +
            '<body>' + html + '</body></html>';
        
        var blob = new Blob([template], { type: "application/vnd.ms-excel" });
        var url = URL.createObjectURL(blob);
        var link = document.createElement("a");
        link.href = url;
        link.download = filename + ".xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection