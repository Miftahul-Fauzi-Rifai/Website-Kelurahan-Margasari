@extends('layouts.app')

@section('title', 'Layanan - Kelurahan Marga Sari')
@section('meta_description', 'Daftar lengkap layanan publik yang tersedia di Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<!-- Page Header -->
<section id="services-hero" class="services-hero-section text-white py-5 py-md-5 page-header-services">
    <div class="container position-relative">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">Layanan Kelurahan</h1>
        <p class="lead mb-0 mobile-subtitle">Berbagai layanan publik yang tersedia untuk memudahkan urusan administrasi Anda</p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-5 bg-light">
    <div class="container">
        @if($services->count() > 0)
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card h-100 border-0 shadow-sm service-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="service-icon bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3">
                                    <i class="bi {{ $service->icon ?? 'bi-gear' }}" style="font-size: 2rem;"></i>
                                </div>
                                <h5 class="card-title fw-bold">{{ $service->name }}</h5>
                            </div>
                            
                            <p class="card-text text-muted mb-4">{{ $service->description }}</p>
                            
                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="bi bi-clock me-2"></i>Waktu Proses
                                </h6>
                                <p class="mb-0 small">
                                    @if($service->processing_days)
                                        {{ $service->processing_days }} hari kerja
                                    @else
                                        Selesai hari itu juga
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="bi bi-cash me-2"></i>Biaya
                                </h6>
                                <p class="mb-0 small">
                                    @if($service->fee > 0)
                                        <span class="fw-bold text-success">Rp {{ number_format($service->fee, 0, ',', '.') }}</span>
                                    @else
                                        <span class="fw-bold text-success">Gratis</span>
                                    @endif
                                </p>
                            </div>
                            
                            @if($service->contact_person)
                            <div class="mb-3">
                                <h6 class="text-primary mb-2">
                                    <i class="bi bi-person me-2"></i>Contact Person
                                </h6>
                                <p class="mb-0 small">{{ $service->contact_person }}</p>
                                @if($service->phone)
                                    <p class="mb-0 small">
                                        <i class="bi bi-telephone me-1"></i>{{ $service->phone }}
                                    </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <button class="btn btn-outline-primary w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#serviceModal{{ $service->id }}">
                                <i class="bi bi-info-circle me-2"></i>Detail Layanan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Service Detail Modal -->
                <div class="modal fade" id="serviceModal{{ $service->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="bi {{ $service->icon ?? 'bi-gear' }} me-2"></i>
                                    {{ $service->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Deskripsi Layanan
                                        </h6>
                                        <p>{{ $service->description }}</p>
                                        
                                        <div class="mb-3">
                                            <strong>Waktu Proses:</strong> 
                                            @if($service->processing_days)
                                                {{ $service->processing_days }} hari kerja
                                            @else
                                                Selesai hari itu juga
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <strong>Biaya:</strong> 
                                            @if($service->fee > 0)
                                                <span class="text-success">Rp {{ number_format($service->fee, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-success">Gratis</span>
                                            @endif
                                        </div>
                                        
                                        @if($service->contact_person)
                                        <div class="mb-3">
                                            <strong>Contact Person:</strong> {{ $service->contact_person }}
                                            @if($service->phone)
                                                <br><i class="bi bi-telephone me-1"></i>{{ $service->phone }}
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-6">
                                        @if($service->requirements)
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-list-check me-2"></i>Persyaratan
                                        </h6>
                                        <div class="requirements">
                                            {!! nl2br(e($service->requirements)) !!}
                                        </div>
                                        @endif
                                        
                                        @if($service->process)
                                        <h6 class="text-primary mb-3 mt-4">
                                            <i class="bi bi-arrow-right-circle me-2"></i>Alur Proses
                                        </h6>
                                        <div class="process">
                                            {!! nl2br(e($service->process)) !!}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                                @auth
                                <a href="{{ route('complaint.create') }}" class="btn btn-primary">
                                    <i class="bi bi-envelope me-2"></i>Ajukan Permohonan
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Ajukan
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Online Services Section -->
<section class="pt-0 pb-4 pt-md-1 pb-md-5 bg-light" style="margin-top: -4rem;">
    <div class="container">
        <div class="text-center mb-3 mb-md-4" style="padding-top: -5rem;">
            <h2 class="fw-bold text-primary">
                LAYANAN ONLINE
            </h2>
            <p class="lead text-muted d-none d-md-block">Akses layanan administrasi secara online melalui formulir digital</p>
            <p class="text-muted d-md-none">Layanan administrasi online</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            @php
            $onlineServices = [
                [
                    'name' => 'Surat Keterangan Belum Pernah Menikah',
                    'description' => 'Layanan online untuk pembuatan surat keterangan belum pernah menikah',
                    'icon' => 'bi-heart',
                    'color' => 'success',
                    'form_url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdGsM9e36Xnu1oKgQkQXDWUuztOSCAi48U6TXaHR6NvxzF_UA/viewform'
                ],
                [
                    'name' => 'Surat Keterangan Berpenghasilan Tidak Tetap',
                    'description' => 'Layanan online untuk pembuatan surat keterangan penghasilan tidak tetap',
                    'icon' => 'bi-currency-exchange',
                    'color' => 'info',
                    'form_url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdxE8RzwhqP3NRPQAKA_4gLRRkY1TzSxrStCoa6mMDfbGsBlQ/viewform'
                ],
                [
                    'name' => 'Surat Keterangan Bertempat Tinggal',
                    'description' => 'Layanan online untuk warga ber KTP luar daerah',
                    'icon' => 'bi-house-door',
                    'color' => 'warning',
                    'form_url' => 'https://docs.google.com/forms/d/e/1FAIpQLSd5yk7PJs8w2zH9I7ShGUcSDv_ECWnY1djhhA-BqPq5br1rFg/viewform'
                ],
                [
                    'name' => 'Surat Keterangan Domisili',
                    'description' => 'Layanan online untuk warga ber KTP setempat',
                    'icon' => 'bi-geo-alt',
                    'color' => 'secondary',
                    'form_url' => 'https://docs.google.com/forms/d/e/1FAIpQLSf3CY5du5srC1-73PvF69pqBErpHnN0qclQL83lH-BOn1WU7w/viewform'
                ],
                [
                    'name' => 'Surat Keterangan Janda/Duda',
                    'description' => 'Layanan online untuk pembuatan surat keterangan status janda/duda',
                    'icon' => 'bi-person-x',
                    'color' => 'danger',
                    'form_url' => 'https://docs.google.com/forms/d/e/1FAIpQLScHI8sYC1E9Xrqsm5XvjSekkj2WuhZFEjfgNjyXymb049-jWg/viewform'
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
                            <a href="{{ $service['form_url'] }}" class="btn btn-{{ $service['color'] }} w-100 fw-semibold py-2" target="_blank">
                                <i class="bi bi-link-45deg me-2"></i>Akses Formulir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-4 mt-md-5 p-3 p-md-4 bg-primary text-white rounded">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h6 class="mb-2 d-md-none">
                        <i class="bi bi-info-circle me-2"></i>Info Penggunaan
                    </h6>
                    <h5 class="mb-2 d-none d-md-block">
                        <i class="bi bi-info-circle me-2"></i>Petunjuk Penggunaan Layanan Online
                    </h5>
                    <p class="mb-0 small d-md-none">
                        Klik tombol formulir untuk mengakses Google Forms dan isi data dengan lengkap.
                    </p>
                    <p class="mb-0 d-none d-md-block">
                        Klik tombol "Akses Formulir Online" pada layanan yang diinginkan. 
                        Anda akan diarahkan ke Google Forms untuk mengisi data yang diperlukan. 
                        Pastikan data yang dimasukkan sudah benar dan lengkap.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-2 mt-lg-0 d-none d-md-block">
                    <i class="bi bi-laptop" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.service-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.service-icon {
    width: 80px;
    height: 80px;
}

/* Service Online Cards Styling - Matching Homepage */
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

/* Mobile responsive layout for service cards - matching home.blade.php */
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

/* Extra small mobile screens - very compact layout, no hover effects */
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
    .py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }
    
    .text-center.mb-4 h2 {
        font-size: 1.3rem !important;
        margin-bottom: 0.8rem !important;
    }
    
    .text-center.mb-4 .text-muted {
        font-size: 0.8rem !important;
        margin-bottom: 2rem !important;
    }
    
    /* Reduce gap between service cards */
    .row.g-4 {
        --bs-gutter-x: 0.5rem;
        --bs-gutter-y: 0.5rem;
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

/* Legacy Online Services Styling - Keep for backward compatibility */ 
.online-service-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.online-service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2) !important;
}

.online-service-icon {
    width: 70px;
    height: 70px;
}

.border-dashed {
    border: 2px dashed #dee2e6 !important;
    background-color: #f8f9fa;
}

.border-dashed:hover {
    border-color: #6c757d !important;
    transform: translateY(-3px);
}

/* Disable hover effects on touch devices and mobile screens - matching home.blade.php */
@media (hover: none) and (pointer: coarse), (max-width: 768px) {
    /* Completely disable all hover effects on mobile */
    .card:hover,
    .service-card:hover,
    .service-online-card:hover,
    .online-service-card:hover {
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
    .service-card,
    .service-online-card,
    .online-service-card,
    .service-online-card .icon-wrapper,
    .service-online-action .btn,
    .service-online-card::before {
        transition: none !important;
    }
    
    /* Ensure no transform animations trigger on tap */
    .service-online-card,
    .service-card {
        -webkit-tap-highlight-color: rgba(0,0,0,0.1);
    }
}

/* Mobile Optimizations */
@media (max-width: 768px) {
    .online-service-icon {
        width: 50px;
        height: 50px;
    }
    
    .online-service-icon i {
        font-size: 1.2rem !important;
    }
    
    .small-title {
        font-size: 0.9rem !important;
        line-height: 1.2;
    }
    
    .small-text {
        font-size: 0.8rem !important;
    }
    
    .online-service-card .card-body {
        padding: 0.75rem !important;
    }
    
    .btn-sm {
        padding: 0.375rem 0.5rem;
        font-size: 0.8rem;
    }
    
    /* Compact header */
    section.py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }
    
    .text-center.mb-4 h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    /* Reduce gaps */
    .row.g-3 {
        --bs-gutter-x: 0.75rem;
        --bs-gutter-y: 0.75rem;
    }
}

.requirements,
.process {
    font-size: 0.9rem;
    line-height: 1.6;
}

.requirements ul,
.process ul {
    padding-left: 1.2rem;
}

.requirements li,
.process li {
    margin-bottom: 0.5rem;
}

/* Page Header Spacing untuk menghindari navbar */
.page-header-services {
    padding-top: 90px !important; /* Reasonable space from fixed navbar */
    padding-bottom: 2rem !important; /* Jarak bawah untuk mobile */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header-services {
        padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
        padding-bottom: 2.5rem !important; /* Tambahan jarak bawah mobile */
    }
}

@media (max-width: 576px) {
    .page-header-services {
        padding-top: 70px !important; /* Minimal padding on small mobile */
        padding-bottom: 2rem !important; /* Jarak bawah yang cukup */
    }
    
    .page-header-services h1 {
        font-size: 1.8rem !important;
        line-height: 1.3;
    }
    
    .page-header-services .lead {
        font-size: 1rem !important;
    }
}

/* Regular Service Cards Mobile Responsive */
@media (max-width: 768px) {
    .service-card .card-body {
        padding: 1.5rem 1rem !important;
    }
    
    .service-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 1rem !important;
    }
    
    .service-icon i {
        font-size: 1.5rem !important;
    }
    
    .service-card .card-title {
        font-size: 1rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .service-card .card-text {
        font-size: 0.85rem !important;
        line-height: 1.4;
        margin-bottom: 1rem !important;
    }
    
    .service-card h6 {
        font-size: 0.8rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .service-card .small {
        font-size: 0.75rem !important;
    }
}

@media (max-width: 576px) {
    .service-card .card-body {
        padding: 1rem 0.75rem !important;
    }
    
    .service-icon {
        width: 50px;
        height: 50px;
        margin-bottom: 0.75rem !important;
    }
    
    .service-icon i {
        font-size: 1.3rem !important;
    }
    
    .service-card .card-title {
        font-size: 0.9rem !important;
        line-height: 1.2;
        margin-bottom: 0.5rem !important;
    }
    
    .service-card .card-text {
        font-size: 0.8rem !important;
        line-height: 1.3;
        margin-bottom: 0.75rem !important;
    }
    
    .service-card h6 {
        font-size: 0.75rem !important;
        margin-bottom: 0.4rem !important;
    }
    
    .service-card .small {
        font-size: 0.7rem !important;
        line-height: 1.2;
    }
    
    .service-card .card-footer .btn {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.75rem !important;
    }
}

/* Mobile Header Optimizations - sama dengan Data RT */
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

/* ==== SERVICES HERO SECTION - BACKGROUND BIRU ==== */
.services-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.services-hero-section .container {
    position: relative;
    z-index: 2;
}
</style>
@endpush

@push('scripts')
@endpush
