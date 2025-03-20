@extends('layouts.app')

@section('title', 'Daftar Biaya - Keuangan Software House')

@section('page-title', 'Daftar Biaya')

@section('page-actions')
    <a href="{{ route('biaya.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Tambah Biaya
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Daftar Biaya</h5>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('biaya.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari biaya..."
                            value="{{ request('search') }}">
                        <select name="jenis" class="form-select" style="width: 150px">
                            <option value="">Semua Jenis</option>
                            <option value="rutin" {{ request('jenis') == 'rutin' ? 'selected' : '' }}>Rutin</option>
                            <option value="non_rutin" {{ request('jenis') == 'non_rutin' ? 'selected' : '' }}>Non Rutin
                            </option>
                        </select>
                        <select name="periode" class="form-select" style="width: 150px">
                            <option value="">Semua Periode</option>
                            <option value="harian" {{ request('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ request('periode') == 'mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ request('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="tidak_tetap" {{ request('periode') == 'tidak_tetap' ? 'selected' : '' }}>Tidak
                                Tetap</option>
                        </select>
                        <select name="status" class="form-select" style="width: 150px">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                Aktif</option>
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
                        <th>Nama Biaya</th>
                        <th>Jenis</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($biaya as $b)
                        <tr>
                            <td>{{ $b->nama_biaya }}</td>
                            <td>
                                <span class="badge bg-{{ $b->jenis === 'rutin' ? 'info' : 'warning' }}">
                                    {{ ucfirst(str_replace('_', ' ', $b->jenis)) }}
                                </span>
                            </td>
                            <td>{{ ucfirst($b->periode) }}</td>
                            <td>Rp {{ number_format($b->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $b->tanggal_mulai->format('d M Y') }}</td>
                            <td>{{ $b->tanggal_selesai ? $b->tanggal_selesai->format('d M Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $b->status_aktif ? 'success' : 'danger' }}">
                                    {{ $b->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('biaya.show', $b) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('biaya.edit', $b) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $b->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $b->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus biaya
                                                <strong>{{ $b->nama_biaya }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('biaya.destroy', $b) }}" method="POST">
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
                            <td colspan="8" class="text-center">Tidak ada data biaya.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $biaya->links() }}
        </div>
    </div>
@endsection
