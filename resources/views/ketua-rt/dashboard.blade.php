@extends('layouts.ketua-rt')

@section('title', 'Dashboard Ketua RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard Ketua RT {{ Auth::user()->rt }}</h1>
            <p class="text-muted">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
        <div class="text-muted">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Laporan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_reports'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-files text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Draft
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['draft_reports'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-file-earmark text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Terkirim
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['submitted_reports'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-send text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disetujui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['approved_reports'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Laporan Bulan Ini -->
    @if(!$this_month_report)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Perhatian!</strong> Anda belum membuat laporan untuk bulan ini.
        <a href="{{ route('ketua-rt.reports.create') }}" class="alert-link">Buat sekarang</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif($this_month_report->status == 'draft')
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Info:</strong> Laporan bulan ini masih berstatus draft.
        <a href="{{ route('ketua-rt.reports.edit', $this_month_report) }}" class="alert-link">Edit laporan</a> atau 
        <a href="#" onclick="event.preventDefault(); document.getElementById('submit-{{ $this_month_report->id }}').submit();" class="alert-link">Kirim sekarang</a>
        <form id="submit-{{ $this_month_report->id }}" action="{{ route('ketua-rt.reports.submit', $this_month_report) }}" method="POST" class="d-none">
            @csrf
        </form>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif($this_month_report->status == 'submitted')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Sukses!</strong> Laporan bulan ini sudah terkirim dan menunggu review dari admin.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <!-- Laporan Terbaru -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-file-earmark-text me-2"></i>Laporan Terbaru
                    </h6>
                    <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-sm btn-success">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recent_reports->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_reports as $report)
                                    <tr>
                                        <td>{{ $report->formatted_month }}</td>
                                        <td>{{ Str::limit($report->title, 40) }}</td>
                                        <td>{!! $report->status_badge !!}</td>
                                        <td>
                                            <a href="{{ route('ketua-rt.reports.show', $report) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Belum ada laporan</p>
                            <a href="{{ route('ketua-rt.reports.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Buat Laporan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-lightning me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('ketua-rt.reports.create') }}" class="btn btn-success w-100 mb-3">
                        <i class="bi bi-plus-circle me-2"></i>Buat Laporan Baru
                    </a>
                    <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-outline-success w-100 mb-3">
                        <i class="bi bi-list-ul me-2"></i>Lihat Semua Laporan
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-globe me-2"></i>Lihat Website
                    </a>
                </div>
            </div>

            <!-- Info RT -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Informasi RT</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>RT/RW:</strong><br>
                        RT {{ Auth::user()->rt }} / RW {{ Auth::user()->rw }}
                    </div>
                    <div class="mb-2">
                        <strong>Ketua RT:</strong><br>
                        {{ Auth::user()->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Kontak:</strong><br>
                        {{ Auth::user()->phone ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-xs {
    font-size: 0.7rem;
}
</style>
@endpush
@endsection
