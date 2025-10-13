@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
            <p class="text-muted">Selamat datang di panel administrasi Kelurahan Marga Sari</p>
        </div>
        <div class="text-muted">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengguna
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_users']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Artikel Dipublikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['published_posts']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-newspaper text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Layanan Aktif
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $stats['active_services'] }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ $stats['total_services'] > 0 ? ($stats['active_services'] / $stats['total_services']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-card-list text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pengaduan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_complaints']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-megaphone text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Posts -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-newspaper me-2"></i>Artikel Terbaru
                    </h6>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Kelola Artikel
                    </a>
                </div>
                <div class="card-body">
                    @if($stats['recent_posts']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_posts'] as $post)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">
                                                {{ Str::limit($post->title, 50) }}
                                            </div>
                                            <small class="text-muted">
                                                <span class="badge badge-{{ $post->type == 'berita' ? 'primary' : ($post->type == 'pengumuman' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($post->type) }}
                                                </span>
                                            </small>
                                        </td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $post->status == 'published' ? 'success' : 'secondary' }}">
                                                {{ $post->status == 'published' ? 'Dipublikasi' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $post->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <i class="bi bi-eye me-1"></i>{{ $post->views }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Belum ada artikel yang dibuat</p>
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Buat Artikel Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-people me-2"></i>Pengguna Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    @if($stats['recent_users']->count() > 0)
                        @foreach($stats['recent_users'] as $user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $user->name }}</div>
                                <small class="text-muted">
                                    {{ $user->role->display_name ?? 'Masyarakat' }}
                                    @if($user->rt && $user->rw)
                                        • RT {{ $user->rt }}/RW {{ $user->rw }}
                                    @endif
                                </small>
                                <div class="small text-muted">
                                    Bergabung {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-{{ $user->is_active ? 'success' : 'secondary' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Belum ada pengguna terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-lightning me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-primary btn-block py-3">
                                <i class="bi bi-plus-circle d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Buat Artikel</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-success btn-block py-3">
                                <i class="bi bi-newspaper d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Kelola Artikel</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="#" class="btn btn-outline-info btn-block py-3">
                                <i class="bi bi-card-list d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Kelola Layanan</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-warning btn-block py-3">
                                <i class="bi bi-megaphone d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Kelola Pengaduan</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="#" class="btn btn-outline-secondary btn-block py-3">
                                <i class="bi bi-people d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Kelola Pengguna</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-3">
                            <a href="#" class="btn btn-outline-dark btn-block py-3">
                                <i class="bi bi-gear d-block mb-2" style="font-size: 2rem;"></i>
                                <small>Pengaturan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-xs {
    font-size: 0.7rem;
}

.progress-sm {
    height: 0.5rem;
}

.btn-block {
    display: block;
    width: 100%;
}

.badge-primary {
    background-color: #007bff;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-info {
    background-color: #17a2b8;
}

.badge-secondary {
    background-color: #6c757d;
}
</style>
@endpush
