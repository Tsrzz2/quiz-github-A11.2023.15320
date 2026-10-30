<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Menampilkan jadwal periksa milik dokter yang login
     */
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::user()->id)->get();
        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    /**
     * Menampilkan form tambah jadwal
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Menyimpan data jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari'         => 'required|string',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required',
        ]);

        JadwalPeriksa::create([
            'id_dokter'   => Auth::user()->id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'aktif'       => true,
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('message', 'Jadwal Periksa berhasil ditambahkan')
            ->with('type', 'success');
    }

    /**
     * Menampilkan form edit jadwal
     */
    public function edit(JadwalPeriksa $jadwal_periksa)
    {
        // Pastikan jadwal milik dokter yang login
        if ($jadwal_periksa->id_dokter !== Auth::user()->id) {
            abort(403);
        }

        return view('dokter.jadwal-periksa.edit', compact('jadwal_periksa'));
    }

    /**
     * Memperbarui data jadwal
     */
    public function update(Request $request, JadwalPeriksa $jadwal_periksa)
    {
        // Pastikan jadwal milik dokter yang login
        if ($jadwal_periksa->id_dokter !== Auth::user()->id) {
            abort(403);
        }

        $request->validate([
            'hari'         => 'required|string',
            'jam_mulai'    => 'required',
            'jam_selesai'  => 'required',
        ]);

        $jadwal_periksa->update([
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'aktif'       => $request->has('aktif') ? true : false,
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('message', 'Jadwal Periksa berhasil diperbarui')
            ->with('type', 'success');
    }

    /**
     * Menghapus data jadwal
     */
    public function destroy(JadwalPeriksa $jadwal_periksa)
    {
        // Pastikan jadwal milik dokter yang login
        if ($jadwal_periksa->id_dokter !== Auth::user()->id) {
            abort(403);
        }

        $jadwal_periksa->delete();

        return redirect()->route('jadwal-periksa.index')
            ->with('message', 'Jadwal Periksa berhasil dihapus')
            ->with('type', 'success');
    }
}
