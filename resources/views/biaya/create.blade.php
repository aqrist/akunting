@extends('layouts.app')

@section('title', 'Tambah Biaya - Keuangan Software House')

@section('page-title', 'Tambah Biaya')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Form Tambah Biaya</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('biaya.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Biaya</label>
                            <input type="text" class="form-control @error('nama_biaya') is-invalid @enderror"
                                name="nama_biaya" value="{{ old('nama_biaya') }}">
                            @error('nama_biaya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" name="jenis">
                                <option value="">Pilih Jenis Biaya</option>
                                <option value="rutin" {{ old('jenis') == 'rutin' ? 'selected' : '' }}>Rutin</option>
                                <option value="non_rutin" {{ old('jenis') == 'non_rutin' ? 'selected' : '' }}>Non Rutin
                                </option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Periode</label>
                            <select class="form-select @error('periode') is-invalid @enderror" name="periode">
                                <option value="">Pilih Periode</option>
                                <option value="harian" {{ old('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
                                <option value="mingguan" {{ old('periode') == 'mingguan' ? 'selected' : '' }}>Mingguan
                                </option>
                                <option value="bulanan" {{ old('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="tahunan" {{ old('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                <option value="tidak_tetap" {{ old('periode') == 'tidak_tetap' ? 'selected' : '' }}>Tidak
                                    Tetap</option>
                            </select>
                            @error('periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    name="jumlah" value="{{ old('jumlah') }}">
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                            <small class="text-muted">Kosongkan jika tidak ada batas waktu</small>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="status_aktif" id="status_aktif"
                                    value="1" {{ old('status_aktif', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_aktif">Status Aktif</label>
                            </div>
                            @error('status_aktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('biaya.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
