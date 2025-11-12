@extends('layouts.admin')

@section('title', 'Detail Pengaduan' . $complaint->id . ' - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-file-text me-2"></i>Detail Pengaduan
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.complaints.index') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item active">Detail {{ $complaint->id }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="true">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Complaint Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pengaduan</h6>
                    <div>
                        <span class="badge badge-{{ $complaint->getPriorityBadgeColor() }} me-2">
                            Prioritas: {{ ucfirst($complaint->prioritas) }}
                        </span>
                        <span class="badge badge-{{ $complaint->getStatusBadgeColor() }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Informasi Pengaduan</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 40%;">ID Pengaduan:</td>
                                    <td class="fw-bold">#{{ $complaint->id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Masuk:</td>
                                    <td>{{ $complaint->created_at->format('d F Y, H:i') }} WITA</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kategori:</td>
                                    <td><span class="badge badge-secondary">{{ ucfirst($complaint->kategori) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prioritas:</td>
                                    <td><span class="badge badge-{{ $complaint->getPriorityBadgeColor() }}">{{ ucfirst($complaint->prioritas) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td><span class="badge badge-{{ $complaint->getStatusBadgeColor() }}">{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Data Pelapor</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 30%;">Nama:</td>
                                    <td class="fw-bold">{{ $complaint->nama_pelapor }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Telepon:</td>
                                    <td>
                                        <a href="tel:{{ $complaint->telepon_pelapor }}" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1"></i>{{ $complaint->telepon_pelapor }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email:</td>
                                    <td>
                                        @if($complaint->email_pelapor)
                                            <a href="mailto:{{ $complaint->email_pelapor }}" class="text-decoration-none">
                                                <i class="bi bi-envelope me-1"></i>{{ $complaint->email_pelapor }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat:</td>
                                    <td>{{ $complaint->alamat_pelapor }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Judul Pengaduan</h6>
                        <div class="bg-light p-3 rounded">
                            <h5 class="mb-0">{{ $complaint->judul_pengaduan }}</h5>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Deskripsi Pengaduan</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0" style="white-space: pre-line;">{{ $complaint->deskripsi_pengaduan }}</p>
                        </div>
                    </div>

                    @if($complaint->foto_pendukung)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Foto Pendukung</h6>
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $complaint->foto_pendukung) }}" 
                                 class="img-fluid rounded shadow" 
                                 style="max-height: 400px; cursor: pointer;" 
                                 alt="Foto Pendukung"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal">
                        </div>
                    </div>

                    <!-- Image Modal -->
                    <div class="modal fade" id="imageModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto Pendukung</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $complaint->foto_pendukung) }}" 
                                         class="img-fluid" alt="Foto Pendukung">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($complaint->tanggapan_admin)
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Tanggapan Petugas</h6>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-chat-quote me-3 fs-4"></i>
                                <div>
                                    <p class="mb-2" style="white-space: pre-line;">{{ $complaint->tanggapan_admin }}</p>
                                    <small class="text-muted">
                                        <strong>{{ $complaint->admin ? $complaint->admin->name : 'Admin' }}</strong> • 
                                        {{ $complaint->tanggal_tanggapan ? $complaint->tanggal_tanggapan->format('d F Y, H:i') : '-' }} WITA
                                    </small>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    @if($complaint->status !== 'selesai')
                    <button type="button" class="btn btn-primary btn-sm d-block w-100 mb-2" 
                            data-bs-toggle="modal" data-bs-target="#statusModal">
                        <i class="bi bi-gear me-2"></i>Update Status
                    </button>
                    @endif

                    <button type="button" class="btn btn-info btn-sm d-block w-100 mb-2" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Cetak Detail
                    </button>

                    <a href="tel:{{ $complaint->telepon_pelapor }}" class="btn btn-success btn-sm d-block w-100 mb-2">
                        <i class="bi bi-telephone me-2"></i>Hubungi Pelapor
                    </a>

                    @if($complaint->email_pelapor)
                    <a href="mailto:{{ $complaint->email_pelapor }}" class="btn btn-outline-primary btn-sm d-block w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Kirim Email
                    </a>
                    @endif

                    <hr>

                    <button type="button" class="btn btn-danger btn-sm d-block w-100" 
                            onclick="confirmDelete({{ $complaint->id }})">
                        <i class="bi bi-trash me-2"></i>Hapus Pengaduan
                    </button>
                </div>
            </div>

            <!-- Timeline/History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $complaint->status == 'baru' ? 'active' : 'completed' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Pengaduan Masuk</h6>
                                <small class="text-muted">{{ $complaint->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        
                        @if($complaint->status !== 'baru')
                        <div class="timeline-item {{ $complaint->status == 'sedang_diproses' ? 'active' : ($complaint->status == 'selesai' || $complaint->status == 'ditolak' ? 'completed' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Sedang Diproses</h6>
                                <small class="text-muted">
                                    {{ $complaint->tanggal_tanggapan ? $complaint->tanggal_tanggapan->format('d M Y, H:i') : '-' }}
                                </small>
                            </div>
                        </div>
                        @endif
                        
                        @if(in_array($complaint->status, ['selesai', 'ditolak']))
                        <div class="timeline-item active {{ $complaint->status == 'ditolak' ? 'rejected' : 'completed' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $complaint->status == 'ditolak' ? 'Ditolak' : 'Selesai' }}</h6>
                                <small class="text-muted">
                                    {{ $complaint->tanggal_tanggapan ? $complaint->tanggal_tanggapan->format('d M Y, H:i') : '-' }}
                                </small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pelapor</h6>
                </div>
                <div class="card-body">
                    @php
                        $complaintsFromSameReporter = \App\Models\Complaint::where('telepon_pelapor', $complaint->telepon_pelapor)->count();
                    @endphp
                    <div class="text-center">
                        <div class="mb-2">
                            <h4 class="text-primary">{{ $complaintsFromSameReporter }}</h4>
                            <small class="text-muted">Total pengaduan dari pelapor ini</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.complaints.update-status', $complaint) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Saat Ini</label>
                        <input type="text" class="form-control" 
                               value="{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}" 
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Baru <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="baru" {{ $complaint->status == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="sedang_diproses" {{ $complaint->status == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $complaint->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggapan/Catatan</label>
                        <textarea name="tanggapan_admin" class="form-control" rows="4" 
                                  placeholder="Berikan tanggapan, penjelasan, atau catatan untuk pelapor...">{{ $complaint->tanggapan_admin }}</textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Tanggapan ini akan dapat dilihat oleh pelapor saat melakukan tracking pengaduan.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center">
                    <strong>Apakah Anda yakin ingin menghapus pengaduan ini?</strong>
                </p>
                <p class="text-center text-muted">
                    Pengaduan #{{ $complaint->id }} dari <strong>{{ $complaint->nama_pelapor }}</strong> 
                    akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ===================== CETAK FORMULIR PENGADUAN ===================== -->
<div class="d-none d-print-block mt-4">
    <table style="width: 100%; border: none; margin-bottom: 10px;">
        <tr>
            <td style="width: 20%; text-align: center;">
                <img src="{{ asset('images/logo-Balikpapan.png') }}" alt="Logo Kota" style="width: 80px; height: auto;">
            </td>
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <h5 style="margin:0;">PEMERINTAH KOTA BALIKPAPAN</h5>
                <h5 style="margin:0;">KELURAHAN MARGA SARI</h5>
                <p style="margin:0; font-size: 12px;">Jl. Semoi No.46 RT.14 Kel. Margasari, Kec. Balikpapan Barat, Kalimantan Timur. Telp. 0853-9330-6350 - Email. margasari33@gmail.com</p>
            </td>
            <td style="width: 20%; text-align: center;">
                <img src="{{ asset('images/LOGO_KELMARGA.png') }}" alt="Logo Kelurahan" style="width: 80px; height: auto;">
            </td>
        </tr>
    </table>

    <hr style="border: 1.5px solid black; margin: 5px 0 15px 0;">
    <h5 style="text-align: center; font-weight: bold; letter-spacing: 0.5px; margin: 18px 0 25px 0;">FORMULIR PENGADUAN</h5>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 12pt; margin-top: 10px;">
        <tr>
            <td style="width: 25%; border: 1px solid #000; padding: 6px;"><b>No. Register</b></td>
            <td style="border: 1px solid #000; padding: 6px;">#{{ $complaint->id }}</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-top: 8px;">
        <tr style="background: #f3f3f3;">
            <th colspan="2" style="border: 1px solid #000; padding: 5px; text-align:center;">IDENTITAS PELAPOR</th>
        </tr>
        <tr>
            <td style="width: 30%; border: 1px solid #000; padding: 5px;">Nama</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->nama_pelapor }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Alamat</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->alamat_pelapor }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Telepon</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->telepon_pelapor }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Email</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->email_pelapor ?? '-' }}</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-top: 8px;">
        <tr style="background: #f3f3f3;">
            <th colspan="2" style="border: 1px solid #000; padding: 5px; text-align:center;">KRONOLOGI</th>
        </tr>
        <tr>
            <td style="width: 30%; border: 1px solid #000; padding: 5px;">Waktu Pengaduan</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->created_at->format('d F Y, H:i') }} WITA</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Judul Pengaduan</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->judul_pengaduan }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Uraian/Kronologis</td>
            <td style="border: 1px solid #000; padding: 5px;">{{ $complaint->deskripsi_pengaduan }}</td>
        </tr>
        @if($complaint->foto_pendukung)
        <tr>
            <td style="border: 1px solid #000; padding: 5px;">Lampiran</td>
            <td style="border: 1px solid #000; padding: 5px;">
                <img src="{{ asset('storage/' . $complaint->foto_pendukung) }}" alt="Lampiran" style="max-width:250px; border:1px solid #000;">
            </td>
        </tr>
        @endif
    </table>

    <div style="margin-top: 80px; width: 100%;">
        <table style="width: 100%; border: none; font-size: 12pt;">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%; text-align: center;">
                    Balikpapan, {{ now()->format('d F Y') }}<br>
                    Penerima Pengadu,<br><br><br><br>
                    (...........................................)
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- =================== END CETAK FORMULIR PENGADUAN =================== -->


@endsection

@push('scripts')
<script>
function confirmDelete(complaintId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush

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

.badge-primary { background-color: #007bff; }
.badge-success { background-color: #28a745; }
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-danger { background-color: #dc3545; }
.badge-info { background-color: #17a2b8; }
.badge-secondary { background-color: #6c757d; }

@media print {
    .btn, .modal, .sidebar { display: none !important; }
    .card { border: 1px solid #000 !important; box-shadow: none !important; }
    .col-lg-8 { width: 100% !important; }
}

@media print {
    /* Hilangkan bagian dashboard & tombol */
    .sidebar, .navbar, .breadcrumb, .btn, .card-header, .card-footer, .modal, .alert {
        display: none !important;
    }

    body {
        font-family: "Times New Roman", serif;
        background: white !important;
        color: black !important;
        font-size: 12pt;
        line-height: 1.5;
    }

    @page {
        size: A4 portrait;
        margin: 2cm;
    }

    .card, .col-lg-8, .col-lg-4, .container-fluid {
        border: none !important;
        box-shadow: none !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .table {
        border: 1px solid #000 !important;
        border-collapse: collapse !important;
    }

    .table th, .table td {
        border: 1px solid #000 !important;
        padding: 6px !important;
        vertical-align: top !important;
    }

    /* Agar hanya print layout resmi */
    .d-print-block { display: block !important; }
    .d-none, .col-lg-4 { display: none !important; }
}

@media print {
    /* Hilangkan dashboard dan elemen lainnya */
    .sidebar, .navbar, .breadcrumb, .btn, .card, .modal, .alert, footer {
        display: none !important;
    }

    body {
        font-family: "Times New Roman", serif;
        color: #000;
        background: #fff !important;
        font-size: 12pt;
    }

    @page {
        size: A4 portrait;
        margin: 1.5cm;
    }

    table {
        border-collapse: collapse;
    }

    th, td {
        vertical-align: top;
    }

    .d-print-block {
        display: block !important;
    }
}

@media print {
    /* Pastikan heading halaman tidak ikut tercetak */
    .d-sm-flex.align-items-center.justify-content-between.mb-4 {
        display: none !important;
        visibility: hidden !important;
    }

    h1.h3.text-gray-800,
    nav[aria-label="breadcrumb"] {
        display: none !important;
        visibility: hidden !important;
    }
}

</style>
@endpush
