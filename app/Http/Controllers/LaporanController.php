<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriLaporan;
use App\Http\Requests\LaporanRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:mahasiswa');
    }

    public function index()
    {
        $laporan = Laporan::where('user_id', Auth::id())->with('kategori')->get();
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        $kategori = KategoriLaporan::all();
        return view('laporan.create', compact('kategori'));
    }

    public function store(LaporanRequest $request)
    {
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        Laporan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $fotoPath,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat.');
    }

    public function show(Laporan $laporan)
    {
        $this->authorize('view', $laporan);
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        $this->authorize('update', $laporan);
        $kategori = KategoriLaporan::all();
        return view('laporan.edit', compact('laporan', 'kategori'));
    }

    public function update(LaporanRequest $request, Laporan $laporan)
    {
        $this->authorize('update', $laporan);

        $fotoPath = $laporan->foto;
        if ($request->hasFile('foto')) {
            if ($laporan->foto) {
                Storage::disk('public')->delete($laporan->foto);
            }
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        $laporan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $fotoPath,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $this->authorize('delete', $laporan);

        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
