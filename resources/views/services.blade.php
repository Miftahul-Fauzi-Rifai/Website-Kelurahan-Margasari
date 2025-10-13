@extends('layouts.app')

@section('title', 'Layanan - Kelurahan Marga Sari')
@section('meta_description', 'Daftar lengkap layanan publik yang tersedia di Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold">Layanan Kelurahan</h1>
                <p class="lead">Berbagai layanan publik yang tersedia untuk memudahkan urusan administrasi Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-5">
    <div class="container">
        @if($services->count() > 0)
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6">
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
<section class="py-4 py-md-5 bg-light">
    <div class="container">
        <div class="text-center mb-4 mb-md-5">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-laptop me-2 me-md-3"></i>KELURAHAN - LAYANAN ONLINE
            </h2>
            <p class="lead text-muted d-none d-md-block">Akses layanan administrasi secara online melalui formulir digital</p>
            <p class="text-muted d-md-none">Layanan administrasi online</p>
        </div>
        
        <div class="row g-3 g-md-4">
            <!-- Surat Keterangan Belum Pernah Menikah -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card">
                    <div class="card-body p-3 p-md-4 text-center">
                        <div class="online-service-icon bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 mb-md-3">
                            <i class="bi bi-heart" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title fw-bold mb-2 mb-md-3 small-title">Surat Keterangan Belum Pernah Menikah</h6>
                        <p class="card-text text-muted mb-3 mb-md-4 small-text d-none d-md-block">Layanan online untuk pembuatan surat keterangan belum pernah menikah</p>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdGsM9e36Xnu1oKgQkQXDWUuztOSCAi48U6TXaHR6NvxzF_UA/viewform" 
                           target="_blank" 
                           class="btn btn-success w-100 btn-sm">
                            <i class="bi bi-link-45deg me-1 me-md-2"></i><span class="d-none d-md-inline">Akses </span>Formulir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Surat Keterangan Berpenghasilan Tidak Tetap -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card">
                    <div class="card-body p-3 p-md-4 text-center">
                        <div class="online-service-icon bg-info text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 mb-md-3">
                            <i class="bi bi-currency-exchange" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title fw-bold mb-2 mb-md-3 small-title">Surat Keterangan Berpenghasilan Tidak Tetap</h6>
                        <p class="card-text text-muted mb-3 mb-md-4 small-text d-none d-md-block">Layanan online untuk pembuatan surat keterangan penghasilan tidak tetap</p>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdxE8RzwhqP3NRPQAKA_4gLRRkY1TzSxrStCoa6mMDfbGsBlQ/viewform" 
                           target="_blank" 
                           class="btn btn-info w-100 btn-sm">
                            <i class="bi bi-link-45deg me-1 me-md-2"></i><span class="d-none d-md-inline">Akses </span>Formulir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Surat Keterangan Bertempat Tinggal -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card">
                    <div class="card-body p-3 p-md-4 text-center">
                        <div class="online-service-icon bg-warning text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 mb-md-3">
                            <i class="bi bi-house-door" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title fw-bold mb-2 mb-md-3 small-title">Surat Keterangan Bertempat Tinggal</h6>
                        <p class="card-text text-muted mb-3 mb-md-4 small-text d-none d-md-block">Layanan online untuk warga ber KTP luar daerah</p>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSd5yk7PJs8w2zH9I7ShGUcSDv_ECWnY1djhhA-BqPq5br1rFg/viewform" 
                           target="_blank" 
                           class="btn btn-warning w-100 btn-sm">
                            <i class="bi bi-link-45deg me-1 me-md-2"></i><span class="d-none d-md-inline">Akses </span>Formulir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Surat Keterangan Domisili -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card">
                    <div class="card-body p-3 p-md-4 text-center">
                        <div class="online-service-icon bg-secondary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 mb-md-3">
                            <i class="bi bi-geo-alt" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title fw-bold mb-2 mb-md-3 small-title">Surat Keterangan Domisili</h6>
                        <p class="card-text text-muted mb-3 mb-md-4 small-text d-none d-md-block">Layanan online untuk warga ber KTP setempat</p>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSf3CY5du5srC1-73PvF69pqBErpHnN0qclQL83lH-BOn1WU7w/viewform" 
                           target="_blank" 
                           class="btn btn-secondary w-100 btn-sm">
                            <i class="bi bi-link-45deg me-1 me-md-2"></i><span class="d-none d-md-inline">Akses </span>Formulir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Surat Keterangan Janda/Duda -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card">
                    <div class="card-body p-3 p-md-4 text-center">
                        <div class="online-service-icon bg-danger text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 mb-md-3">
                            <i class="bi bi-person-x" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title fw-bold mb-2 mb-md-3 small-title">Surat Keterangan Janda/Duda</h6>
                        <p class="card-text text-muted mb-3 mb-md-4 small-text d-none d-md-block">Layanan online untuk pembuatan surat keterangan status janda/duda</p>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLScHI8sYC1E9Xrqsm5XvjSekkj2WuhZFEjfgNjyXymb049-jWg/viewform" 
                           target="_blank" 
                           class="btn btn-danger w-100 btn-sm">
                            <i class="bi bi-link-45deg me-1 me-md-2"></i><span class="d-none d-md-inline">Akses </span>Formulir
                        </a>
                    </div>
                </div>
            </div>

            <!-- Placeholder untuk layanan online tambahan -->
            <div class="col-6 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm online-service-card border-dashed">
                    <div class="card-body p-3 p-md-4 text-center d-flex align-items-center justify-content-center">
                        <div>
                            <i class="bi bi-plus-circle text-muted" style="font-size: 2rem;"></i>
                            <h6 class="mt-2 text-muted small-title">Layanan Lainnya</h6>
                            <p class="text-muted small mb-0 d-none d-md-block">Akan segera hadir</p>
                        </div>
                    </div>
                </div>
            </div>
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

/* Online Services Styling */
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

@media (max-width: 768px) {
    .service-icon {
        width: 60px;
        height: 60px;
    }
    
    .service-icon i {
        font-size: 1.5rem !important;
    }
}
</style>
@endpush
