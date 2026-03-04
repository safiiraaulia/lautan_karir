<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisTes;
use App\Models\SoalKelompok;
use App\Models\JawabanTes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
{
    $soalPapi = \App\Models\SoalKelompok::with('opsiJawaban')
                ->whereHas('jenisTes', function($q){ 
                    $q->where('nama_tes', 'LIKE', '%PAPI%'); 
                })->get();

    $soalDisc = \App\Models\SoalKelompok::with('opsiJawaban')
            ->whereHas('jenisTes', function($q){ 
                $q->where('nama_tes', 'LIKE', '%Kepribadian%');
            })
            ->orderBy('nomor_kelompok', 'asc')
            ->get();

    return view('pelamar.tes.index', compact('soalPapi', 'soalDisc'));
}
    public function store(Request $request)
    {
        $pelamarId = Auth::guard('pelamar')->user()->id_pelamar;
        try {
            DB::beginTransaction();
            // 1. Simpan Jawaban PAPI (Simpan sebagai 1 atau 2)
            if ($request->has('papi')) {
                foreach ($request->papi as $soalId => $pilihan) {
                    $valPapi = ($pilihan == 'A') ? '1' : '2';

                    JawabanTes::updateOrCreate(
                        ['pelamar_id' => $pelamarId, 'soal_id' => $soalId],
                        ['jawaban_papikostik' => $valPapi]
                    );
                }
            }
            // 2. Simpan Jawaban DISC
            if ($request->has('disc')) {
                foreach ($request->disc as $soalId => $pilihan) {
                    JawabanTes::updateOrCreate(
                        ['pelamar_id' => $pelamarId, 'soal_id' => $soalId],
                        [
                            'most'  => $pilihan['M'] ?? null, // Menyimpan kode aspek (D/I/S/C)
                            'least' => $pilihan['L'] ?? null  // Menyimpan kode aspek (D/I/S/C)
                        ]
                    );
                }
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}