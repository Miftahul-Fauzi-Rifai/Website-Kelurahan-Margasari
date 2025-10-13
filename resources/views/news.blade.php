@extends('layouts.app')

@section('title', 'Berita - Kelurahan Marga Sari')
@section('meta_description', 'Berita terbaru dan informasi terkini dari Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section class="bg-primary text-white py-4 py-md-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold">Berita Terbaru</h1>
                <p class="lead mb-0">Informasi dan berita terkini dari Kelurahan Marga Sari</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Berita</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($news->count() > 0)
            <div class="row g-4">
                @foreach($news as $article)
                <div class="col-lg-4 col-md-6">
                    <article class="card border-0 shadow-sm h-100">
                        @if($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             class="card-img-top" 
                             alt="{{ $article->title }}" 
                             style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary mb-2">Berita</span>
                                <small class="text-muted d-block">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                </small>
                                @if($article->views > 0)
                                <small class="text-muted">
                                    <i class="bi bi-eye me-1"></i>{{ number_format($article->views) }} views
                                </small>
                                @endif
                            </div>
                            
                            <h5 class="card-title">
                                <a href="{{ route('post.show', $article->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            
                            @if($article->excerpt)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($article->excerpt, 100) }}
                            </p>
                            @else
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            @endif
                            
                            <div class="mt-auto">
                                <a href="{{ route('post.show', $article->slug) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        
                        @if($article->user)
                        <div class="card-footer bg-light border-top-0">
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i>{{ $article->user->name }}
                            </small>
                        </div>
                        @endif
                    </article>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navigasi halaman berita">
                        <div class="d-flex justify-content-center">
                            {{ $news->links('pagination::bootstrap-4') }}
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
                            <i class="bi bi-newspaper display-1 text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Belum Ada Berita</h3>
                        <p class="text-muted mb-4">
                            Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti untuk mendapatkan informasi terbaru.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Newsletter Subscription (Optional) -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h4 class="fw-bold mb-3">Dapatkan Berita Terbaru</h4>
                <p class="text-muted mb-4">
                    Ikuti update berita dan informasi terkini dari Kelurahan Marga Sari
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('announcements') }}" class="btn btn-outline-primary">
                        <i class="bi bi-megaphone me-2"></i>Lihat Pengumuman
                    </a>
                    <a href="{{ route('complaint.create') }}" class="btn btn-primary">
                        <i class="bi bi-envelope me-2"></i>Kontak Kami
                    </a>
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
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title a:hover {
    color: #0d6efd !important;
}

.breadcrumb-dark .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>
@endpush
