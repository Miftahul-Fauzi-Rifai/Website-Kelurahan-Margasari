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
                <p class="text-muted" style="white-space: pre-line;">{{ $report->activities }}</p>
            </div>
            @endif

            @if($report->total_residents || $report->total_households)
            <div class="row mb-3">
                @if($report->total_residents)
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $report->total_residents }}</h3>
                            <p class="mb-0 text-muted">Total Warga</p>
                        </div>
                    </div>
                </div>
                @endif
                @if($report->total_households)
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $report->total_households }}</h3>
                            <p class="mb-0 text-muted">Total KK</p>
                        </div>
                    </div>
                </div>
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

