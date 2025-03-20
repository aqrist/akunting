@extends('layouts.app')

@section('title', 'Detail Biaya - Keuangan Software House')

@section('page-title', 'Detail Biaya')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('biaya.edit', $biaya) }}" class="btn btn-warning">
            <i class="fa fa-edit me-2"></i>Edit Biaya
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Biaya</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Nama Biaya</th>
                            <td>{{ $biaya->nama_biaya }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>
                                <span class="badge bg-{{ $biaya->jenis === 'rutin' ? 'info' : 'warning' }}">
                                    {{ ucfirst(str_replace('_', ' ', $biaya->jenis)) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>{{ ucfirst($biaya->periode) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp {{ number_format($biaya->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ $biaya->tanggal_mulai->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ $biaya->tanggal_selesai ? $biaya->tanggal_selesai->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $biaya->status_aktif ? 'success' : 'danger' }}">
                                    {{ $biaya->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $biaya->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Riwayat Transaksi</h5>
                </div>
                <div class="card-body">
                    @if ($biaya->transaksi->count() > 0)
                        <div class="list-group">
                            @foreach ($biaya->transaksi->take(5) as $transaksi)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $transaksi->keterangan }}</h6>
                                            <small>{{ $transaksi->tanggal->format('d M Y') }}</small>
                                        </div>
                                        <span
                                            class="badge bg-{{ $transaksi->jenis === 'pemasukan' ? 'success' : 'danger' }}">
                                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($biaya->transaksi->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('transaksi.index', ['biaya_id' => $biaya->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    Lihat Semua Transaksi
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted">Belum ada transaksi untuk biaya ini</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Ringkasan Keuangan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Total Transaksi</label>
                        <h4>{{ $biaya->transaksi->count() }} Transaksi</h4>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Pengeluaran</label>
                        <h4 class="text-danger">
                            Rp {{ number_format($biaya->transaksi->sum('jumlah'), 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
