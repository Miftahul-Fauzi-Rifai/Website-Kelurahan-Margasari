@extends('layouts.app')

@section('title', 'Dashboard Ketua RT')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}</h2>
                            <p class="mb-0 opacity-75">
                                Dashboard Ketua RT {{ Auth::user()->rt }}/RW {{ Auth::user()->rw }} - Kelurahan Marga Sari
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="bi bi-person-badge display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">150</h4>
                    <p class="text-muted mb-0">Total Warga RT {{ Auth::user()->rt }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="bi bi-house-door" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">45</h4>
                    <p class="text-muted mb-0">Jumlah KK</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="bi bi-clipboard-check" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">12</h4>
                    <p class="text-muted mb-0">Surat Pengantar Bulan Ini</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="bi bi-calendar-event" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">3</h4>
                    <p class="text-muted mb-0">Kegiatan Mendatang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#suratPengantarModal">
                                <i class="bi bi-file-text d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Buat Surat Pengantar</small>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <button class="btn btn-outline-success w-100 py-3" data-bs-toggle="modal" data-bs-target="#dataWargaModal">
                                <i class="bi bi-people d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Data Warga</small>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <button class="btn btn-outline-info w-100 py-3" data-bs-toggle="modal" data-bs-target="#kegiatanModal">
                                <i class="bi bi-calendar-plus d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Kegiatan RT</small>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <button class="btn btn-outline-warning w-100 py-3" data-bs-toggle="modal" data-bs-target="#laporanModal">
                                <i class="bi bi-bar-chart d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Laporan</small>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <button class="btn btn-outline-danger w-100 py-3" data-bs-toggle="modal" data-bs-target="#pengaduanModal">
                                <i class="bi bi-exclamation-triangle d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Pengaduan</small>
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('complaint.create') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-telephone d-block mb-2" style="font-size: 1.5rem;"></i>
                                <small>Kontak Kelurahan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Announcements -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-activity me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Surat Pengantar untuk Bapak Ahmad</h6>
                                <p class="text-muted mb-1">Surat pengantar untuk keperluan pembuatan KTP</p>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Kegiatan Gotong Royong</h6>
                                <p class="text-muted mb-1">Pembersihan lingkungan RT 01 telah selesai dilaksanakan</p>
                                <small class="text-muted">1 hari yang lalu</small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Rapat Koordinasi</h6>
                                <p class="text-muted mb-1">Rapat koordinasi dengan pengurus RT lainnya</p>
                                <small class="text-muted">3 hari yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements & Info -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-megaphone me-2"></i>Pengumuman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-2">Rapat Koordinasi RT/RW</h6>
                        <p class="small text-muted mb-1">Akan diadakan rapat koordinasi untuk membahas program kerja bulan depan.</p>
                        <small class="text-muted">Besok, 19:30 WITA</small>
                    </div>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-2">Bantuan Sosial</h6>
                        <p class="small text-muted mb-1">Pendaftaran bantuan sosial untuk warga kurang mampu dibuka hingga akhir bulan.</p>
                        <small class="text-muted">Deadline: 30 Des 2024</small>
                    </div>
                    
                    <div>
                        <h6 class="mb-2">Kegiatan Posyandu</h6>
                        <p class="small text-muted mb-1">Posyandu rutin bulan ini akan diadakan di rumah Ibu RT.</p>
                        <small class="text-muted">Minggu depan</small>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-telephone me-2"></i>Kontak Penting
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Kelurahan Marga Sari</h6>
                        <p class="mb-1 small">
                            <i class="bi bi-telephone me-2"></i>(0542) 123-456
                        </p>
                        <p class="mb-0 small">
                            <i class="bi bi-whatsapp me-2"></i>0812-3456-7890
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Keamanan</h6>
                        <p class="mb-0 small">
                            <i class="bi bi-telephone me-2"></i>(0542) 789-012
                        </p>
                    </div>
                    
                    <div>
                        <h6>Puskesmas</h6>
                        <p class="mb-0 small">
                            <i class="bi bi-telephone me-2"></i>(0542) 345-678
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Surat Pengantar Modal -->
<div class="modal fade" id="suratPengantarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Surat Pengantar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Pemohon</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keperluan</label>
                        <select class="form-select" required>
                            <option value="">Pilih Keperluan</option>
                            <option value="ktp">Pembuatan KTP</option>
                            <option value="kk">Pembuatan KK</option>
                            <option value="domisili">Surat Domisili</option>
                            <option value="usaha">Izin Usaha</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Buat Surat</button>
            </div>
        </div>
    </div>
</div>

<!-- Data Warga Modal -->
<div class="modal fade" id="dataWargaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Warga RT {{ Auth::user()->rt }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Fitur ini dalam tahap pengembangan. Untuk saat ini, silakan hubungi kelurahan untuk data lengkap warga.
                </div>
                
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-primary">150</h4>
                                <p class="mb-0">Total Warga</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-success">45</h4>
                                <p class="mb-0">Kepala Keluarga</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-warning">25</h4>
                                <p class="mb-0">Anak-anak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('complaint.create') }}" class="btn btn-primary">Sampaikan Pengaduan</a>
            </div>
        </div>
    </div>
</div>

<!-- Other modals would be similar... -->

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -2.25rem;
    top: 1.5rem;
    width: 2px;
    height: calc(100% - 0.5rem);
    background-color: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -2.75rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    border-left: 3px solid #0d6efd;
}
</style>
@endpush
