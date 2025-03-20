@extends('layouts.app')

@section('title', 'Daftar Karyawan - Keuangan Software House')

@section('page-title', 'Daftar Karyawan')

@section('page-actions')
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>Tambah Karyawan
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Daftar Karyawan</h5>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('karyawan.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari karyawan..."
                            value="{{ request('search') }}">
                        <select name="status" class="form-select me-2" style="width: 150px">
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
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Bergabung</th>
                        <th>Gaji Pokok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $k)
                        <tr>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->posisi }}</td>
                            <td>{{ $k->email }}</td>
                            <td>{{ $k->no_telepon }}</td>
                            <td>{{ \Carbon\Carbon::parse($k->tanggal_bergabung)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($k->gaji_pokok, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $k->status === 'aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst(str_replace('_', ' ', $k->status)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('karyawan.show', $k) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $k->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $k->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data karyawan
                                                <strong>{{ $k->nama }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('karyawan.destroy', $k) }}" method="POST">
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
                            <td colspan="8" class="text-center">Tidak ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $karyawan->links() }}
        </div>
    </div>
@endsection
