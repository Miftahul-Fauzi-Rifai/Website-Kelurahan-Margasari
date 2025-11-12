@extends('layouts.app')

@section('title', 'Pengumuman - Kelurahan Marga Sari')
@section('meta_description', 'Pengumuman resmi dan informasi penting dari Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section id="announcements-hero" class="announcements-hero-section text-white py-4 py-md-5 page-header-announcement">
    <div class="container position-relative">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">Pengumuman Resmi</h1>
        <p class="lead mb-0 mobile-subtitle">Informasi penting dan pengumuman resmi dari Kelurahan Marga Sari</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($announcements->count() > 0)
            <div class="row g-4">
                @foreach($announcements as $announcement)
                <div class="col-6 col-md-6 col-lg-6">
                    <article class="card border-0 shadow-sm h-100">
                        @if($announcement->featured_image)
                        <img src="{{ asset('storage/' . $announcement->featured_image) }}" 
                             class="card-img-top" 
                             alt="{{ $announcement->title }}" 
                             style="height: 150px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge" style="background-color: #CC710A; color: white;">Pengumuman</span>
                                @if($announcement->priority ?? false)
                                    <span class="badge bg-danger ms-1">PENTING</span>
                                @endif
                            </div>
                            
                            <h5 class="card-title mb-2">
                                <a href="{{ route('post.show', $announcement->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($announcement->title, 60) }}
                                </a>
                            </h5>
                            
                            @if($announcement->excerpt)
                            <p class="card-text text-muted mb-3 announcement-excerpt">
                                {{ Str::limit($announcement->excerpt, 100) }}
                            </p>
                            @else
                            <p class="card-text text-muted mb-3 announcement-excerpt">
                                {{ Str::limit(strip_tags($announcement->content), 100) }}
                            </p>
                            @endif
                            
                            <div class="mt-auto">
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $announcement->published_at ? $announcement->published_at->format('d M Y') : $announcement->created_at->format('d M Y') }}
                                </small>
                                <a href="{{ route('post.show', $announcement->slug) }}" 
                                   class="btn btn-sm btn-outline-warning w-100">
                                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
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
                        <a href="{{ route('home') }}" class="btn" style="background-color: #CC710A; color: white;">
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
    color: #0d6efd !important;
}

.alert {
    border-radius: 1rem;
}

/* Mobile Title & Subtitle */
.mobile-title {
    font-size: 1.8rem;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.mobile-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

@media (min-width: 576px) {
    .mobile-title {
        font-size: 2.2rem;
    }
    
    .mobile-subtitle {
        font-size: 1.125rem;
    }
}

@media (min-width: 768px) {
    .mobile-title {
        font-size: 2.5rem;
    }
    
    .mobile-subtitle {
        font-size: 1.25rem;
    }
}

/* Page Header Spacing untuk menghindari navbar */
.page-header-announcement {
    padding-top: 90px !important; /* Reasonable space from fixed navbar */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header-announcement {
        padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
    }
}

@media (max-width: 576px) {
    .page-header-announcement {
        padding-top: 70px !important; /* Minimal padding on small mobile */
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .row.align-items-start .col-md-3 {
        margin-bottom: 1rem;
    }
}

/* ==== MOBILE 2-COLUMN LAYOUT ==== */
@media (max-width: 768px) {
    .col-6 article.card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .col-6 .card-img-top {
        height: 120px !important;
        object-fit: cover;
    }
    
    .col-6 .card-body {
        padding: 0.75rem !important;
        font-size: 0.85rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .col-6 .card-title {
        font-size: 0.9rem !important;
        line-height: 1.3;
        margin-bottom: 0.5rem !important;
        font-weight: 600;
    }
    
    .col-6 .announcement-excerpt {
        font-size: 0.75rem !important;
        line-height: 1.4;
        margin-bottom: 0.5rem !important;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .col-6 .card-body small {
        font-size: 0.7rem !important;
    }
    
    .col-6 .badge {
        font-size: 0.65rem !important;
        padding: 0.25rem 0.4rem;
    }
    
    .col-6 .btn-sm {
        font-size: 0.75rem !important;
        padding: 0.35rem 0.5rem !important;
    }
}

@media (max-width: 576px) {
    .col-6 .card-img-top {
        height: 100px !important;
    }
    
    .col-6 .card-body {
        padding: 0.6rem !important;
        font-size: 0.8rem;
    }
    
    .col-6 .card-title {
        font-size: 0.85rem !important;
    }
    
    .col-6 .announcement-excerpt {
        font-size: 0.7rem !important;
        -webkit-line-clamp: 2;
    }
    
    .col-6 .card-body small {
        font-size: 0.65rem !important;
    }
    
    .col-6 .badge {
        font-size: 0.6rem !important;
        padding: 0.2rem 0.35rem;
    }
    
    .col-6 .btn-sm {
        font-size: 0.7rem !important;
        padding: 0.3rem 0.4rem !important;
    }
}

/* ==== ANNOUNCEMENTS HERO SECTION - BACKGROUND ORANGE ==== */
.announcements-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
    background: linear-gradient(135deg, #CC710A 0%, #A35808 100%);
}

.announcements-hero-section .container {
    position: relative;
    z-index: 2;
}
</style>
@endpush

@push('scripts')
@endpush
