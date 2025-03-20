@extends('layouts.app')

@section('title', 'Transaksi Project ' . $project->nama_project . ' - Keuangan Software House')

@section('page-title', 'Transaksi Project: ' . $project->nama_project)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('transaksi.create') }}?project_id={{ $project->id }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Tambah Transaksi
        </a>
        <a href="{{ route('projects.show', $project) }}" class="btn btn-info">
            <i class="fa fa-eye me-2"></i>Detail Project
        </a>
    </div>
@endsection

@section('content')
    <div class="row mb-4">
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Sisa Pembayaran</h6>
                    <h3 class="text-primary">
                        Rp {{ number_format($project->sisa_pembayaran, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Daftar Transaksi</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                        <tr>
                            <td>{{ $t->tanggal->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $t->jenis === 'pemasukan' ? 'success' : 'danger' }}">
                                    {{ ucfirst($t->jenis) }}
                                </span>
                            </td>
                            <td>{{ $t->kategori }}</td>
                            <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $t->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('transaksi.show', $t) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transaksi.edit', $t) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $t->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus transaksi ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('transaksi.destroy', $t) }}" method="POST">
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
                            <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $transaksi->links() }}
        </div>
    </div>
@endsection
