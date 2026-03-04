<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    public function index(Request $request)
    {
        $isTrash = $request->has('trash');
        $query = Dealer::query();

        if ($isTrash) {
            $dealers = $query->onlyTrashed()->latest('deleted_at')->get();
        } else {
            $dealers = $query->orderBy('kode_dealer', 'ASC')->get();
        }

        return view('admin.dealer.index', compact('dealers', 'isTrash'));
    }

    public function create()
    {
        return view('admin.dealer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_dealer' => 'required|string|max:10|unique:dealer,kode_dealer',
            'nama_dealer' => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'singkatan'   => 'required|string|max:50',
        ]);

        Dealer::create($validated);

        return redirect()->route('admin.dealer.index')
            ->with('success', 'Data dealer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dealer = Dealer::findOrFail($id);
        return view('admin.dealer.edit', compact('dealer'));
    }

    public function update(Request $request, $id)
    {
        $dealer = Dealer::findOrFail($id);

        $validated = $request->validate([
            'nama_dealer' => 'required|string|max:255',
            'kota'        => 'required|string|max:255',
            'singkatan'   => 'required|string|max:50',
        ]);

        $dealer->update($validated);

        return redirect()->route('admin.dealer.index')
            ->with('success', 'Data dealer ' . $dealer->nama_dealer . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->delete();

        return back()->with('success', 'Data dealer berhasil dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $dealer = Dealer::onlyTrashed()->findOrFail($id);
        $dealer->restore();

        return redirect()->route('admin.dealer.index')->with('success', 'Data dealer berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $dealer = Dealer::onlyTrashed()->findOrFail($id);
        
        DB::transaction(function () use ($dealer) {
            $dealer->forceDelete();
        });

        return back()->with('success', 'Data dealer dihapus permanen.');
    }
}