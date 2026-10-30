<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Menampilkan daftar obat
     */
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Menampilkan form tambah obat
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Menyimpan data obat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:35',
            'harga'     => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil ditambahkan')
            ->with('type', 'success');
    }

    /**
     * Menampilkan form edit obat
     */
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Memperbarui data obat
     */
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:35',
            'harga'     => 'required|integer|min:0',
        ]);

        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil diperbarui')
            ->with('type', 'success');
    }

    /**
     * Menghapus data obat
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil dihapus')
            ->with('type', 'success');
    }
}
