@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Marga Sari')
@section('meta_description', 'Website resmi Kelurahan Marga Sari, Kota Balikpapan. Informasi layanan, berita, dan pengumuman terbaru.')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero-section text-white py-5">
    <div class="hero-overlay"></div>
    <div class="container position-relative py-5">
        <div class="hero-content text-center">
            <h1 class="fw-bold display-3">
                Selamat Datang di <span class="text-warning">Kelurahan Marga Sari</span>
            </h1>
            <p class="lead my-3">
                Melayani masyarakat dengan sepenuh hati untuk menciptakan lingkungan
                yang aman, nyaman, dan sejahtera bagi seluruh warga Marga Sari.
            </p>
        </div>
    </div>
</section>

<!-- Quick Services -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Layanan Online</h2>
            <p class="text-muted">Akses layanan administrasi kelurahan secara online melalui Google Form</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            @php
            $onlineServices = [
                [
                    'name' => 'Surat Keterangan Belum Pernah Menikah',
                    'description' => 'Layanan online untuk pembuatan surat keterangan belum pernah menikah',
                    'icon' => 'bi-heart',
                    'color' => 'success'
                ],
                [
                    'name' => 'Surat Keterangan Berpenghasilan Tidak Tetap',
                    'description' => 'Layanan online untuk pembuatan surat keterangan penghasilan tidak tetap',
                    'icon' => 'bi-currency-exchange',
                    'color' => 'info'
                ],
                [
                    'name' => 'Surat Keterangan Bertempat Tinggal',
                    'description' => 'Layanan online untuk warga ber KTP luar daerah',
                    'icon' => 'bi-house-door',
                    'color' => 'warning'
                ],
                [
                    'name' => 'Surat Keterangan Domisili',
                    'description' => 'Layanan online untuk warga ber KTP setempat',
                    'icon' => 'bi-geo-alt',
                    'color' => 'secondary'
                ],
                [
                    'name' => 'Surat Keterangan Janda/Duda',
                    'description' => 'Layanan online untuk pembuatan surat keterangan status janda/duda',
                    'icon' => 'bi-person-x',
                    'color' => 'danger'
                ]
            ];
            @endphp

            @foreach($onlineServices as $service)
            <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-3">
                <div class="card service-online-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4 d-flex flex-column">
                        <!-- Service Icon -->
                        <div class="service-online-icon mb-3">
                            <div class="icon-wrapper bg-{{ $service['color'] }}">
                                <i class="bi {{ $service['icon'] }}"></i>
                            </div>
                        </div>
                        
                        <!-- Service Title -->
                        <h5 class="service-online-title fw-bold mb-3">{{ $service['name'] }}</h5>
                        
                        <!-- Service Description -->
                        <p class="service-online-description text-muted mb-4">{{ $service['description'] }}</p>
                        
                        <!-- Access Button -->
                        <div class="service-online-action mt-auto">
                            <a href="{{ route('services') }}" class="btn btn-{{ $service['color'] }} w-100 fw-semibold py-2">
                                <i class="bi bi-arrow-right me-2"></i>Selanjutnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest News -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Berita Terbaru</h2>
                    <a href="{{ route('news') }}" class="btn btn-outline-warning">Lihat Semua</a>
                </div>
                
                <div class="row g-4">
                    @forelse($latestNews->take(4) as $news)
                    <div class="col-6 col-md-6">
                        <article class="card border-0 shadow-sm h-100">
                            @if($news->featured_image)
                                <img src="{{ asset('storage/' . $news->featured_image) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $news->published_at->format('d M Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>{{ $news->views }}
                                    </small>
                                </div>
                                <h5 class="card-title">
                                    <a href="{{ route('post.show', $news->slug) }}" class="text-decoration-none text-dark">
                                        {{ $news->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted">{{ Str::limit($news->excerpt, 100) }}</p>
                            </div>
                        </article>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 2rem;">
                    <!-- Announcements -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="bi bi-megaphone me-2"></i>Pengumuman
                            </h5>
                        </div>
                        <div class="card-body">
                            @forelse($announcements as $announcement)
                            <div class="mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                <h6 class="mb-2">
                                    <a href="{{ route('post.show', $announcement->slug) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($announcement->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $announcement->published_at->format('d M Y') }}
                                </small>
                            </div>
                            @empty
                            <p class="text-muted mb-0">Belum ada pengumuman.</p>
                            @endforelse
                            
                            @if($announcements->count() > 0)
                            <a href="{{ route('announcements') }}" class="btn btn-sm btn-outline-warning w-100 mt-2">
                                Lihat Semua Pengumuman
                            </a>
                            @endif
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

/* ==== HERO SECTION SLIDESHOW ==== */
.hero-section {
    position: relative;
    min-height: 85vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

/* Dua layer background untuk animasi slide */
.hero-bg, .hero-bg-next {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    transition: transform 1.5s ease-in-out;
    z-index: 0;
}

/* Layer berikutnya muncul dari kanan */
.hero-bg-next {
    transform: translateX(100%);
}

/* Saat slide berganti */
.hero-section.slide .hero-bg {
    transform: translateX(-100%);
}
.hero-section.slide .hero-bg-next {
    transform: translateX(0);
}

/* Overlay gelap agar teks tetap terbaca */
.hero-section::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1;
}

/* Isi hero di atas semua layer */
.hero-section .container {
    position: relative;
    z-index: 2;
}

.hero-content {
    position: relative;
    z-index: 3;
    max-width: 800px;
    margin: 0 auto;
}

/* Responsif: teks & tombol */
@media (max-width: 992px) {
    .hero-content {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 60vh;
        background-position: center;
    }

    .hero-content h1 {
        font-size: 2.5rem;
        text-align: center;
    }

    .hero-content p {
        font-size: 1rem;
        text-align: center;
    }

    .hero-content .d-flex {
        flex-direction: column;
        align-items: center;
    }

    .hero-content .btn {
        width: auto;
    }
}

/* Prevent horizontal overflow on mobile */
body {
    overflow-x: hidden;
}

/* Prevent zoom and touch effects on mobile */
@media (max-width: 767px) {
    /* Disable tap highlight */
    * {
        -webkit-tap-highlight-color: transparent;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    
    /* Allow text selection for content areas */
    .display-4,
    .lead,
    p,
    .card-text,
    .service-online-description {
        -webkit-user-select: text;
        -khtml-user-select: text;
        -moz-user-select: text;
        -ms-user-select: text;
        user-select: text;
    }
    
    /* Disable zoom on input focus */
    input,
    textarea,
    select {
        font-size: 16px !important;
    }
}

.hero-section {
    min-height: 60vh;
    padding-top: 80px; /* Space for fixed header */
}

/* Mobile container fixes */
@media (max-width: 991px) {
    .hero-section {
        padding-top: 20px; /* Minimal padding, navbar is transparent */
        min-height: 60vh; /* Normal height, not full screen */
    }
}

@media (max-width: 767px) {
    .container {
        max-width: 100%;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .hero-section {
        padding-top: 20px; /* Minimal padding, navbar is transparent */
        min-height: 60vh; /* Normal height */
    }
    
    .display-4 {
        font-size: 1.8rem !important;
        line-height: 1.3;
    }
    
    .lead {
        font-size: 1rem !important;
        margin-bottom: 1.5rem;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 0.75rem !important;
    }
    
    .d-flex.gap-3 .btn {
        width: 100%;
    }
}

@media (max-width: 575px) {
    .container {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    .hero-section {
        padding-top: 15px; /* Minimal padding for small screens */
        min-height: 60vh; /* Keep normal height */
    }
    
    .display-4 {
        font-size: 1.5rem !important;
        line-height: 1.2;
    }
    
    .lead {
        font-size: 0.9rem !important;
    }
    
    .btn-lg {
        font-size: 0.9rem !important;
        padding: 0.6rem 1.25rem !important;
    }
}

/* Disable hover effects on touch devices and mobile screens */
@media (hover: none) and (pointer: coarse), (max-width: 768px) {
    /* Completely disable all hover effects on mobile */
    .card:hover,
    .service-online-card:hover {
        transform: none !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    }
    
    .service-online-card:hover .icon-wrapper {
        transform: none !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
    }
    
    .service-online-action .btn:hover {
        transform: none !important;
        box-shadow: none !important;
    }
    
    .service-online-card:hover::before {
        opacity: 0 !important;
    }
    
    /* Remove all transitions on mobile to prevent tap zoom effects */
    .card,
    .service-online-card,
    .service-online-card .icon-wrapper,
    .service-online-action .btn,
    .service-online-card::before {
        transition: none !important;
    }
    
    /* Ensure no transform animations trigger on tap */
    .service-online-card {
        -webkit-tap-highlight-color: rgba(0,0,0,0.1);
    }
}

.sticky-top {
    z-index: 1020;
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 60vh;
    }
    
    .display-4 {
        font-size: 2rem;
    }
}

/* Service Online Cards Styling */
.service-online-card {
    border-radius: 15px;
    transition: all 0.3s ease;
    background: white;
    overflow: hidden;
    position: relative;
}

.service-online-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}

/* Service Online Icon */
.service-online-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
}

.service-online-icon .icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.service-online-card:hover .icon-wrapper {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

/* Service Online Content */
.service-online-title {
    color: #2c3e50;
    font-size: 1.1rem;
    line-height: 1.4;
    margin-bottom: 1rem;
}

.service-online-description {
    font-size: 0.9rem;
    line-height: 1.5;
    color: #6c757d;
    margin-bottom: 2rem;
    flex-grow: 1;
}

/* Service Online Action Button */
.service-online-action .btn {
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}

.service-online-action .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Service Online Action - Positioning */
.service-online-action {
    margin-top: auto;
}

/* Responsive Design for Service Online Cards */
@media (max-width: 1200px) {
    .service-online-icon .icon-wrapper {
        width: 60px;
        height: 60px;
        font-size: 1.6rem;
    }
    
    .service-online-title {
        font-size: 1rem;
    }
}

/* Mobile responsive layout for service cards - hover effects already disabled above */
@media (max-width: 768px) {
    .service-online-card {
        margin-bottom: 1rem;
        /* Ensure stable appearance without hover effects */
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    }
    
    .service-online-card .card-body {
        padding: 1.5rem 0.75rem !important;
    }
    
    .service-online-icon {
        margin-bottom: 0.75rem !important;
    }
    
    .service-online-icon .icon-wrapper {
        width: 45px;
        height: 45px;
        font-size: 1.2rem;
        /* Stable shadow without hover scaling */
        box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
    }
    
    .service-online-title {
        font-size: 0.85rem !important;
        line-height: 1.2;
        margin-bottom: 0.5rem !important;
    }
    
    .service-online-description {
        font-size: 0.75rem !important;
        line-height: 1.3;
        margin-bottom: 1rem !important;
    }
    
    .service-online-action .btn {
        padding: 6px 12px !important;
        font-size: 0.75rem !important;
    }
}

/* Extra small mobile screens - even more compact, no hover effects */
@media (max-width: 576px) {
    /* Service cards very compact for small screens */
    .service-online-card {
        /* Consistent stable appearance */
        box-shadow: 0 1px 6px rgba(0,0,0,0.1) !important;
    }
    
    .service-online-card .card-body {
        padding: 1rem 0.5rem !important;
    }
    
    .service-online-icon {
        margin-bottom: 0.5rem !important;
    }
    
    .service-online-icon .icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        /* Smaller stable shadow for compact layout */
        box-shadow: 0 1px 6px rgba(0,0,0,0.12) !important;
    }
    
    .service-online-title {
        font-size: 0.8rem !important;
        line-height: 1.1;
        margin-bottom: 0.4rem !important;
    }
    
    .service-online-description {
        font-size: 0.7rem !important;
        line-height: 1.2;
        margin-bottom: 0.8rem !important;
    }
    
    .service-online-action .btn {
        padding: 5px 8px !important;
        font-size: 0.7rem !important;
    }
    
    /* Compact section spacing for mobile */
    .py-5 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }
    
    .py-5 h2 {
        font-size: 1.3rem !important;
        margin-bottom: 0.8rem !important;
    }
    
    .py-5 .text-muted {
        font-size: 0.8rem !important;
        margin-bottom: 2rem !important;
    }
    
    /* Reduce gap between service cards */
    .row.g-4 {
        --bs-gutter-x: 0.5rem;
        --bs-gutter-y: 0.5rem;
    }
    
    /* News and announcements cards - keep existing styles but smaller */
    .card {
        margin-bottom: 1rem !important;
    }
    
    .card-body {
        padding: 0.75rem 0.5rem !important;
    }
    
    .card-title {
        font-size: 0.85rem !important;
        line-height: 1.2;
        margin-bottom: 0.5rem !important;
    }
    
    .card-text {
        font-size: 0.75rem !important;
        line-height: 1.3;
        margin-bottom: 0 !important;
    }
    
    /* Optimize news card image for mobile 2-column layout */
    .card-img-top {
        height: 120px !important;
        object-fit: cover;
    }
    
    /* Make date and views info smaller on mobile */
    .card-body .text-muted small {
        font-size: 0.7rem !important;
    }
}

/* Grid Layout Improvements */
.row.g-4.justify-content-center {
    margin: 0 -1rem;
}

.row.g-4.justify-content-center > * {
    padding: 0 1rem;
}

/* Mobile grid layout improvements */
@media (max-width: 576px) {
    .row.g-4.justify-content-center {
        margin: 0 -0.25rem;
    }
    
    .row.g-4.justify-content-center > * {
        padding: 0 0.25rem;
    }
}

/* Additional hover effects */
.service-online-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, 
        var(--bs-primary) 0%, 
        var(--bs-success) 25%, 
        var(--bs-info) 50%, 
        var(--bs-warning) 75%, 
        var(--bs-secondary) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.service-online-card:hover::before {
    opacity: 1;
}

/* Mobile News Section Optimization - 2 Column Layout */
@media (max-width: 768px) {
    /* News section title */
    section .fw-bold {
        font-size: 1.3rem;
    }
    
    /* News cards in 2-column layout */
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
    }
    
    .col-6 .card-text {
        font-size: 0.7rem !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .col-6 .card-body small {
        font-size: 0.65rem !important;
    }
    
    /* Adjust gap between news cards */
    .row.g-4 {
        --bs-gutter-x: 0.5rem;
        --bs-gutter-y: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
window.addEventListener("load", function () {
    const hero = document.getElementById("hero");
    if (!hero) return;

    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        hero.style.backgroundImage = "url('{{ asset('images/Kantor_Kelurahan_Margasari.png') }}')";
        hero.style.backgroundPosition = "15% center";
        hero.style.backgroundSize = "cover";
        return;
    }

    // Tambahkan dua layer background untuk efek fade
    hero.insertAdjacentHTML("beforeend", `
        <div class="hero-bg hero-bg-1"></div>
        <div class="hero-bg hero-bg-2"></div>
    `);

    const bg1 = hero.querySelector(".hero-bg-1");
    const bg2 = hero.querySelector(".hero-bg-2");

    const slides = [
        { image: "{{ asset('images/Kantor_Kelurahan_Margasari.png') }}", position: "center 33%" },
        { image: "{{ asset('images/Opening_Insos.jpg') }}", position: "center 15%" },
        { image: "{{ asset('images/poto.kebun_sayur.jpg') }}", position: "center 20%" }
    ];

    let current = 0;
    let showingBg1 = true;

    // Set style awal
    [bg1, bg2].forEach(bg => {
        Object.assign(bg.style, {
            position: "absolute",
            inset: "0",
            backgroundSize: "cover",
            backgroundRepeat: "no-repeat",
            backgroundPosition: "center",
            opacity: "0",
            transition: "opacity 0.8s ease-in-out",
            zIndex: 0
        });
    });

    // Gambar pertama langsung tampil
    bg1.style.backgroundImage = `url('${slides[0].image}')`;
    bg1.style.backgroundPosition = slides[0].position;
    bg1.style.opacity = "1";

    function changeSlide() {
        const nextIndex = (current + 1) % slides.length;
        const nextSlide = slides[nextIndex];

        if (showingBg1) {
            bg2.style.backgroundImage = `url('${nextSlide.image}')`;
            bg2.style.backgroundPosition = nextSlide.position;
            bg2.style.opacity = "1"; // Fade-in layer baru
            bg1.style.opacity = "0"; // Fade-out layer lama
        } else {
            bg1.style.backgroundImage = `url('${nextSlide.image}')`;
            bg1.style.backgroundPosition = nextSlide.position;
            bg1.style.opacity = "1";
            bg2.style.opacity = "0";
        }

        showingBg1 = !showingBg1;
        current = nextIndex;
    }

    // Jalankan pertama kali dan setiap 6 detik
    setInterval(changeSlide, 6000);
});
</script>
@endpush
