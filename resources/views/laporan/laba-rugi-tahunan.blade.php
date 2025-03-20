@extends('layouts.app')

@section('title', 'Laporan Laba Rugi Tahunan - Keuangan Software House')

@section('page-title', 'Laporan Laba Rugi Tahunan')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.laba-rugi') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Pendapatan</h6>
                    <h3 class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Biaya</h6>
                    <h3 class="text-danger">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Laba/Rugi Bersih</h6>
                    <h3 class="{{ $totalLabaRugi >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format(abs($totalLabaRugi), 0, ',', '.') }}
                        {{ $totalLabaRugi >= 0 ? '(LABA)' : '(RUGI)' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Detail Laba Rugi per Bulan</h5>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fa fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th class="text-end">Pendapatan</th>
                        <th class="text-end">Biaya</th>
                        <th class="text-end">Laba/Rugi</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $item)
                        <tr>
                            <td>{{ $item['bulan'] }}</td>
                            <td class="text-end">Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item['biaya'], 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format(abs($item['laba_rugi']), 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $item['laba_rugi'] >= 0 ? 'success' : 'danger' }}">
                                    {{ $item['laba_rugi'] >= 0 ? 'LABA' : 'RUGI' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th>Total</th>
                        <th class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                        <th class="text-end">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</th>
                        <th class="text-end">Rp {{ number_format(abs($totalLabaRugi), 0, ',', '.') }}</th>
                        <th class="text-center">
                            <span class="badge bg-{{ $totalLabaRugi >= 0 ? 'success' : 'danger' }}">
                                {{ $totalLabaRugi >= 0 ? 'LABA' : 'RUGI' }}
                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5>Grafik Laba Rugi</h5>
        </div>
        <div class="card-body">
            <canvas id="labaRugiChart" height="300"></canvas>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {

            .btn,
            form,
            .navbar,
            .sidebar {
                display: none !important;
            }

            .card {
                border: none !important;
            }

            .card-header {
                background: none !important;
                border: none !important;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
            }

            #labaRugiChart {
                display: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('labaRugiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($laporan, 'bulan')) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode(array_column($laporan, 'pendapatan')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }, {
                    label: 'Biaya',
                    data: {!! json_encode(array_column($laporan, 'biaya')) !!},
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }, {
                    label: 'Laba/Rugi',
                    data: {!! json_encode(array_column($laporan, 'laba_rugi')) !!},
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' +
                                    new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
