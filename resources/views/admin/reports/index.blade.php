@extends('layouts.admin')

@section('title', 'Laporan RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan RT</h1>
            <p class="text-muted">Kelola dan review laporan bulanan dari Ketua RT</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Review</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['submitted'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
        </div>
        
        <!-- Filter -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Terkirim</option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Direview</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RT</label>
                    <input type="text" name="rt_code" class="form-control" placeholder="Kode RT" value="{{ request('rt_code') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>RT</th>
                                <th>Bulan</th>
                                <th>Judul</th>
                                <th>Ketua RT</th>
                                <th>Status</th>
                                <th>Tanggal Kirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td><strong>RT {{ $report->rt_code }}</strong></td>
                                <td>{{ $report->formatted_month }}</td>
                                <td>{{ Str::limit($report->title, 50) }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>{!! $report->status_badge !!}</td>
                                <td>
                                    @if($report->submitted_at)
                                        {{ $report->submitted_at->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($report->status !== 'approved')
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="if(confirm('Yakin ingin menghapus?')) document.getElementById('delete-{{ $report->id }}').submit()"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-{{ $report->id }}" action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada laporan yang ditemukan</p>
                </div>
            @endif
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
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.text-xs {
    font-size: 0.7rem;
}
</style>
@endpush
@endsection

