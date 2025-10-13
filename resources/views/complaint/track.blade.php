@extends('layouts.app')

@section('title', 'Lacak Pengaduan - Kelurahan Marga Sari')

@section('content')
<section class="bg-primary text-white py-4 py-md-5">
    <div class="container">
        <h1 class="display-6 fw-bold">Lacak Pengaduan</h1>
        <p class="lead mb-0">Pantau status dan perkembangan pengaduan Anda</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search Form -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-search fs-4"></i>
                            </div>
                            <h3 class="fw-bold">Lacak Status Pengaduan</h3>
                            <p class="text-muted">Masukkan ID pengaduan untuk melihat status dan perkembangan</p>
                        </div>

                        <form action="{{ route('complaint.track') }}" method="GET">
                            <div class="input-group input-group-lg mb-3">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-hash"></i>
                                </span>
                                <input type="number" class="form-control" name="id" value="{{ request('id') }}" 
                                       placeholder="Masukkan ID Pengaduan (contoh: 12345)" required>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-search me-2"></i>Lacak
                                </button>
                            </div>
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    ID pengaduan dapat ditemukan di email konfirmasi atau catat saat pengajuan
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($complaint)
                <!-- Complaint Details -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-file-text me-2"></i>Detail Pengaduan #{{ $complaint->id }}
                            </h5>
                            <span class="badge bg-{{ $complaint->getStatusBadgeColor() }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Status Timeline -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Status Pengaduan</h6>
                                <div class="timeline">
                                    <div class="timeline-item {{ $complaint->status == 'baru' ? 'active' : 'completed' }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Pengaduan Diterima</h6>
                                            <small class="text-muted">{{ $complaint->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item {{ $complaint->status == 'sedang_diproses' ? 'active' : ($complaint->status == 'selesai' || $complaint->status == 'ditolak' ? 'completed' : '') }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">Sedang Diproses</h6>
                                            <small class="text-muted">
                                                {{ $complaint->status == 'baru' ? 'Menunggu pemrosesan' : ($complaint->tanggal_tanggapan ? $complaint->tanggal_tanggapan->format('d M Y, H:i') : '-') }}
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="timeline-item {{ $complaint->status == 'selesai' ? 'active completed' : ($complaint->status == 'ditolak' ? 'active rejected' : '') }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">
                                                {{ $complaint->status == 'ditolak' ? 'Ditolak' : 'Selesai' }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ in_array($complaint->status, ['selesai', 'ditolak']) && $complaint->tanggal_tanggapan ? $complaint->tanggal_tanggapan->format('d M Y, H:i') : 'Belum selesai' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Complaint Info -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-primary mb-3">Informasi Pengaduan</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted ps-0">Judul:</td>
                                        <td class="fw-semibold">{{ $complaint->judul_pengaduan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Kategori:</td>
                                        <td><span class="badge bg-secondary">{{ ucfirst($complaint->kategori) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Prioritas:</td>
                                        <td><span class="badge bg-{{ $complaint->getPriorityBadgeColor() }}">{{ ucfirst($complaint->prioritas) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Tanggal:</td>
                                        <td>{{ $complaint->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold text-primary mb-3">Data Pelapor</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted ps-0">Nama:</td>
                                        <td class="fw-semibold">{{ $complaint->nama_pelapor }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Telepon:</td>
                                        <td>{{ $complaint->telepon_pelapor }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Email:</td>
                                        <td>{{ $complaint->email_pelapor ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Alamat:</td>
                                        <td>{{ $complaint->alamat_pelapor }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary mb-3">Deskripsi Pengaduan</h6>
                                <div class="bg-light rounded p-3">
                                    {{ $complaint->deskripsi_pengaduan }}
                                </div>
                            </div>

                            @if($complaint->foto_pendukung)
                            <div class="col-12 mb-4">
                                <h6 class="fw-bold text-primary mb-3">Foto Pendukung</h6>
                                <img src="{{ asset('storage/' . $complaint->foto_pendukung) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="max-height: 300px;" 
                                     alt="Foto Pendukung">
                            </div>
                            @endif

                            @if($complaint->tanggapan_admin)
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">Tanggapan Petugas</h6>
                                <div class="alert alert-info">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-chat-quote me-3 fs-4"></i>
                                        <div>
                                            <p class="mb-2">{{ $complaint->tanggapan_admin }}</p>
                                            <small class="text-muted">
                                                <strong>{{ $complaint->admin ? $complaint->admin->name : 'Admin' }}</strong> • 
                                                {{ $complaint->tanggal_tanggapan->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('complaint.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-plus me-2"></i>Buat Pengaduan Baru
                            </a>
                            <button onclick="window.print()" class="btn btn-secondary">
                                <i class="bi bi-printer me-2"></i>Cetak
                            </button>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -1.75rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #dee2e6;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-item.completed .timeline-marker {
    background: #198754;
    box-shadow: 0 0 0 2px #198754;
}

.timeline-item.active .timeline-marker {
    background: #0d6efd;
    box-shadow: 0 0 0 2px #0d6efd;
    animation: pulse 2s infinite;
}

.timeline-item.rejected .timeline-marker {
    background: #dc3545;
    box-shadow: 0 0 0 2px #dc3545;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

@media (max-width: 768px) {
    .timeline {
        padding-left: 1.5rem;
    }
    
    .timeline::before {
        left: 0.75rem;
    }
    
    .timeline-marker {
        left: -1.25rem;
    }
}

@media print {
    .btn, .alert .btn-close {
        display: none !important;
    }
    
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
