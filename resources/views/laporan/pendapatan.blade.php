@extends('layouts.app')

@section('title', 'Laporan Pendapatan - Keuangan Software House')

@section('page-title', 'Laporan Pendapatan')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.pendapatan') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="all" {{ $bulan == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create(null, $m, 1)->format('F') }}
                            </option>
                        @endforeach
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Pendapatan</h6>
                    <h3 class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        @foreach ($pendapatanByKategori as $kategori => $items)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ $kategori }}</h6>
                        <h4>Rp {{ number_format($items->sum('jumlah'), 0, ',', '.') }}</h4>
                        <small class="text-muted">{{ $items->count() }} transaksi</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Detail Pendapatan</h5>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fa fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Project</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendapatan as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $p->project->nama_project ?? '-' }}</td>
                            <td>{{ $p->kategori }}</td>
                            <td>{{ $p->keterangan }}</td>
                            <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th colspan="4">Total Pendapatan</th>
                        <th class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
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
        }
    </style>
@endpush
