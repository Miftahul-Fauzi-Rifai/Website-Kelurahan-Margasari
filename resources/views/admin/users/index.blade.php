@extends('layouts.admin')

@section('title', 'Kelola Ketua RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kelola Ketua RT</h1>
            <p class="text-muted">Manajemen akun Ketua RT</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Ketua RT
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Ketua RT</h6>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>RT/RW</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary">RT {{ $user->rt }} / RW {{ $user->rw }}</span>
                                </td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-info" 
                                                    title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="bi bi-{{ $user->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="if(confirm('Yakin ingin menghapus akun ini? Semua laporan terkait akan ikut terhapus.')) document.getElementById('delete-{{ $user->id }}').submit()"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada Ketua RT yang terdaftar</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Ketua RT Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

