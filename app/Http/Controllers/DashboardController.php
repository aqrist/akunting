<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total saldo saat ini
        $totalPemasukan = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldoSekarang = $totalPemasukan - $totalPengeluaran;

        // Pemasukan & pengeluaran bulan ini
        $bulanIni = Carbon::now()->startOfMonth();
        $pemasukanBulanIni = Transaksi::where('jenis', 'pemasukan')
            ->where('tanggal', '>=', $bulanIni)
            ->sum('jumlah');
        $pengeluaranBulanIni = Transaksi::where('jenis', 'pengeluaran')
            ->where('tanggal', '>=', $bulanIni)
            ->sum('jumlah');

        // Project aktif
        $projectAktif = Project::where('status', '!=', 'selesai')->count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['project', 'karyawan'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Data grafik pemasukan vs pengeluaran 6 bulan terakhir
        $data6Bulan = $this->getDataGrafik();

        return view('dashboard', compact(
            'saldoSekarang',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'projectAktif',
            'transaksiTerbaru',
            'data6Bulan'
        ));
    }

    private function getDataGrafik()
    {
        $data = [];

        // Data 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanFormat = $bulan->format('M Y');

            $pemasukan = Transaksi::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');

            $pengeluaran = Transaksi::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('jumlah');

            $data[] = [
                'bulan' => $bulanFormat,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran
            ];
        }

        return $data;
    }
}
