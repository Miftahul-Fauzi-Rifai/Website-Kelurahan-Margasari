@extends('layouts.admin')

@section('title', 'Kelola Pengaduan - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-megaphone me-2"></i>Kelola Pengaduan Warga
        </h1>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Pengaduan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-megaphone text-info" style="font-size: 2rem;"></i>
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
                                Pengaduan Baru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['baru']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sedang Diproses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['proses']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-gear text-primary" style="font-size: 2rem;"></i>
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
                                Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['selesai']) }}
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

    <!-- Filter & Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.complaints.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prioritas</label>
                        <select name="prioritas" class="form-select form-select-sm">
                            <option value="">Semua Prioritas</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Pencarian</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   value="{{ request('search') }}" placeholder="Nama/Judul...">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm me-2">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Pengaduan 
                <span class="badge badge-info">{{ $complaints->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($complaints->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="complaintsTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Pelapor</th>
                                <th width="25%">Judul Pengaduan</th>
                                <th width="12%">Kategori</th>
                                <th width="8%">Prioritas</th>
                                <th width="10%">Status</th>
                                <th width="12%">Tanggal</th>
                                <th width="13%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                            <tr>
                                <td class="text-center">#{{ $complaint->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $complaint->nama_pelapor }}</div>
                                    <small class="text-muted">{{ $complaint->telepon_pelapor }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ Str::limit($complaint->judul_pengaduan, 40) }}</div>
                                    <small class="text-muted">{{ Str::limit($complaint->deskripsi_pengaduan, 60) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($complaint->kategori) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $complaint->getPriorityBadgeColor() }}">
                                        {{ ucfirst($complaint->prioritas) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $complaint->getStatusBadgeColor() }}">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $complaint->created_at->format('d/m/Y') }}</small><br>
                                    <small class="text-muted">{{ $complaint->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($complaint->status !== 'selesai')
                                        <button type="button" class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#statusModal{{ $complaint->id }}" 
                                                title="Update Status">
                                            <i class="bi bi-gear"></i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete({{ $complaint->id }})" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Status Modal -->
                                    <div class="modal fade" id="statusModal{{ $complaint->id }}" tabindex="-1">
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
                                                            <label class="form-label">Status</label>
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
                                                                      placeholder="Berikan tanggapan atau catatan...">{{ $complaint->tanggapan_admin }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $complaints->firstItem() }} - {{ $complaints->lastItem() }} dari {{ $complaints->total() }} pengaduan
                    </div>
                    {{ $complaints->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Pengaduan</h5>
                    <p class="text-muted">Tidak ada pengaduan yang sesuai dengan filter yang dipilih.</p>
                </div>
            @endif
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
                <p>Apakah Anda yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(complaintId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ route('admin.complaints.index') }}/${complaintId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto refresh badge counts every 30 seconds
setInterval(function() {
    fetch('{{ route('admin.complaints.index') }}?ajax=stats')
        .then(response => response.json())
        .then(data => {
            // Update stats if needed
        })
        .catch(error => console.log('Stats update failed'));
}, 30000);
</script>
@endpush

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

.table th {
    border-color: #e3e6f0;
    font-weight: 600;
}

.table td {
    border-color: #e3e6f0;
    vertical-align: middle;
}

.btn-group-sm > .btn, .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge {
    font-size: 0.7rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .btn-group-sm > .btn {
        padding: 0.2rem 0.4rem;
    }
}
</style>
@endpush
