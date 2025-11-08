@extends('layouts.app')

@section('title', $tentang->judul ?? 'Profil - Kelurahan Marga Sari')
@section('meta_description', 'Halaman profil lengkap Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section id="about-hero" class="about-hero-section text-white py-4 py-md-5 page-header-about">
    <div class="container position-relative">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">
            {{ $tentang->judul ?? 'Tentang Kelurahan Marga Sari' }}
        </h1>
        <p class="lead mb-0 mobile-subtitle">Halaman informasi Kelurahan Marga Sari</p>
    </div>
</section>

<div class="container my-5">
    <!-- Logo -->
    <div class="text-center mb-4">
        <div class="card logo-card shadow-sm">
            <div class="card-body">
                <img src="{{ asset($tentang->logo ?? 'images/logo-balikpapan.png') }}" 
                     alt="Logo Kelurahan" 
                     class="img-fluid mb-2" width="130">
                <h5 class="fw-bold text-primary mb-0">Kelurahan Marga Sari</h5>
                <p class="text-muted mb-0">Kecamatan Balikpapan Barat, Kota Balikpapan</p>
            </div>
        </div>
    </div>

    <!-- Tentang -->
    <div id="profil-umum" class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-info-square"></i> Tentang Kelurahan
        </div>
        <div class="card-body">
            <div class="row align-items-center g-4">
                <div class="col-md-4 text-center">
                    <div class="image-frame mx-auto">
                        <img src="{{ asset($tentang->gambar_kantor ?? 'images/Kantor_Kelurahan_Margasari.png') }}"
                            alt="Kantor Kelurahan"
                            class="img-fluid kantor-img">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tentang-desc">
                        {!! nl2br(e($tentang->deskripsi ?? 'Belum ada deskripsi yang diinput.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Struktur Organisasi -->
    <div id="struktur" class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-diagram-3"></i> Struktur Organisasi
        </div>
        <div class="card-body text-center">
            @if($struktur->isEmpty())
                <p class="text-center text-muted mb-0">Belum ada data struktur organisasi.</p>
            @else
                @php
                    $strukturSorted = $struktur->sortBy('urutan');
                    $lurah = $strukturSorted->where('urutan', 1);
                    $sekretaris = $strukturSorted->where('urutan', 2);
                    $bidang = $strukturSorted->where('urutan', '>', 2);
                @endphp

                <div class="org-chart mt-4">
                    {{-- LURAH --}}
                    @foreach($lurah as $item)
                        <div class="org-box mx-auto">
                            <div class="org-title">{{ $item->jabatan }}</div>
                            <div class="org-body">{{ $item->nama }}</div>
                        </div>
                    @endforeach

                    {{-- SEKRETARIS --}}
                    @foreach($sekretaris as $item)
                        <div class="org-box mx-auto mt-4">
                            <div class="org-title">{{ $item->jabatan }}</div>
                            <div class="org-body">{{ $item->nama }}</div>
                        </div>
                    @endforeach

                    {{-- BIDANG --}}
                    @if($bidang->count() > 0)
                        <div class="org-level d-flex justify-content-center flex-wrap gap-3 mt-4">
                            @foreach($bidang as $item)
                                <div class="org-box">
                                    <div class="org-title">{{ $item->jabatan }}</div>
                                    <div class="org-body">{{ $item->nama }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Sosial Media -->
    <div id="sosial-media" class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-share"></i> Sosial Media Kelurahan
        </div>
        <div class="card-body text-center py-4">
            <p class="text-muted mb-4">Ikuti kami di platform berikut:</p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                @foreach ($sosmed as $sm)
                    @php
                        $platform = strtolower($sm->platform);
                        $icon = 'bi-' . $platform;
                        if ($platform === 'facebook') $icon = 'bi-facebook';
                        elseif ($platform === 'instagram') $icon = 'bi-instagram';
                        elseif ($platform === 'youtube') $icon = 'bi-youtube';
                        elseif ($platform === 'twitter' || $platform === 'x') $icon = 'bi-twitter';
                        elseif ($platform === 'tiktok') $icon = 'bi-tiktok';
                        elseif ($platform === 'whatsapp') $icon = 'bi-whatsapp';
                    @endphp

                    <a href="{{ $sm->url }}" target="_blank" 
                       class="social-icon {{ $platform }}">
                        <i class="bi {{ $icon }}"></i> {{ ucfirst($platform) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Lokasi Kelurahan -->
        <div id="lokasi" class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-geo-alt"></i> Lokasi
        </div>
        <div class="card-body">
            <div class="map-responsive">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8909566288994!2d116.82023087473615!3d-1.2353628355721011!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df147c05c5f97d3%3A0x3038846c508a9623!2sKantor%20Kelurahan%20Margasari!5e0!3m2!1sid!2sid!4v1762177685906!5m2!1sid!2sid"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ======== HEADER TENTANG (RAPIH DARI NAVBAR) ======== */
section.bg-primary.text-white.py-5 {
    padding-top: 90px !important; /* beri ruang antara navbar dan header */
    padding-bottom: 40px !important;
    background: linear-gradient(180deg, #0d6efd, #0a58ca); /* gradasi lembut */
}

section.bg-primary.text-white h1 {
    margin-bottom: 10px;
    letter-spacing: 0.5px;
}

section.bg-primary.text-white p.lead {
    font-size: 1.05rem;
    color: #e6e6e6;
}

/* Perbaikan agar tidak terlalu rapat di layar kecil */
@media (max-width: 768px) {
    section.bg-primary.text-white.py-5 {
        padding-top: 70px !important;
        padding-bottom: 50px !important;
    }
    section.bg-primary.text-white h1 {
        font-size: 1.6rem;
    }
}


//* --- Tentang Kelurahan Section --- */
.image-frame {
    background-color: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    padding: 8px;
    display: inline-block;
}

.kantor-img {
    width: 300px;              /* ukuran fix kecil */
    height: auto;
    border-radius: 6px;
    border: 1px solid #e0e0e0;
    padding: 4px;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.kantor-img:hover {
    transform: scale(1.05);
}

.tentang-desc {
    text-align: justify;
    font-size: 0.95rem;
    line-height: 1.8;
    color: #333;
    padding-right: 10px;
}

/* Responsif untuk HP */
@media (max-width: 768px) {
    .kantor-img {
        max-width: 100px;
        margin-bottom: 10px;
    }
    .tentang-desc {
        font-size: 0.9rem;
        text-align: justify;
    }
}



/* Map Responsif */
.map-responsive {
    position: relative;
    overflow: hidden;
    padding-bottom: 60%; /* tinggi default untuk HP (rasio 16:9 agak tinggi) */
    height: 0;
    border-radius: 10px;
}

/* iframe map full width */
.map-responsive iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/* Card logo tengah */
.card.logo-card {
    border: 1px solid #dee2e6; /* tipis, abu lembut */
    background-color: #fff;
    display: inline-block;
    padding: 10px 15px; /* dikurangi supaya tidak lebar */
    border-radius: 10px;
}

<>
/* ======== STRUKTUR ORGANISASI - CLEAN UNIFORM LOOK ======== */
.org-chart {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
}
.org-level {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
}
.org-box {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    width: 220px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.org-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}
.org-title {
    background: #f2f6ff; /* warna lembut seragam */
    color: #0d47a1;
    font-weight: 600;
    font-size: 0.9rem;
    border-bottom: 1px solid #e0e6f0;
    border-radius: 10px 10px 0 0;
    padding: 6px 0;
}
.org-body {
    padding: 8px 0;
    font-size: 0.9rem;
    color: #333;
}

/* Responsif */
@media (max-width: 768px) {
    .org-box { width: 180px; }
}

/* Atur tinggi map di layar lebih besar */
@media (min-width: 768px) {
    .map-responsive {
        padding-bottom: 45%; /* Tablet */
    }
}

@media (min-width: 992px) {
    .map-responsive {
        padding-bottom: 35%; /* Desktop sedang */
    }
}

@media (min-width: 1200px) {
    .map-responsive {
        padding-bottom: 30%; /* Desktop besar — lebih ramping */
    }
}

/* ======== SOSIAL MEDIA DYNAMIC COLOR ======== */
#sosial-media {
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    overflow: hidden;
}

#sosial-media .card-header {
    background: linear-gradient(90deg, #0d6efd, #0072ff);
    font-weight: 600;
    border: none;
    padding: 12px 20px;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border-radius: 30px;
    padding: 10px 22px;
    font-weight: 600;
    text-decoration: none;
    color: white !important;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

/* Default gray fallback */
.social-icon {
    background-color: #6c757d;
}

/* Specific platform colors */
.social-icon.facebook { background-color: #1877F2; }
.social-icon.instagram {
    background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af, #515bd4);
}
.social-icon.youtube { background-color: #FF0000; }
.social-icon.twitter, .social-icon.x { background-color: #1DA1F2; }
.social-icon.tiktok {
    background: linear-gradient(135deg, #000000 60%, #25F4EE 90%);
}
.social-icon.whatsapp { background-color: #25D366; }

/* Hover brightness effect */
.social-icon:hover {
    filter: brightness(1.1);
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Responsif */
@media (max-width: 768px) {
    .social-icon {
        width: 100%;
        justify-content: center;
    }
}

/* Mobile Header Optimizations */
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
.page-header-about {
    padding-top: 90px !important; /* Reasonable space from fixed navbar */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header-about {
        padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
    }
}

@media (max-width: 576px) {
    .page-header-about {
        padding-top: 70px !important; /* Minimal padding on small mobile */
    }
}

/* ==== ABOUT HERO SECTION - BACKGROUND BIRU ==== */
.about-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.about-hero-section .container {
    position: relative;
    z-index: 2;
}

</style>
@endpush

@push('scripts')
@endpush
