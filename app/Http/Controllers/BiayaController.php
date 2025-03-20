<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function index(Request $request)
    {
        $query = Biaya::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_biaya', 'like', "%{$search}%");
        }

        if ($request->has('jenis') && $request->jenis !== '') {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('periode') && $request->periode !== '') {
            $query->where('periode', $request->periode);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status_aktif', $request->status == 'aktif');
        }

        $biaya = $query->latest()->paginate(10);
        return view('biaya.index', compact('biaya'));
    }

    public function create()
    {
        return view('biaya.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_biaya' => 'required|string|max:255',
            'jenis' => 'required|in:rutin,non_rutin',
            'periode' => 'required|in:harian,mingguan,bulanan,tahunan,tidak_tetap',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);

        $validated['status_aktif'] = $request->has('status_aktif');

        Biaya::create($validated);

        return redirect()
            ->route('biaya.index')
            ->with('success', 'Data biaya berhasil ditambahkan');
    }

    public function show(Biaya $biaya)
    {
        $biaya->load('transaksi');
        return view('biaya.show', compact('biaya'));
    }

    public function edit(Biaya $biaya)
    {
        return view('biaya.edit', compact('biaya'));
    }

    public function update(Request $request, Biaya $biaya)
    {
        $validated = $request->validate([
            'nama_biaya' => 'required|string|max:255',
            'jenis' => 'required|in:rutin,non_rutin',
            'periode' => 'required|in:harian,mingguan,bulanan,tahunan,tidak_tetap',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif' => 'boolean',
            'keterangan' => 'nullable|string'
        ]);

        $validated['status_aktif'] = $request->has('status_aktif');

        $biaya->update($validated);

        return redirect()
            ->route('biaya.index')
            ->with('success', 'Data biaya berhasil diperbarui');
    }

    public function destroy(Biaya $biaya)
    {
        $biaya->delete();

        return redirect()
            ->route('biaya.index')
            ->with('success', 'Data biaya berhasil dihapus');
    }
}
