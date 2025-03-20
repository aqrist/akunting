<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Karyawan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    private function getCategories()
    {
        return [
            'pemasukan' => [
                'dp_project' => 'Down Payment Project',
                'pelunasan_project' => 'Pelunasan Project',
                'maintenance' => 'Maintenance',
                'konsultasi' => 'Konsultasi',
                'lainnya' => 'Pemasukan Lainnya',
            ],
            'pengeluaran' => [
                'gaji' => 'Gaji Karyawan',
                'biaya_operasional' => 'Biaya Operasional',
                'biaya_marketing' => 'Biaya Marketing',
                'biaya_server' => 'Biaya Server',
                'biaya_internet' => 'Biaya Internet',
                'biaya_listrik' => 'Biaya Listrik',
                'biaya_sewa' => 'Biaya Sewa',
                'biaya_transportasi' => 'Biaya Transportasi',
                'biaya_peralatan' => 'Biaya Peralatan',
                'biaya_konsumsi' => 'Biaya Konsumsi',
                'lainnya' => 'Pengeluaran Lainnya',
            ]
        ];
    }

    public function index(Request $request)
    {
        $query = Transaksi::with(['project', 'karyawan']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%")
                ->orWhereHas('project', function ($q) use ($search) {
                    $q->where('nama_project', 'like', "%{$search}%");
                });
        }

        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->where('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        $transaksi = $query->orderBy('tanggal', 'desc')->paginate(15);
        $categories = $this->getCategories();

        return view('transaksi.index', compact('transaksi', 'categories'));
    }

    public function create()
    {
        $projects = Project::where('status', '!=', 'selesai')->get();
        $karyawan = Karyawan::where('status', 'aktif')->get();
        $categories = $this->getCategories();

        return view('transaksi.create', compact('projects', 'karyawan', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'keterangan' => 'nullable|string'
        ]);

        Transaksi::create($validated);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaksi $transaksi)
    {
        $categories = $this->getCategories();
        return view('transaksi.show', compact('transaksi', 'categories'));
    }

    public function edit(Transaksi $transaksi)
    {
        $projects = Project::all();
        $karyawan = Karyawan::all();
        $categories = $this->getCategories();

        return view('transaksi.edit', compact('transaksi', 'projects', 'karyawan', 'categories'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'keterangan' => 'nullable|string'
        ]);

        $transaksi->update($validated);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function byProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $transaksi = Transaksi::where('project_id', $project_id)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        $categories = $this->getCategories();

        return view('transaksi.by-project', compact('transaksi', 'project', 'categories'));
    }

    public function byJenis($jenis)
    {
        $transaksi = Transaksi::where('jenis', $jenis)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        $categories = $this->getCategories();

        return view('transaksi.by-jenis', compact('transaksi', 'jenis', 'categories'));
    }
}
