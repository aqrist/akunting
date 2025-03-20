@extends('layouts.app')

@section('title', 'Detail Karyawan - Keuangan Software House')

@section('page-title', 'Detail Karyawan')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('karyawan.edit', $karyawan) }}" class="btn btn-warning">
            <i class="fa fa-edit me-2"></i>Edit Karyawan
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Karyawan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Nama Lengkap</th>
                            <td>{{ $karyawan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Posisi</th>
                            <td>{{ $karyawan->posisi }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $karyawan->email }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ $karyawan->no_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Bergabung</th>
                            <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Gaji Pokok</th>
                            <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $karyawan->status === 'aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst(str_replace('_', ' ', $karyawan->status)) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Riwayat Gaji</h5>
                </div>
                <div class="card-body">
                    @if ($karyawan->gajiHistory()->count() > 0)
                        <div class="list-group">
                            @foreach ($karyawan->gajiHistory()->take(5) as $gaji)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $gaji->keterangan }}</h6>
                                            <small>{{ $gaji->tanggal->format('d M Y') }}</small>
                                        </div>
                                        <span class="badge bg-success">
                                            Rp {{ number_format($gaji->jumlah, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted">Belum ada riwayat gaji</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Transaksi Terkait</h5>
                </div>
                <div class="card-body">
                    @if ($karyawan->transaksi->count() > 0)
                        <div class="list-group">
                            @foreach ($karyawan->transaksi->take(5) as $transaksi)
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
                    @else
                        <p class="text-center text-muted">Belum ada transaksi terkait</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
