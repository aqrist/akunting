<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('posisi', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $karyawan = $query->latest()->paginate(10);
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email',
            'no_telepon' => 'required|string|max:20',
            'tanggal_bergabung' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        Karyawan::create($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('transaksi');
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $karyawan->id,
            'no_telepon' => 'required|string|max:20',
            'tanggal_bergabung' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $karyawan->update($validated);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}
