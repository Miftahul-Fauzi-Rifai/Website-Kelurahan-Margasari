@extends('layouts.ketua-rt')

@section('title', 'Detail Laporan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan</h1>
            <p class="text-muted">RT {{ $report->rt_code }} - {{ $report->formatted_month }}</p>
        </div>
        <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">Informasi Laporan</h6>
            <div>
                {!! $report->status_badge !!}
                <a href="{{ route('ketua-rt.reports.print', $report) }}" class="btn btn-sm btn-primary ms-2" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                @if(!in_array($report->status, ['approved', 'rejected']))
                    <a href="{{ route('ketua-rt.reports.edit', $report) }}" class="btn btn-sm btn-warning ms-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5 class="font-weight-bold">{{ $report->title }}</h5>
                <small class="text-muted">
                    <i class="bi bi-calendar"></i> Dikirim: {{ $report->submitted_at ? $report->submitted_at->format('d F Y, H:i') : 'Belum dikirim' }}
                </small>
            </div>

            <hr>

            <div class="mb-3">
                <h6 class="font-weight-bold">Deskripsi</h6>
                <p class="text-muted" style="white-space: pre-line;">{{ $report->description }}</p>
            </div>

            @if($report->activities)
            <div class="mb-3">
                <h6 class="font-weight-bold">Kegiatan yang Dilakukan</h6>
                @php
                    $activities = json_decode($report->activities, true);
                    if (!is_array($activities)) {
                        // Fallback untuk format lama
                        $activities = [];
                    }
                @endphp
                @if(count($activities) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
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
                                @foreach($activities as $index => $activity)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            @if(!empty($activity['date']))
                                                {{ \Carbon\Carbon::parse($activity['date'])->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $activity['task'] ?? '-' }}</td>
                                        <td>{{ $activity['note'] ?? '-' }}</td>
                                        <td>
                                            @if(!empty($activity['photo']))
                                                <a href="{{ asset('storage/' . $activity['photo']) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $activity['photo']) }}" 
                                                         alt="Foto Kegiatan" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 80px;">
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Tidak ada kegiatan</p>
                @endif
            </div>
            @endif

            @if($report->issues)
            <div class="mb-3">
                <h6 class="font-weight-bold">Permasalahan</h6>
                <p class="text-muted" style="white-space: pre-line;">{{ $report->issues }}</p>
            </div>
            @endif

            @if($report->suggestions)
            <div class="mb-3">
                <h6 class="font-weight-bold">Saran/Usulan</h6>
                <p class="text-muted" style="white-space: pre-line;">{{ $report->suggestions }}</p>
            </div>
            @endif

            @if($report->attachment)
            <div class="mb-3">
                <h6 class="font-weight-bold">Lampiran</h6>
                <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-paperclip"></i> Lihat Lampiran
                </a>
            </div>
            @endif

            @if($report->admin_notes)
            <div class="alert alert-info">
                <h6 class="font-weight-bold">Catatan Admin</h6>
                <p class="mb-0" style="white-space: pre-line;">{{ $report->admin_notes }}</p>
                @if($report->reviewed_at)
                <small class="text-muted d-block mt-2">
                    <i class="bi bi-clock"></i> {{ $report->reviewed_at->format('d F Y, H:i') }}
                </small>
                @endif
            </div>
            @endif

            @if($report->status == 'draft')
            <div class="mt-4">
                <form action="{{ route('ketua-rt.reports.submit', $report) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Kirim laporan ini ke admin?')">
                        <i class="bi bi-send"></i> Kirim Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* === DETAIL LAPORAN — 100% RESPONSIF TANPA TERPOTONG === */

html, body {
    width: 100%;
    overflow-x: hidden;
}

.container-fluid {
    width: 100%;
    max-width: 100vw;
    overflow-x: hidden;
    padding-left: 1rem;
    padding-right: 1rem;
}

.card {
    border-radius: 0.75rem;
    overflow: visible;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border: 1px solid #e5e7eb;
    max-width: 100%;
}

.card-header {
    flex-wrap: wrap;
    gap: 0.5rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h6 {
    font-weight: 600;
    font-size: 1.05rem;
    color: #198754;
}

.card-header .btn {
    font-weight: 500;
}

/* ===== HEADER PAGE — Tetap kiri-kanan di semua device ===== */
.d-flex.justify-content-between.align-items-center.mb-4 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    flex-wrap: wrap;
}

.d-flex.justify-content-between.align-items-center.mb-4 > div:first-child {
    flex: 1;
    text-align: left;
}

.d-flex.justify-content-between.align-items-center.mb-4 h1 {
    font-weight: 600;
    color: #212529;
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

.d-flex.justify-content-between.align-items-center.mb-4 p {
    color: #6c757d;
    margin-bottom: 0;
}

.d-flex.justify-content-between.align-items-center.mb-4 .btn {
    flex-shrink: 0;
}

/* HP kecil — tetap sejajar kiri-kanan */
@media (max-width: 576px) {
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: center;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 h1 {
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 p {
        font-size: 0.9rem;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 .btn {
        font-size: 0.85rem;
        padding: 0.45rem 0.75rem;
        white-space: nowrap;
    }
}

/* ===== TABEL ===== */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    background: #fff;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    padding: 0.25rem;
    width: 100%;
    max-width: 100%;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table th,
.table td {
    vertical-align: middle !important;
    white-space: nowrap;
    padding: 0.6rem;
    border-color: #ececec;
    font-size: 0.9rem;
}

.table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #e5e7eb;
    color: #333;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.table img {
    border-radius: 0.5rem;
    object-fit: cover;
}

/* Scrollbar tampak di mobile */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: #b5b5b5;
    border-radius: 4px;
}
.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Hover lembut */
.table tbody tr:hover {
    background-color: #f9fafb;
}

/* ================= RESPONSIVE ================= */

/* Tablet Landscape */
@media (max-width: 992px) {
    .card-header {
        justify-content: space-between;
    }
    .card-header .btn-sm {
        font-size: 0.9rem;
        padding: 0.4rem 0.65rem;
    }
}

/* Tablet & iPad Portrait */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .card-header h6 {
        font-size: 1rem;
    }

    .card-header > div {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        gap: 0.4rem;
    }

    .card-header .badge {
        order: -1;
        font-size: 0.8rem;
        align-self: flex-start;
        margin-bottom: 0.25rem;
    }

    .card-header .btn {
        width: 100%;
    }

    .card-header .btn + .btn {
        margin-top: 0.3rem;
    }

    .table {
        width: 100%;
        min-width: unset;
    }

    .table th, .table td {
        font-size: 0.85rem;
        white-space: normal;
    }
}

/* HP kecil */
@media (max-width: 576px) {
    html, body {
        overflow-x: hidden;
    }

    .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        overflow-x: hidden;
    }

    .card {
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }

    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        width: 100%;
    }

    .card-header .btn {
        width: 100%;
        text-align: center;
    }

    .table-responsive {
        width: 100%;
        max-width: 100vw;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        min-width: unset;
    }

    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.82rem;
        white-space: normal;
    }

    .table img {
        max-width: 70px;
        max-height: 50px;
    }

    .mt-4 form .btn {
        width: 100%;
        font-size: 0.9rem;
    }
}
</style>
@endpush
