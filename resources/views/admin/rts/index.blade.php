@extends('layouts.admin')

@section('title', 'Data RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data RT</h1>
            <p class="text-muted">Kelola data Rukun Tetangga Kelurahan Margasari</p>
        </div>
        <a href="{{ route('admin.rts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah RT Baru
        </a>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total RT
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $rts->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-house text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total KK
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(\App\Models\Rt::sum('num_households')) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Penduduk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format(\App\Models\Rt::sum('num_population')) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.rts.index') }}" class="row g-3">
                <div class="col-md-10">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari RT atau Nama Ketua RT..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-house me-2"></i>Daftar RT
            </h6>
        </div>
        <div class="card-body">
            @if($rts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode RT</th>
                                <th>Ketua RT</th>
                                <th>No. Telepon</th>
                                <th>Jumlah KK</th>
                                <th>Populasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rts as $rt)
                            <tr>
                                <td>
                                    <strong>RT {{ $rt->rt_code }}</strong>
                                </td>
                                <td>{{ $rt->ketua_rt_name }}</td>
                                <td>
                                    <i class="bi bi-telephone me-1"></i>{{ $rt->ketua_rt_phone }}
                                </td>
                                <td>{{ number_format($rt->num_households) }} KK</td>
                                <td>
                                    <i class="bi bi-people me-1"></i>{{ number_format($rt->num_population) }} jiwa
                                    <small class="text-muted d-block">
                                        <i class="bi bi-gender-male text-primary"></i> {{ $rt->num_male }} 
                                        <i class="bi bi-gender-female text-danger ms-2"></i> {{ $rt->num_female }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.rts.edit', $rt) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit Data Dasar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.rts.edit-detail', $rt) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Isi Detail Data">
                                            <i class="bi bi-clipboard-data"></i>
                                        </a>
                                        <form action="{{ route('admin.rts.destroy', $rt) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus RT {{ $rt->rt_code }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $rts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-house text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">
                        @if(request('search'))
                            Tidak ada RT yang ditemukan dengan kata kunci "{{ request('search') }}"
                        @else
                            Belum ada data RT yang terdaftar
                        @endif
                    </p>
                    @if(!request('search'))
                    <a href="{{ route('admin.rts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah RT Pertama
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.text-xs {
    font-size: 0.7rem;
}

/* Fix pagination styling */
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border: 1px solid #dee2e6;
    background-color: #ffffff;
    color: #6c757d;
    font-weight: 400;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #495057;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #ffffff;
    font-weight: 600;
}

.pagination .page-item.disabled .page-link {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #6c757d;
    pointer-events: none;
}
</style>
@endpush

