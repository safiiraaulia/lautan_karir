<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Dealer::orderBy('kode_dealer', 'ASC')->get();

        return view('admin.dealer.index', [
            'dealer' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dealer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dealer' => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'singkatan'   => 'required|string|max:50',
        ]);

        Dealer::create($request->only([
            'nama_dealer',
            'kota',
            'singkatan'
        ]));

        return redirect()->route('admin.dealer.index')
            ->with('success', 'Data dealer berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dealer = Dealer::findOrFail($id);

        return view('admin.dealer.edit', compact('dealer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_dealer' => 'required|string|max:50|unique:dealer,kode_dealer',
            'nama_dealer' => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'singkatan'   => 'required|string|max:50',
        ]);

        Dealer::create($request->only([
            'kode_dealer',
            'nama_dealer',
            'kota',
            'singkatan',
        ]));


        return redirect()->route('admin.dealer.index')
            ->with('success', 'Data dealer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->delete(); // soft delete

        return redirect()->route('admin.dealer.index')
            ->with('success', 'Data dealer berhasil dihapus.');
    }
}
