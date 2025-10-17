@extends('layouts.app')

@section('title', 'Tentang Kami - Kelurahan Marga Sari')
@section('meta_description', 'Halaman informasi Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-4 py-md-5 page-header-about">
    <div class="container">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">Tentang Kelurahan Marga Sari</h1>
        <p class="lead mb-0 mobile-subtitle">Halaman informasi Kelurahan Marga Sari</p>
    </div>
</section>

@endsection

@push('styles')
<style>
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
</style>
@endpush
