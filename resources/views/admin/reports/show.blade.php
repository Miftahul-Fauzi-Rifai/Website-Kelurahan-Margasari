@extends('layouts.admin')

@section('title', 'Detail Laporan RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan RT</h1>
            <p class="text-muted">RT {{ $report->rt_code }} - {{ $report->formatted_month }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Report Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                    {!! $report->status_badge !!}
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">{{ $report->title }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> Dikirim: {{ $report->submitted_at ? $report->submitted_at->format('d F Y, H:i') : '-' }}
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

                    <div class="row mb-3">
                        @if($report->total_residents)
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-primary">{{ $report->total_residents }}</h3>
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
                        <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="btn btn-outline-primary btn-sm">
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
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- RT Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi RT</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>RT:</strong> {{ $report->rt_code }}
                    </div>
                    <div class="mb-2">
                        <strong>Ketua RT:</strong><br>
                        {{ $report->user->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Kontak:</strong><br>
                        {{ $report->user->phone ?? '-' }}
                    </div>
                    <div>
                        <strong>Email:</strong><br>
                        {{ $report->user->email }}
                    </div>
                </div>
            </div>

            <!-- Review Actions -->
            @if(in_array($report->status, ['submitted', 'reviewed']))
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Review Laporan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.update-status', $report) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="reviewed">Direview</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Berikan catatan atau feedback...">{{ $report->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

