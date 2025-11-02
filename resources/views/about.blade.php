@extends('layouts.app')

@section('title', 'Profil - Kelurahan Marga Sari')
@section('meta_description', 'Halaman profil lengkap Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
    <!-- Page Header -->
    <section class="bg-primary text-white py-4 py-md-5 page-header-about">
        <div class="container text-center">
            <h1 class="display-5 display-md-4 fw-bold mobile-title">Tentang Kelurahan Marga Sari</h1>
            <p class="lead mb-0 mobile-subtitle">Halaman informasi Kelurahan Marga Sari</p>
        </div>
    </section>

    <!-- Konten Profil -->
    <div class="container my-5">

        <!-- Logo Kelurahan (dipindah dari sidebar) -->
        <div class="text-center mb-4">
            <div class="card d-inline-block shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <img src="{{ asset('images/logo-balikpapan.png') }}" alt="Logo Balikpapan"
                        class="img-fluid mb-2" width="130">
                    <h5 class="fw-bold text-primary mb-0">Kelurahan Marga Sari</h5>
                    <p class="text-muted mb-0">Kecamatan Balikpapan Barat, Kota Balikpapan</p>
                </div>
            </div>
        </div>

        <!-- Tentang Kelurahan -->
        <div id="profil-umum" class="card mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-info-square"></i> Tentang Kelurahan Marga Sari
            </div>
            <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <img src="{{ asset('images/Kantor_Kelurahan_Margasari.png') }}"
                    alt="Kantor Kelurahan Margasari"
                    class="img-fluid rounded shadow-sm img-profil">
            </div>
            <div class="col-md-8">
                <p class="mb-0 text-justify">
                    Kelurahan Marga Sari merupakan salah satu kelurahan di Kecamatan Balikpapan Barat, Kota Balikpapan, Kalimantan Timur.
                    Berlokasi di kawasan pesisir dengan tepi laut yang langsung menghadap Teluk Balikpapan, Marga Sari mempunyai karakter
                    khusus, yaitu rumah apung tepi laut serta keberadaan kawasan wisata mangrove.
                    Salah satu ikon wilayah ini ialah Kampung Atas Air, sebuah kawasan yang menampilkan rumah apung di atas
                    laut, yang juga dirancang sebagai area ekowisata.
                    Ekonomi masyarakat Marga Sari memanfaatkan potensi pesisir: aktivitas seperti perikanan kecil, perdagangan oleh-oleh
                    dan wisata pesisir menjadi bagian dari kehidupan lokal. Kelurahan bersama masyarakat juga menggencarkan 
                    pemberdayaan masyarakat, pengembangan wisata berbasis budaya dan pesisir, serta pelestarian lingkungan mangrove dan 
                    sanitasi kawasan pesisir.
                    Untuk ke depan, kawasan ini diarahkan menjadi wisata ekowisata yang berkelanjutan, dengan perhatian khusus terhadap
                    kebersihan lingkungan, pengelolaan mangrove, dan sarana prasarana wisata.
                </p>
            </div>
        </div>
    </div>

        <!-- Struktur Organisasi -->
        <div id="struktur" class="card mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-diagram-3"></i> Struktur Organisasi
            </div>
            <div class="card-body text-center">
                <div class="d-flex flex-column align-items-center mb-4">
                    <div class="org-box">
                        <div class="org-title bg-primary text-white">Lurah</div>
                        <div class="org-body">Hendra Jaya Prawira, S.ST</div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                    <div class="org-box">
                        <div class="org-title bg-primary text-white">Sekretaris</div>
                        <div class="org-body">Hasmawati Saud, S.Sos</div>
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <div class="org-box">
                        <div class="org-title bg-primary text-white">Kasi Pemerintahan</div>
                        <div class="org-body">Imelda Lumban Toruan, S.T</div>
                    </div>
                    <div class="org-box">
                        <div class="org-title bg-primary text-white">Kasi Trantib-LH</div>
                        <div class="org-body">Juliansyah, S.H</div>
                    </div>
                    <div class="org-box">
                        <div class="org-title bg-primary text-white">Kasi Permas</div>
                        <div class="org-body">Andi Agus Jaya Indra, S.E</div>
                    </div>
                </div>
            </div>
        </div>

<<<<<<< HEAD
=======
        <!-- Sosial Media -->
        <div id="sosial-media" class="card mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-share"></i> Sosial Media Kelurahan Marga Sari
            </div>
            <div class="card-body text-center py-4">
                <p class="text-muted mb-4">
                    Ikuti kami untuk mendapatkan informasi, berita, dan kegiatan terbaru Kelurahan Marga Sari
                </p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="https://www.instagram.com/kel.margasari.bpn/" target="_blank" class="social-icon instagram">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                    <a href="https://www.facebook.com/kel.margasari.bpn" target="_blank" class="social-icon facebook">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <a href="https://www.youtube.com/@margasaribarat2791" target="_blank" class="social-icon youtube">
                        <i class="bi bi-youtube"></i> YouTube
                    </a>
                </div>
            </div>
        </div>


>>>>>>> 3ba0a540739b5fab64717471f6bcc28bbd776ccd
        <!-- Lokasi -->
    <div id="lokasi" class="card">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-geo-alt"></i> Lokasi
    </div>
    <div class="card-body">
        <div class="map-responsive">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.890948577125!2d116.8202308747244!3d-1.2353681987528535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df147c05c5f97d3%3A0x3038846c508a9623!2sKantor%20Kelurahan%20Margasari!5e0!3m2!1sid!2sid!4v1753907925814!5m2!1sid!2sid"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Header Responsif */
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

/* Jarak aman dari navbar */
.page-header-about {
    padding-top: 90px !important;
}

@media (max-width: 768px) {
    .page-header-about {
        padding-top: 80px !important;
    }
}

@media (max-width: 576px) {
    .page-header-about {
        padding-top: 70px !important;
<<<<<<< HEAD
    }
}

.text-justify {
    text-align: justify;
}

/* Responsif gambar di bagian Tentang Kelurahan */
.img-profil {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    object-fit: cover;
}

/* Atur ukuran dan posisi gambar di layar kecil */
@media (max-width: 768px) {
    .img-profil {
        width: 80%;
        margin: 0 auto;
        display: block;
    }
}

/* Tambahkan jarak vertikal di HP agar teks tidak terlalu rapat */
@media (max-width: 576px) {
    #profil-umum .col-md-8 p {
        font-size: 0.95rem;
        line-height: 1.6;
    }
}


/* Struktur Organisasi */
.org-box {
    width: 240px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    background-color: #fff;
}

.org-title {
    font-weight: 600;
    padding: 2px;
    font-size: 1rem;
}

.org-body {
    padding: 12px;
    font-size: 0.95rem;
    color: #333;
    background-color: #fff;
}

/* Responsif Struktur Organisasi*/
@media (max-width: 768px) {
    .org-box {
        width: 100%;
        max-width: 300px;
    }
}


/* Responsif untuk Google Maps */
.map-responsive {
    position: relative;
    overflow: hidden;
    padding-bottom: 60%; /* default tinggi untuk HP (rasio 16:9 agak tinggi) */
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

/* Atur tinggi map di layar besar */
@media (min-width: 768px) {
    .map-responsive {
        padding-bottom: 45%; /* Tablet */
    }
}

@media (min-width: 1200px) {
    .map-responsive {
        padding-bottom: 35%; /* Desktop — lebih pendek */
=======
>>>>>>> 3ba0a540739b5fab64717471f6bcc28bbd776ccd
    }
}

.text-justify {
    text-align: justify;
}

/* Responsif gambar di bagian Tentang Kelurahan */
.img-profil {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    object-fit: cover;
}

/* Atur ukuran dan posisi gambar di layar kecil */
@media (max-width: 768px) {
    .img-profil {
        width: 80%;
        margin: 0 auto;
        display: block;
    }
}

/* Tambahkan jarak vertikal di HP agar teks tidak terlalu rapat */
@media (max-width: 576px) {
    #profil-umum .col-md-8 p {
        font-size: 0.95rem;
        line-height: 1.6;
    }
}


/* Struktur Organisasi */
.org-box {
    width: 240px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    background-color: #fff;
}

.org-title {
    font-weight: 600;
    padding: 2px;
    font-size: 1rem;
}

.org-body {
    padding: 12px;
    font-size: 0.95rem;
    color: #333;
    background-color: #fff;
}

/* Responsif Struktur Organisasi*/
@media (max-width: 768px) {
    .org-box {
        width: 100%;
        max-width: 300px;
    }
}


/* Responsif untuk Google Maps */
.map-responsive {
    position: relative;
    overflow: hidden;
    padding-bottom: 60%; /* default tinggi untuk HP (rasio 16:9 agak tinggi) */
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

/* Atur tinggi map di layar besar */
@media (min-width: 768px) {
    .map-responsive {
        padding-bottom: 45%; /* Tablet */
    }
}

@media (min-width: 1200px) {
    .map-responsive {
        padding-bottom: 35%; /* Desktop — lebih pendek */
    }
}

/* ==== SOSIAL MEDIA ==== */
.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 600;
    text-decoration: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 50px;
    transition: all 0.3s ease;
    font-size: 1rem;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

/* Ikon */
.social-icon i {
    font-size: 1.3rem;
}

/* Warna platform */
.social-icon.facebook {
    background-color: #1877f2;
}

.social-icon.instagram {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
}

.social-icon.youtube {
    background-color: #ff0000;
}

/* Hover efek */
.social-icon:hover {
    transform: translateY(-3px);
    opacity: 0.9;
}

/* ==== RESPONSIVE ==== */
@media (max-width: 768px) {
    .social-icon {
        width: 80%;
        justify-content: center;
        font-size: 0.95rem;
        padding: 10px 0;
    }
}

@media (max-width: 576px) {
    .social-icon {
        width: 100%;
        font-size: 0.9rem;
        padding: 9px 0;
    }
}

</style>
