@extends('layouts.ketua-rt')

@section('title', 'Buat Laporan Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Buat Laporan Baru</h1>
            <p class="text-muted">Laporan bulanan RT {{ Auth::user()->rt }}</p>
        </div>
        <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Form Laporan</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Notifikasi Tips -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-lightbulb-fill me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="alert-heading mb-2"><strong>💡 Tips Mengisi Laporan</strong></h6>
                                <ul class="mb-0 small">
                                    <li>Isi laporan secara <strong>ringkas dan jelas</strong></li>
                                    <li>Usahakan <strong>tidak lebih dari 1 halaman</strong> saat dicetak</li>
                                    <li>Gunakan <strong>poin-poin</strong> untuk memudahkan pembacaan</li>
                                    <li>Lampirkan <strong>foto kegiatan</strong> jika diperlukan (maks 2MB per foto)</li>
                                    <li>Fokus pada kegiatan dan kondisi <strong>penting</strong> saja</li>
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('ketua-rt.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan Laporan <span class="text-danger">*</span></label>
                            <input type="month" class="form-control @error('month') is-invalid @enderror" 
                                   id="month" name="month" value="{{ old('month', now()->format('Y-m')) }}" required>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Contoh: Laporan Kegiatan RT 01 Bulan Oktober 2025" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi/Ringkasan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required 
                                      placeholder="Tuliskan ringkasan kondisi lingkungan dan warga pada bulan ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: Kondisi lingkungan dan warga pada bulan ini baik</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kegiatan yang Dilakukan</label>
                            <small class="text-muted d-block mb-3">Isi setiap kegiatan dengan detail tanggal, uraian tugas, keterangan, dan foto (opsional)</small>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered" id="activities-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">NO</th>
                                            <th width="15%">TANGGAL</th>
                                            <th width="40%">URAIAN TUGAS</th>
                                            <th width="20%">KETERANGAN</th>
                                            <th width="20%">FOTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < 5; $i++)
                                            <tr class="activity-row">
                                                <td class="text-center align-middle row-number">{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="date" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][date]" 
                                                           value="{{ old('activities.'.$i.'.date') }}">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][task]" 
                                                           value="{{ old('activities.'.$i.'.task') }}"
                                                           placeholder="Contoh: Kerja bakti membersihkan lingkungan">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][note]" 
                                                           value="{{ old('activities.'.$i.'.note') }}"
                                                           placeholder="Opsional">
                                                </td>
                                                <td>
                                                    <input type="file" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][photo]"
                                                           accept="image/*">
                                                    <small class="text-muted">Max 2MB</small>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted d-block mt-2">Isi kegiatan yang ada saja, maksimal 5 kegiatan. Baris kosong akan diabaikan.</small>
                        </div>

                        <script>
                            // Script removed - fixed 5 rows only
                        </script>

                        <div class="mb-3">
                            <label for="issues" class="form-label">Permasalahan yang Ada</label>
                            <textarea class="form-control @error('issues') is-invalid @enderror" 
                                      id="issues" name="issues" rows="3" 
                                      placeholder="Tuliskan permasalahan atau kendala yang ada (jika ada)">{{ old('issues') }}</textarea>
                            @error('issues')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="suggestions" class="form-label">Saran/Usulan</label>
                            <textarea class="form-control @error('suggestions') is-invalid @enderror" 
                                      id="suggestions" name="suggestions" rows="3" 
                                      placeholder="Saran atau usulan untuk perbaikan">{{ old('suggestions') }}</textarea>
                            @error('suggestions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan sebagai Draft
                            </button>
                            <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===================== ALERT TIPS ===================== */
.alert-info {
    background: linear-gradient(135deg, #e7f3ff 0%, #d4e9ff 100%);
    border-left: 4px solid #0d6efd;
    border-radius: 0.5rem;
}

.alert-info .bi-lightbulb-fill {
    color: #ffc107;
}

.alert-info h6 {
    color: #0d6efd;
    font-weight: 600;
}

.alert-info ul li {
    margin-bottom: 0.25rem;
    color: #495057;
}

.alert-info ul li strong {
    color: #0d6efd;
}

/* ===================== DASAR RESPONSIF ===================== */
html, body {
    width: 100%;
    overflow-x: hidden;
}

.container-fluid {
    width: 100%;
    max-width: 100vw;
    padding-left: 1rem;
    padding-right: 1rem;
}

/* --- Card utama --- */
.card {
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: visible;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e5e7eb;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
    padding: 1rem 1.25rem;
}

/* --- Header Halaman --- */
.d-flex.justify-content-between.align-items-center.mb-4 {
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.d-flex.justify-content-between.align-items-center.mb-4 h1 {
    font-size: 1.6rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.d-flex.justify-content-between.align-items-center.mb-4 p {
    font-size: 0.95rem;
    margin-bottom: 0;
    color: #6c757d;
}

.d-flex.justify-content-between.align-items-center.mb-4 .btn {
    flex-shrink: 0;
}

/* --- Form Input --- */
.form-label {
    font-weight: 500;
    color: #333;
}

.form-control, textarea {
    border-radius: 0.5rem;
    font-size: 0.95rem;
}

/* --- Tabel Kegiatan --- */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    padding: 0.25rem;
}

.table th, .table td {
    vertical-align: middle !important;
    padding: 0.6rem;
    font-size: 0.9rem;
    border-color: #ececec;
    white-space: nowrap;
}

.table thead th {
    background: #f8f9fa;
    text-transform: uppercase;
    font-size: 0.85rem;
    font-weight: 600;
}

/* --- Tombol --- */
.d-flex.gap-2 {
    flex-wrap: wrap;
}
.d-flex.gap-2 .btn {
    border-radius: 0.5rem;
    font-weight: 500;
}

/* Scrollbar lembut */
.table-responsive::-webkit-scrollbar { height: 8px; }
.table-responsive::-webkit-scrollbar-thumb {
    background: #b5b5b5;
    border-radius: 4px;
}
.table-responsive::-webkit-scrollbar-track { background: #f1f1f1; }

/* ===================== TAMPILAN HP ===================== */
@media (max-width: 576px) {

    /* Header: teks di kiri, tombol di kanan */
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.25rem 0.5rem;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 > div:first-child {
        text-align: left;
        flex: 1;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 h1 {
        font-size: 1.2rem;
        line-height: 1.2;
        margin-bottom: 0.15rem;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 p {
        font-size: 0.85rem;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 .btn {
        font-size: 0.8rem;
        padding: 0.35rem 0.7rem;
        border-radius: 0.45rem;
        white-space: nowrap;
    }

    /* Input tabel seperti textarea */
    #activities-table input[type="text"].form-control-sm {
        display: block;
        width: 100%;
        min-height: 3rem;
        max-height: 8rem;
        padding: 0.55rem 0.65rem;
        border-radius: 0.45rem;
        border: 2px solid #ced4da;
        white-space: normal;
        word-break: break-word;
        overflow-y: auto;
        overflow-x: hidden;
        line-height: 1.4;
        resize: vertical;
        font-size: 0.85rem;
    }

    #activities-table input[type="text"].form-control-sm:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59,130,246,0.25);
        outline: none;
    }

    #activities-table td {
        vertical-align: top !important;
        padding: 0.45rem;
    }

    #activities-table input[type="date"].form-control-sm,
    #activities-table input[type="file"].form-control-sm {
        font-size: 0.83rem;
        padding: 0.4rem 0.5rem;
        height: auto;
    }

    .table {
        width: 700px;
    }

    .table th, .table td {
        font-size: 0.82rem;
        white-space: nowrap;
    }

    .d-flex.gap-2 {
        flex-direction: column;
    }
    .d-flex.gap-2 .btn {
        width: 100%;
        font-size: 0.9rem;
    }
}

/* ===================== TAMPILAN TABLET ===================== */
@media (min-width: 577px) and (max-width: 992px) {
    .d-flex.justify-content-between.align-items-center.mb-4 h1 {
        font-size: 1.4rem;
    }
    .table th, .table td {
        font-size: 0.88rem;
    }
    .d-flex.gap-2 .btn {
        font-size: 0.9rem;
    }
}
</style>
@endpush
