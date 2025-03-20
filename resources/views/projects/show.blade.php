@extends('layouts.app')

@section('title', 'Detail Project - Keuangan Software House')

@section('page-title', 'Detail Project')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
            <i class="fa fa-edit me-2"></i>Edit Project
        </a>
        <a href="{{ route('transaksi.by-project', $project->id) }}" class="btn btn-success">
            <i class="fa fa-money-bill me-2"></i>Lihat Transaksi
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Project</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Nama Project</th>
                            <td>{{ $project->nama_project }}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{{ $project->client }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Project</th>
                            <td>Rp {{ number_format($project->nilai_project, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Deadline</th>
                            <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span
                                    class="badge bg-{{ $project->status == 'baru' ? 'info' : ($project->status == 'proses' ? 'warning' : 'success') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $project->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Ringkasan Keuangan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Total Nilai Project</label>
                        <h4>Rp {{ number_format($project->nilai_project, 0, ',', '.') }}</h4>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Terbayar</label>
                        <h4 class="text-success">Rp {{ number_format($project->total_dibayar, 0, ',', '.') }}</h4>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sisa Pembayaran</label>
                        <h4 class="text-danger">Rp {{ number_format($project->sisa_pembayaran, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Riwayat Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    @if ($project->transaksi->count() > 0)
                        <div class="list-group">
                            @foreach ($project->transaksi->take(5) as $transaksi)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $transaksi->keterangan }}</h6>
                                            <small>{{ Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</small>
                                        </div>
                                        <span
                                            class="badge bg-{{ $transaksi->jenis === 'pemasukan' ? 'success' : 'danger' }}">
                                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted">Belum ada transaksi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
