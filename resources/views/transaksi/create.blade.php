@extends('layouts.app')

@section('title', 'Tambah Transaksi - Keuangan Software House')

@section('page-title', 'Tambah Transaksi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Form Tambah Transaksi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                value="{{ old('tanggal', date('Y-m-d')) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select class="form-select @error('project_id') is-invalid @enderror" name="project_id">
                                <option value="">Pilih Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->nama_project }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Karyawan</label>
                            <select class="form-select @error('karyawan_id') is-invalid @enderror" name="karyawan_id">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" name="jenis" id="jenis">
                                <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan
                                </option>
                                <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>
                                    Pengeluaran</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" name="kategori"
                                id="kategori">
                                <option value="">Pilih Kategori</option>
                                <optgroup label="Pemasukan">
                                    <option value="dp_project">Down Payment Project</option>
                                    <option value="pelunasan_project">Pelunasan Project</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="konsultasi">Konsultasi</option>
                                    <option value="lainnya">Pemasukan Lainnya</option>
                                </optgroup>
                                <optgroup label="Pengeluaran">
                                    <option value="gaji">Gaji Karyawan</option>
                                    <option value="biaya_operasional">Biaya Operasional</option>
                                    <option value="biaya_marketing">Biaya Marketing</option>
                                    <option value="biaya_server">Biaya Server</option>
                                    <option value="biaya_internet">Biaya Internet</option>
                                    <option value="biaya_listrik">Biaya Listrik</option>
                                    <option value="biaya_sewa">Biaya Sewa</option>
                                    <option value="biaya_transportasi">Biaya Transportasi</option>
                                    <option value="biaya_peralatan">Biaya Peralatan</option>
                                    <option value="biaya_konsumsi">Biaya Konsumsi</option>
                                    <option value="lainnya">Pengeluaran Lainnya</option>
                                </optgroup>
                            </select>
                            @error('kategori')
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

                    <div class="col-12">
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
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
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
