@extends('layouts.ketua-rt')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan Bulanan</h1>
            <p class="text-muted">Daftar laporan yang sudah dibuat</p>
        </div>
        <a href="{{ route('ketua-rt.reports.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Buat Laporan Baru
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Daftar Laporan RT {{ Auth::user()->rt }}</h6>
        </div>
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal Kirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td><strong>{{ $report->formatted_month }}</strong></td>
                                <td>{{ $report->title }}</td>
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
                                        <a href="{{ route('ketua-rt.reports.show', $report) }}" 
                                           class="btn btn-sm btn-info" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if(!in_array($report->status, ['approved', 'rejected']))
                                            <a href="{{ route('ketua-rt.reports.edit', $report) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif

                                        @if($report->status == 'draft')
                                            <form action="{{ route('ketua-rt.reports.submit', $report) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        title="Kirim" 
                                                        onclick="return confirm('Kirim laporan ini ke admin?')">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </form>
                                            
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="if(confirm('Yakin ingin menghapus?')) document.getElementById('delete-{{ $report->id }}').submit()"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-{{ $report->id }}" 
                                                  action="{{ route('ketua-rt.reports.destroy', $report) }}" 
                                                  method="POST" class="d-none">
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
                <div class="d-flex justify-content-center mt-3">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada laporan yang dibuat</p>
                    <a href="{{ route('ketua-rt.reports.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Buat Laporan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

