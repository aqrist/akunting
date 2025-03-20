@extends('layouts.app')

@section('title', 'Edit Transaksi - Keuangan Software House')

@section('page-title', 'Edit Transaksi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Form Edit Transaksi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                value="{{ old('tanggal', \Carbon\Carbon::parse($transaksi->tanggal)->format('Y-m-d')) }}">
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
                                        {{ old('project_id', $transaksi->project_id) == $project->id ? 'selected' : '' }}>
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
                                        {{ old('karyawan_id', $transaksi->karyawan_id) == $k->id ? 'selected' : '' }}>
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
                                <option value="pemasukan"
                                    {{ old('jenis', $transaksi->jenis) == 'pemasukan' ? 'selected' : '' }}>
                                    Pemasukan
                                </option>
                                <option value="pengeluaran"
                                    {{ old('jenis', $transaksi->jenis) == 'pengeluaran' ? 'selected' : '' }}>
                                    Pengeluaran
                                </option>
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
                                    <option value="dp_project"
                                        {{ old('kategori', $transaksi->kategori) == 'dp_project' ? 'selected' : '' }}>Down
                                        Payment Project</option>
                                    <option value="pelunasan_project"
                                        {{ old('kategori', $transaksi->kategori) == 'pelunasan_project' ? 'selected' : '' }}>
                                        Pelunasan Project</option>
                                    <option value="maintenance"
                                        {{ old('kategori', $transaksi->kategori) == 'maintenance' ? 'selected' : '' }}>
                                        Maintenance</option>
                                    <option value="konsultasi"
                                        {{ old('kategori', $transaksi->kategori) == 'konsultasi' ? 'selected' : '' }}>
                                        Konsultasi</option>
                                    <option value="lainnya"
                                        {{ old('kategori', $transaksi->kategori) == 'lainnya' && $transaksi->jenis == 'pemasukan' ? 'selected' : '' }}>
                                        Pemasukan Lainnya</option>
                                </optgroup>
                                <optgroup label="Pengeluaran">
                                    <option value="gaji"
                                        {{ old('kategori', $transaksi->kategori) == 'gaji' ? 'selected' : '' }}>Gaji
                                        Karyawan</option>
                                    <option value="biaya_operasional"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_operasional' ? 'selected' : '' }}>
                                        Biaya Operasional</option>
                                    <option value="biaya_marketing"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_marketing' ? 'selected' : '' }}>
                                        Biaya Marketing</option>
                                    <option value="biaya_server"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_server' ? 'selected' : '' }}>
                                        Biaya Server</option>
                                    <option value="biaya_internet"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_internet' ? 'selected' : '' }}>
                                        Biaya Internet</option>
                                    <option value="biaya_listrik"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_listrik' ? 'selected' : '' }}>
                                        Biaya Listrik</option>
                                    <option value="biaya_sewa"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_sewa' ? 'selected' : '' }}>Biaya
                                        Sewa</option>
                                    <option value="biaya_transportasi"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_transportasi' ? 'selected' : '' }}>
                                        Biaya Transportasi</option>
                                    <option value="biaya_peralatan"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_peralatan' ? 'selected' : '' }}>
                                        Biaya Peralatan</option>
                                    <option value="biaya_konsumsi"
                                        {{ old('kategori', $transaksi->kategori) == 'biaya_konsumsi' ? 'selected' : '' }}>
                                        Biaya Konsumsi</option>
                                    <option value="lainnya"
                                        {{ old('kategori', $transaksi->kategori) == 'lainnya' && $transaksi->jenis == 'pengeluaran' ? 'selected' : '' }}>
                                        Pengeluaran Lainnya</option>
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
                                    name="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}">
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
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
