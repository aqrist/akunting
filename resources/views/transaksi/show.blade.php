@extends('layouts.app')

@section('title', 'Detail Transaksi - Keuangan Software House')

@section('page-title', 'Detail Transaksi')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning">
            <i class="fa fa-edit me-2"></i>Edit Transaksi
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Tanggal</th>
                            <td>{{ $transaksi->tanggal->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Project</th>
                            <td>{{ $transaksi->project->nama_project ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Karyawan</th>
                            <td>{{ $transaksi->karyawan->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Transaksi</th>
                            <td>
                                <span class="badge bg-{{ $transaksi->jenis === 'pemasukan' ? 'success' : 'danger' }}">
                                    {{ ucfirst($transaksi->jenis) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $transaksi->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @if ($transaksi->project)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi Project</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $transaksi->project->nama_project }}</h6>
                        <p class="text-muted mb-3">{{ $transaksi->project->client }}</p>

                        <div class="mb-3">
                            <label class="form-label">Nilai Project</label>
                            <h5>Rp {{ number_format($transaksi->project->nilai_project, 0, ',', '.') }}</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Terbayar</label>
                            <h5 class="text-success">Rp
                                {{ number_format($transaksi->project->total_dibayar, 0, ',', '.') }}</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sisa Pembayaran</label>
                            <h5 class="text-danger">Rp
                                {{ number_format($transaksi->project->sisa_pembayaran, 0, ',', '.') }}</h5>
                        </div>

                        <a href="{{ route('projects.show', $transaksi->project) }}" class="btn btn-info w-100">
                            <i class="fa fa-external-link-alt me-2"></i>Lihat Detail Project
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
