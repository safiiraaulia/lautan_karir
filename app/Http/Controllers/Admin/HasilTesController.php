<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use App\Models\JawabanTes;
use Illuminate\Http\Request;

class HasilTesController extends Controller
{
    public function index()
    {
        $peserta = Pelamar::whereHas('jawabanTes')->with('jawabanTes')->get();
        
        $labels = ['D', 'I', 'S', 'C', 'N'];

        return view('admin.hasil_tes.index', compact('peserta', 'labels'));
    }
}