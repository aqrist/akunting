@extends('layouts.app')

@section('title', 'Edit Project - Keuangan Software House')

@section('page-title', 'Edit Project')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Form Edit Project</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Project</label>
                            <input type="text" class="form-control @error('nama_project') is-invalid @enderror"
                                name="nama_project" value="{{ old('nama_project', $project->nama_project) }}">
                            @error('nama_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" class="form-control @error('client') is-invalid @enderror" name="client"
                                value="{{ old('client', $project->client) }}">
                            @error('client')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Project</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('nilai_project') is-invalid @enderror"
                                    name="nilai_project" value="{{ old('nilai_project', $project->nilai_project) }}">
                            </div>
                            @error('nilai_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', Carbon\Carbon::parse($project->tanggal_mulai)->format('Y-m-d')) }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                name="deadline" value="{{ old('deadline', Carbon\Carbon::parse($project->deadline)->format('Y-m-d')) }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="baru" {{ old('status', $project->status) == 'baru' ? 'selected' : '' }}>
                                    Baru</option>
                                <option value="proses" {{ old('status', $project->status) == 'proses' ? 'selected' : '' }}>
                                    Proses</option>
                                <option value="selesai"
                                    {{ old('status', $project->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3">{{ old('keterangan', $project->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
