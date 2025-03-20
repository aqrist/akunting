<!-- File: resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Project - Keuangan Software House')

@section('page-title', 'Daftar Project')

@section('page-actions')
    <a href="{{ route('projects.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Tambah Project Baru
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Daftar Project</h5>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('projects.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari project..."
                            value="{{ request('search') }}">
                        <select name="status" class="form-select me-2" style="width: 150px">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Project</th>
                        <th>Client</th>
                        <th>Nilai Project</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Tanggal Mulai</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->nama_project }}</td>
                            <td>{{ $project->client }}</td>
                            <td>Rp {{ number_format($project->nilai_project, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($project->total_dibayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($project->sisa_pembayaran, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $project->status == 'baru' ? 'info' : ($project->status == 'proses' ? 'warning' : 'success') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('transaksi.by-project', $project->id) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-money-bill"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $project->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus project
                                                <strong>{{ $project->nama_project }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data project.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $projects->links() }}
        </div>
    </div>
@endsection
