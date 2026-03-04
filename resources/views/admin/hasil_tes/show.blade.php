@extends('layouts.admin')

@section('content')
<style>
    /* Kontainer Utama */
    .table-container {
        position: relative;
        height: 72vh;
        overflow: auto;
        border: 2px solid #dee2e6;
        background: #fff;
        user-select: none; 
    }

    .custom-table {
        border-collapse: separate;
        border-spacing: 0;
        table-layout: fixed;
        width: 100%;
        font-size: 11px;
    }

    /* HEADER STICKY */
    .custom-table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 100;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        text-align: center;
        height: 25px; 
    }

    /* Koordinasi Top */
    .custom-table thead tr:nth-child(2) th { top: 25px; }
    .custom-table thead tr:nth-child(3) th { top: 50px; }

    /* KOLOM STICKY KIRI (Identitas) */
    .sticky-left {
        position: sticky;
        background-color: #fff !important;
        z-index: 90;
        border-right: 1px solid #dee2e6 !important;
    }
    .col-no { left: 0; width: 50px; }
    .col-nama { left: 50px; width: 180px; }

    /* KOLOM STICKY KANAN (Label DICSN) */
    .sticky-right {
        position: sticky;
        right: 0;
        background-color: #fff !important;
        z-index: 90;
        border-left: 3px solid #007bff !important;
        width: 45px;
        font-weight: bold;
    }

    /* Area Pojok */
    .z-corner { z-index: 110 !important; }

    /* Baris 'N' */
    .row-n td { 
        background-color: #ff0000 !important; 
        color: white !important; 
        height: 12px; 
        padding: 0 !important;
        border: none !important;
    }

    /* PAPI KOSTICK STYLE */
    .bg-papi-yellow { background-color: #ffff00 !important; font-weight: bold; color: #000; }
    .bg-papi-green { background-color: #00ff00 !important; font-weight: bold; color: #000; }

    /* MENGHILANGKAN EFEK HOVER */
    .custom-table tbody tr:hover td {
        background-color: transparent; 
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Rekapitulasi Hasil Psikotes</h2>
        <div class="dropdown">
            <button class="btn btn-success shadow-sm dropdown-toggle" type="button" data-toggle="dropdown">
                <i class="fas fa-file-excel me-2"></i> Export ke Excel
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="exportTableToExcel('table-disc', 'Rekap_DISC_Lautan_Karir')">Export Data DISC</a>
                <a class="dropdown-item" href="#" onclick="exportTableToExcel('table-papi', 'Rekap_PAPI_Lautan_Karir')">Export Data PAPIKOSTIK</a>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active fw-bold" data-toggle="tab" href="#disc">DATA DISC</a></li>
        <li class="nav-item"><a class="nav-link fw-bold" data-toggle="tab" href="#papi">DATA PAPIKOSTIK</a></li>
    </ul>

    <div class="tab-content border bg-white p-3 shadow-sm rounded-bottom">
        
        <div class="tab-pane fade show active" id="disc">
            <div class="table-container shadow-sm">
                <table class="custom-table text-center" id="table-disc">
                    <thead>
                        <tr>
                            <th class="sticky-left col-no z-corner" rowspan="3">No</th>
                            <th colspan="48" class="bg-primary text-white">Nomor Soal DISC (M-L)</th>
                            <th class="sticky-right z-corner" rowspan="3">HASIL</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 24; $i++)
                                <th colspan="2" style="background: #eef2f7;">{{ $i }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 24; $i++)
                                <th style="background: #fff3cd; width: 30px;">M</th>
                                <th style="background: #d1ecf1; width: 30px;">L</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $peserta = [['no' => 1], ['no' => 2]];
                            $labels = ['D', 'I', 'S', 'C', 'N'];
                        @endphp

                        @foreach($peserta as $p)
                            @php
                                $map = [];
                                for($i=1; $i<=24; $i++){
                                    $m = rand(0,3); $l = rand(0,3);
                                    while($l == $m) { $l = rand(0,3); }
                                    $map[$i] = ['m' => $m, 'l' => $l];
                                }
                            @endphp

                            @foreach($labels as $idx => $lbl)
                            <tr class="{{ $lbl == 'N' ? 'row-n' : '' }}">
                                @if($idx == 0)
                                    <td rowspan="5" class="sticky-left col-no bg-white fw-bold">{{ $p['no'] }}</td>
                                @endif

                                @for ($i = 1; $i <= 24; $i++)
                                    <td>{{ ($lbl != 'N' && $map[$i]['m'] == $idx) ? '1' : '' }}</td>
                                    <td>{{ ($lbl != 'N' && $map[$i]['l'] == $idx) ? '1' : '' }}</td>
                                @endfor

                                <td class="sticky-right {{ $lbl == 'N' ? 'bg-danger text-white' : 'bg-light' }}">
                                    {{ $lbl }}
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="papi">
            <div class="table-container shadow-sm">
                <table class="custom-table text-center" id="table-papi">
                    <thead>
                        <tr>
                            <th class="sticky-left bg-papi-yellow z-corner" style="width: 100px; border-right: 3px solid #007bff !important;">No Soal \ No Test</th>
                            @for ($t = 1; $t <= 20; $t++)
                                <th class="bg-papi-green border-dark" style="width: 50px;">{{ $t }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for ($s = 1; $s <= 90; $s++)
                        <tr>
                            <td class="sticky-left bg-papi-yellow border-right-thick">{{ $s }}</td>
                            @for ($t = 1; $t <= 20; $t++)
                                <td>{{ rand(1, 2) }}</td>
                            @endfor
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function exportTableToExcel(tableID, filename = ''){
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        var downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        downloadLink.href = 'data:application/vnd.ms-excel,' + tableHTML;
        downloadLink.download = filename + '.xls';
        downloadLink.click();
    }
</script>
@endsection