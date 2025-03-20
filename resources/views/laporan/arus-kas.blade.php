@extends('layouts.app')

@section('title', 'Laporan Arus Kas - Keuangan Software House')

@section('page-title', 'Laporan Arus Kas')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.arus-kas') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="{{ $tanggalMulai }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
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
                    <h6 class="card-title">Saldo Awal</h6>
                    <h3>Rp {{ number_format($saldoAwal, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Pemasukan</h6>
                    <h3 class="text-success">
                        Rp {{ number_format($transaksi->where('jenis', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Pengeluaran</h6>
                    <h3 class="text-danger">
                        Rp {{ number_format($transaksi->where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Detail Transaksi</h5>
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
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ Carbon\Carbon::parse($tanggalMulai)->subDay()->format('d/m/Y') }}</td>
                        <td colspan="4">Saldo Awal</td>
                        <td>Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                    </tr>
                    @php $saldo = $saldoAwal; @endphp
                    @foreach ($transaksi as $t)
                        @php
                            if ($t->jenis === 'pemasukan') {
                                $saldo += $t->jumlah;
                            } else {
                                $saldo -= $t->jumlah;
                            }
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $t->keterangan }}</td>
                            <td>{{ $t->kategori }}</td>
                            <td>
                                @if ($t->jenis === 'pemasukan')
                                    Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($t->jenis === 'pengeluaran')
                                    Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th colspan="3">Total</th>
                        <th>Rp {{ number_format($transaksi->where('jenis', 'pemasukan')->sum('jumlah'), 0, ',', '.') }}
                        </th>
                        <th>Rp {{ number_format($transaksi->where('jenis', 'pengeluaran')->sum('jumlah'), 0, ',', '.') }}
                        </th>
                        <th>Rp {{ number_format($saldo, 0, ',', '.') }}</th>
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
