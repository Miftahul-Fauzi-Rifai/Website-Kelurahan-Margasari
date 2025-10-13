@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Marga Sari')
@section('meta_description', 'Website resmi Kelurahan Marga Sari, Kota Balikpapan. Informasi layanan, berita, dan pengumuman terbaru.')

@section('content')
<!-- Hero Section -->
<section class="hero-section hero-with-bg text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Selamat Datang di<br>
                    <span class="text-warning">Kelurahan Marga Sari</span>
                </h1>
                <p class="lead mb-4">
                    Melayani masyarakat dengan sepenuh hati untuk menciptakan lingkungan yang aman, nyaman, dan sejahtera bagi seluruh warga Marga Sari.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('services') }}" class="btn btn-warning btn-lg px-4">
                        <i class="bi bi-card-list me-2"></i>Layanan Kami
                    </a>
                    <a href="{{ route('complaint.create') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-chat-dots me-2"></i>Sampaikan Aspirasi
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
                <img src="{{ asset('images/hero-illustration.svg') }}" alt="" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Quick Services -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Layanan Unggulan</h2>
            <p class="text-muted">Layanan terpopuler dari Kelurahan Marga Sari</p>
        </div>
        
        <div class="row g-4">
            @forelse($services->take(4) as $service)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="bi {{ $service->icon ?? 'bi-gear' }}" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($service->description, 80) }}</p>
                        @if($service->fee > 0)
                            <span class="badge bg-success">Rp {{ number_format($service->fee, 0, ',', '.') }}</span>
                        @else
                            <span class="badge bg-primary">Gratis</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada layanan yang tersedia.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-primary">
                Lihat Semua Layanan <i class="bi bi-arrow-right ms-2"></i>
            </a>
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
                    <a href="{{ route('news') }}" class="btn btn-outline-primary">Lihat Semua</a>
                </div>
                
                <div class="row g-4">
                    @forelse($latestNews->take(4) as $news)
                    <div class="col-md-6">
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
                    
                    <!-- Contact Info -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-telephone me-2"></i>Kontak Darurat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-primary">Kantor Kelurahan</h6>
                                <p class="mb-1"><i class="bi bi-telephone me-2"></i>(0542) 123-456</p>
                                <p class="mb-0"><i class="bi bi-envelope me-2"></i>admin@margasari.id</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-primary">Keamanan</h6>
                                <p class="mb-1"><i class="bi bi-telephone me-2"></i>(0542) 789-012</p>
                                <p class="mb-0"><i class="bi bi-whatsapp me-2"></i>0812-3456-7890</p>
                            </div>
                            <div>
                                <h6 class="text-primary">Jam Pelayanan</h6>
                                <p class="mb-0">
                                    <i class="bi bi-clock me-2"></i>
                                    Senin - Jumat: 08:00 - 16:00
                                </p>
                            </div>
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
.hero-section {
    min-height: 70vh;
}

.hero-with-bg {
    background: url('{{ asset('storage/dokumentasikel/Kantor_Kelurahan_Margasari,_Balikpapan.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.hero-with-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.hero-with-bg .container {
    position: relative;
    z-index: 2;
}

.min-vh-50 {
    min-height: 50vh;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
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
</style>
@endpush
