<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function arusKas(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->format('Y-m-d'));

        $transaksi = Transaksi::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->orderBy('tanggal')
            ->get();

        $saldoAwal = Transaksi::where('tanggal', '<', $tanggalMulai)
            ->selectRaw('SUM(CASE WHEN jenis = "pemasukan" THEN jumlah ELSE 0 END) - 
                         SUM(CASE WHEN jenis = "pengeluaran" THEN jumlah ELSE 0 END) as saldo')
            ->first()->saldo ?? 0;

        return view('laporan.arus-kas', compact('transaksi', 'saldoAwal', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function pendapatan(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan', Carbon::now()->month);

        $pendapatan = Transaksi::where('jenis', 'pemasukan')
            ->when($bulan != 'all', function ($query) use ($bulan, $tahun) {
                return $query->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $bulan);
            })
            ->when($bulan == 'all', function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->with('project')
            ->orderBy('tanggal')
            ->get();

        // Pendapatan dikelompokkan berdasarkan kategori
        $pendapatanByKategori = $pendapatan->groupBy('kategori');
        $totalPendapatan = $pendapatan->sum('jumlah');

        return view('laporan.pendapatan', compact(
            'pendapatan',
            'pendapatanByKategori',
            'totalPendapatan',
            'tahun',
            'bulan'
        ));
    }

    public function biaya(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan', Carbon::now()->month);

        $biaya = Transaksi::where('jenis', 'pengeluaran')
            ->when($bulan != 'all', function ($query) use ($bulan, $tahun) {
                return $query->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $bulan);
            })
            ->when($bulan == 'all', function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->with(['project', 'karyawan'])
            ->orderBy('tanggal')
            ->get();

        // Biaya dikelompokkan berdasarkan kategori
        $biayaByKategori = $biaya->groupBy('kategori');
        $totalBiaya = $biaya->sum('jumlah');

        return view('laporan.biaya', compact(
            'biaya',
            'biayaByKategori',
            'totalBiaya',
            'tahun',
            'bulan'
        ));
    }

    public function labaRugi(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan', 'all');

        // Jika bulan all, maka tampilkan laporan laba-rugi per bulan selama setahun
        if ($bulan == 'all') {
            $laporan = [];

            for ($i = 1; $i <= 12; $i++) {
                $namaBulan = Carbon::create($tahun, $i, 1)->format('F');

                $pendapatan = Transaksi::where('jenis', 'pemasukan')
                    ->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $i)
                    ->sum('jumlah');

                $biaya = Transaksi::where('jenis', 'pengeluaran')
                    ->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $i)
                    ->sum('jumlah');

                $laporan[] = [
                    'bulan' => $namaBulan,
                    'pendapatan' => $pendapatan,
                    'biaya' => $biaya,
                    'laba_rugi' => $pendapatan - $biaya
                ];
            }

            $totalPendapatan = array_sum(array_column($laporan, 'pendapatan'));
            $totalBiaya = array_sum(array_column($laporan, 'biaya'));
            $totalLabaRugi = $totalPendapatan - $totalBiaya;

            return view('laporan.laba-rugi-tahunan', compact(
                'laporan',
                'totalPendapatan',
                'totalBiaya',
                'totalLabaRugi',
                'tahun'
            ));
        } else {
            // Laporan laba-rugi untuk bulan tertentu, dengan rincian kategori
            $pendapatan = Transaksi::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get()
                ->groupBy('kategori');

            $biaya = Transaksi::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get()
                ->groupBy('kategori');

            $totalPendapatan = $pendapatan->flatten(1)->sum('jumlah');
            $totalBiaya = $biaya->flatten(1)->sum('jumlah');
            $labaRugi = $totalPendapatan - $totalBiaya;

            $namaBulan = Carbon::create($tahun, $bulan, 1)->format('F');

            return view('laporan.laba-rugi-bulanan', compact(
                'pendapatan',
                'biaya',
                'totalPendapatan',
                'totalBiaya',
                'labaRugi',
                'tahun',
                'bulan',
                'namaBulan'
            ));
        }
    }
}
