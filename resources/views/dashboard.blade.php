@extends('layouts.app')

@section('title', 'Dashboard - Keuangan Software House')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Saldo Sekarang -->
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card border-primary h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="fa fa-wallet me-2"></i>Saldo Sekarang
                    </h5>
                    <h2 class="mt-3">Rp {{ number_format($saldoSekarang, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- Pemasukan Bulan Ini -->
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card border-success h-100">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fa fa-arrow-up me-2"></i>Pemasukan Bulan Ini
                    </h5>
                    <h2 class="mt-3">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card border-danger h-100">
                <div class="card-body">
                    <h5 class="card-title text-danger">
                        <i class="fa fa-arrow-down me-2"></i>Pengeluaran Bulan Ini
                    </h5>
                    <h2 class="mt-3">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- Project Aktif -->
        <div class="col-md-3 mb-4">
            <div class="card dashboard-card border-info h-100">
                <div class="card-body">
                    <h5 class="card-title text-info">
                        <i class="fa fa-briefcase me-2"></i>Project Aktif
                    </h5>
                    <h2 class="mt-3">{{ $projectAktif }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pemasukan vs Pengeluaran -->
    <div class="row mt-4">
        <div class="col-md-8 mb-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Pemasukan vs Pengeluaran 6 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="incomeExpenseChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach ($transaksiTerbaru as $transaksi)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $transaksi->kategori }}</h6>
                                    <small>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1">
                                    Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                    <span class="badge {{ $transaksi->jenis == 'pemasukan' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $transaksi->jenis }}
                                    </span>
                                </p>
                                <small>{{ $transaksi->keterangan ?: 'Tidak ada keterangan' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-primary">Lihat Semua Transaksi</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk chart
            const data = @json($data6Bulan);

            // Persiapkan data untuk Chart.js
            const labels = data.map(item => item.bulan);
            const incomeData = data.map(item => item.pemasukan);
            const expenseData = data.map(item => item.pengeluaran);

            // Buat chart pemasukan vs pengeluaran
            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pemasukan',
                            data: incomeData,
                            backgroundColor: 'rgba(40, 167, 69, 0.5)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pengeluaran',
                            data: expenseData,
                            backgroundColor: 'rgba(220, 53, 69, 0.5)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + context.raw.toLocaleString(
                                        'id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
