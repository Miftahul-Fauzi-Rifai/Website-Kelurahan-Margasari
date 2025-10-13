@extends('layouts.app')

@section('title', 'Pengumuman - Kelurahan Marga Sari')
@section('meta_description', 'Pengumuman resmi dan informasi penting dari Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section class="bg-success text-white py-4 py-md-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold">Pengumuman Resmi</h1>
                <p class="lead mb-0">Informasi penting dan pengumuman resmi dari Kelurahan Marga Sari</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Pengumuman</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($announcements->count() > 0)
            <div class="row g-4">
                @foreach($announcements as $announcement)
                <div class="col-12">
                    <article class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-start">
                                @if($announcement->featured_image)
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="{{ asset('storage/' . $announcement->featured_image) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $announcement->title }}" 
                                         style="height: 150px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                @else
                                <div class="col-12">
                                @endif
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <span class="badge bg-success mb-2">Pengumuman</span>
                                            @if($announcement->priority ?? false)
                                                <span class="badge bg-danger ms-1">PENTING</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $announcement->published_at ? $announcement->published_at->format('d M Y') : $announcement->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    
                                    <h4 class="card-title mb-3">
                                        <a href="{{ route('post.show', $announcement->slug) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ $announcement->title }}
                                        </a>
                                    </h4>
                                    
                                    @if($announcement->excerpt)
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($announcement->excerpt, 200) }}
                                    </p>
                                    @else
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit(strip_tags($announcement->content), 200) }}
                                    </p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('post.show', $announcement->slug) }}" 
                                           class="btn btn-success">
                                            Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                        
                                        <div class="text-muted small">
                                            @if($announcement->views > 0)
                                            <i class="bi bi-eye me-1"></i>{{ number_format($announcement->views) }} views
                                            @endif
                                            @if($announcement->user)
                                                <span class="ms-3">
                                                    <i class="bi bi-person me-1"></i>{{ $announcement->user->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($announcements->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navigasi halaman pengumuman">
                        <div class="d-flex justify-content-center">
                            {{ $announcements->links('pagination::bootstrap-4') }}
                        </div>
                    </nav>
                </div>
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-megaphone display-1 text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Belum Ada Pengumuman</h3>
                        <p class="text-muted mb-4">
                            Saat ini belum ada pengumuman yang dipublikasikan. Silakan kembali lagi nanti untuk mendapatkan informasi terbaru.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-success">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Important Notice -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center mb-3 mb-md-0">
                            <i class="bi bi-info-circle text-info" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="col-md-11">
                            <h5 class="alert-heading mb-2">Informasi Penting</h5>
                            <p class="mb-2">
                                <strong>Pastikan Anda selalu mengikuti pengumuman resmi dari Kelurahan Marga Sari.</strong>
                                Informasi yang disampaikan di sini adalah informasi resmi dan terpercaya.
                            </p>
                            <small class="text-muted">
                                Untuk pertanyaan lebih lanjut, silakan hubungi kantor kelurahan di (0542) 123456 atau 
                                email ke kelurahan@margasari.go.id
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-newspaper text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title">Berita Terbaru</h5>
                        <p class="card-text text-muted">Baca berita terbaru dan update dari kelurahan</p>
                        <a href="{{ route('news') }}" class="btn btn-primary">Lihat Berita</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-megaphone text-success mb-3" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title">Buat Pengaduan</h5>
                        <p class="card-text text-muted">Sampaikan aspirasi dan keluhan Anda kepada kami</p>
                        <a href="{{ route('complaint.create') }}" class="btn btn-success">Buat Pengaduan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title a:hover {
    color: #198754 !important;
}

.breadcrumb-dark .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

.alert {
    border-radius: 1rem;
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .row.align-items-start .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
