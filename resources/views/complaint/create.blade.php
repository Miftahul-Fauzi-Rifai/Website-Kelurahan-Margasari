@extends('layouts.app')

@section('title', 'Form Pengaduan Warga - Kelurahan Marga Sari')
@section('meta_description', 'Sampaikan pengaduan dan aspirasi Anda kepada Kelurahan Marga Sari melalui form pengaduan online.')

@section('content')
<section id="complaint-hero" class="complaint-hero-section text-white py-4 py-md-5 page-header-complaint">
    <div class="container position-relative">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">Form Pengaduan Warga</h1>
        <p class="lead mb-0 mobile-subtitle">Sampaikan aspirasi, keluhan, dan saran Anda untuk kemajuan bersama</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-12">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-3 p-sm-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-megaphone fs-4"></i>
                            </div>
                            <h3 class="fw-bold">Formulir Pengaduan</h3>
                            <p class="text-muted">Isi formulir di bawah ini dengan lengkap dan jelas</p>
                        </div>

                        <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Data Pelapor -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="bi bi-person me-2"></i>Data Pelapor
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama_pelapor" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" 
                                           id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required>
                                    @error('nama_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telepon_pelapor" class="form-label">Nomor Telepon/HP <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telepon_pelapor') is-invalid @enderror" 
                                           id="telepon_pelapor" name="telepon_pelapor" value="{{ old('telepon_pelapor') }}" required>
                                    @error('telepon_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email_pelapor" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email_pelapor') is-invalid @enderror" 
                                           id="email_pelapor" name="email_pelapor" value="{{ old('email_pelapor') }}">
                                    @error('email_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="alamat_pelapor" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_pelapor') is-invalid @enderror" 
                                              id="alamat_pelapor" name="alamat_pelapor" rows="3" required>{{ old('alamat_pelapor') }}</textarea>
                                    @error('alamat_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Data Pengaduan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="bi bi-file-text me-2"></i>Detail Pengaduan
                                    </h5>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="judul_pengaduan" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul_pengaduan') is-invalid @enderror" 
                                           id="judul_pengaduan" name="judul_pengaduan" value="{{ old('judul_pengaduan') }}" 
                                           placeholder="Ringkasan singkat pengaduan Anda" required>
                                    @error('judul_pengaduan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="prioritas" class="form-label">Tingkat Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('prioritas') is-invalid @enderror" id="prioritas" name="prioritas" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                    @error('prioritas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="kategori" class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $key => $value)
                                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="deskripsi_pengaduan" class="form-label">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('deskripsi_pengaduan') is-invalid @enderror" 
                                              id="deskripsi_pengaduan" name="deskripsi_pengaduan" rows="6" 
                                              placeholder="Jelaskan detail pengaduan Anda dengan lengkap..." required>{{ old('deskripsi_pengaduan') }}</textarea>
                                    @error('deskripsi_pengaduan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="foto_pendukung" class="form-label">Foto Pendukung</label>
                                    <input type="file" class="form-control @error('foto_pendukung') is-invalid @enderror" 
                                           id="foto_pendukung" name="foto_pendukung" accept="image/*">
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>Upload foto pendukung jika ada (maksimal 2MB, format: JPG, PNG, GIF)
                                    </div>
                                    @error('foto_pendukung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-between align-items-center">
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary order-2 order-sm-1">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg order-1 order-sm-2 w-100 w-sm-auto">
                                            <i class="bi bi-send me-2"></i>Kirim Pengaduan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Form Styling */
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    transition: all 0.3s ease;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:hover:not(:focus), .form-select:hover:not(:focus) {
    border-color: #0d6efd;
}

/* Card Styling */
.card {
    transition: all 0.3s ease;
    border-radius: 1rem;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Button Styling */
.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #003f82 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
}

.btn-outline-secondary {
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-1px);
}


/* Icon in header */
.bg-primary.rounded-circle {
    transition: all 0.3s ease;
}

.bg-primary.rounded-circle:hover {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 576px) {
    .display-6 {
        font-size: 1.75rem;
    }
    
    .lead {
        font-size: 1rem;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .fs-2 {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .py-5 {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
}

@media (min-width: 992px) {
    .form-control, .form-select {
        font-size: 0.95rem;
    }
}

/* Loading state for submit button */
.btn-primary:disabled {
    background: #6c757d;
    border-color: #6c757d;
    cursor: not-allowed;
}

/* Form validation styling */
.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Custom file input styling */
.form-control[type="file"] {
    padding: 0.5rem 0.75rem;
}

.form-control[type="file"]::-webkit-file-upload-button {
    background: #0d6efd;
    color: white;
    border: none;
    border-radius: 0.25rem;
    padding: 0.375rem 0.75rem;
    margin-right: 0.75rem;
    cursor: pointer;
}

/* Smooth animations */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
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

/* Page Header Spacing untuk menghindari navbar */
.page-header-complaint {
    padding-top: 90px !important; /* Reasonable space from fixed navbar */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header-complaint {
        padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
    }
}

@media (max-width: 576px) {
    .page-header-complaint {
        padding-top: 70px !important; /* Minimal padding on small mobile */
    }
}

/* ==== COMPLAINT HERO SECTION - BACKGROUND BIRU ==== */
.complaint-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.complaint-hero-section .container {
    position: relative;
    z-index: 2;
}
</style>
@endpush

@push('scripts')
@endpush
