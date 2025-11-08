@extends('layouts.app')

@section('title', 'Berita - Kelurahan Marga Sari')
@section('meta_description', 'Berita terbaru dan informasi terkini dari Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section id="news-hero" class="news-hero-section text-white py-4 py-md-5 page-header-news">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 fw-bold">Berita Terbaru</h1>
                <p class="lead mb-0">Informasi dan berita terkini dari Kelurahan Marga Sari</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($news->count() > 0)
            <div class="row g-4">
                @foreach($news as $article)
                <div class="col-6 col-md-6 col-lg-4">
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


/* Page Header Spacing untuk menghindari navbar */
.page-header-news {
    padding-top: 90px !important; /* Reasonable space from fixed navbar */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header-news {
        padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
    }
    
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .page-header-news {
        padding-top: 70px !important; /* Minimal padding on small mobile */
    }
    
    .page-header-news h1 {
        font-size: 1.8rem !important;
        line-height: 1.3;
    }
    
    .page-header-news .lead {
        font-size: 1rem !important;
    }
}

/* ==== NEWS HERO SECTION SLIDESHOW ==== */
.news-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
}

.news-hero-section .hero-bg, 
.news-hero-section .hero-bg-next {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    transition: opacity 0.8s ease-in-out;
    z-index: 0;
}

.news-hero-section .hero-bg {
    opacity: 1;
}

.news-hero-section .hero-bg-next {
    opacity: 0;
}

.news-hero-section::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.news-hero-section .container {
    position: relative;
    z-index: 2;
}

@media (max-width: 768px) {
    .news-hero-section::after {
        background: rgba(0, 0, 0, 0.75);
    }
    
    /* News cards in 2-column layout for mobile */
    .col-6 article.card {
        font-size: 0.85rem;
    }
    
    .col-6 .card-img-top {
        height: 110px !important;
    }
    
    .col-6 .card-body {
        padding: 0.6rem 0.4rem !important;
    }
    
    .col-6 .card-title {
        font-size: 0.8rem !important;
        margin-bottom: 0.4rem !important;
        line-height: 1.2;
    }
    
    .col-6 .card-text {
        font-size: 0.7rem !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }
    
    .col-6 .card-body small {
        font-size: 0.65rem !important;
    }
    
    .col-6 .badge {
        font-size: 0.65rem !important;
        padding: 0.25rem 0.4rem;
    }
    
    /* Adjust gap between news cards */
    .row.g-4 {
        --bs-gutter-x: 0.5rem;
        --bs-gutter-y: 0.75rem;
    }
}

@media (max-width: 576px) {
    /* Further optimization for very small screens */
    .col-6 .card-img-top {
        height: 100px !important;
    }
    
    .col-6 .card-body {
        padding: 0.5rem 0.3rem !important;
    }
    
    .col-6 .card-title {
        font-size: 0.75rem !important;
    }
    
    .col-6 .card-text {
        font-size: 0.65rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
window.addEventListener("load", function () {
    const hero = document.getElementById("news-hero");
    if (!hero) return;
    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        hero.style.backgroundImage = "url('{{ asset('images/Kantor_Kelurahan_Margasari.png') }}')";
        hero.style.backgroundPosition = "15% center";
        hero.style.backgroundSize = "cover";
        return;
    }
    hero.insertAdjacentHTML("beforeend", `<div class="hero-bg hero-bg-1"></div><div class="hero-bg hero-bg-2"></div>`);
    const bg1 = hero.querySelector(".hero-bg-1");
    const bg2 = hero.querySelector(".hero-bg-2");
    const slides = [
        { image: "{{ asset('images/Kantor_Kelurahan_Margasari.png') }}", position: "center 33%" },
        { image: "{{ asset('images/Opening_Insos.jpg') }}", position: "center 15%" },
        { image: "{{ asset('images/poto.kebun_sayur.jpg') }}", position: "center 20%" }
    ];
    let current = 0, showingBg1 = true;
    [bg1, bg2].forEach(bg => Object.assign(bg.style, {position: "absolute", inset: "0", backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "center", opacity: "0", transition: "opacity 0.8s ease-in-out", zIndex: 0}));
    bg1.style.backgroundImage = `url('${slides[0].image}')`;
    bg1.style.backgroundPosition = slides[0].position;
    bg1.style.opacity = "1";
    function changeSlide() {
        const nextIndex = (current + 1) % slides.length;
        const nextSlide = slides[nextIndex];
        if (showingBg1) {
            bg2.style.backgroundImage = `url('${nextSlide.image}')`;
            bg2.style.backgroundPosition = nextSlide.position;
            bg2.style.opacity = "1";
            bg1.style.opacity = "0";
        } else {
            bg1.style.backgroundImage = `url('${nextSlide.image}')`;
            bg1.style.backgroundPosition = nextSlide.position;
            bg1.style.opacity = "1";
            bg2.style.opacity = "0";
        }
        showingBg1 = !showingBg1;
        current = nextIndex;
    }
    setInterval(changeSlide, 6000);
});
</script>
@endpush
