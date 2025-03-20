@extends('layouts.app')

@section('title', 'Daftar Transaksi - Keuangan Software House')

@section('page-title', 'Daftar Transaksi')

@section('page-actions')
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Tambah Transaksi
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Daftar Transaksi</h5>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('transaksi.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari transaksi..."
                            value="{{ request('search') }}">
                        <select name="jenis" class="form-select me-2" style="width: 150px">
                            <option value="">Semua Jenis</option>
                            <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan
                            </option>
                            <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>
                                Pengeluaran</option>
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
                        <th>Tanggal</th>
                        <th>Project</th>
                        <th>Karyawan</th>
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
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                            <td>{{ $t->project->nama_project ?? '-' }}</td>
                            <td>{{ $t->karyawan->nama ?? '-' }}</td>
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
                            <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
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
