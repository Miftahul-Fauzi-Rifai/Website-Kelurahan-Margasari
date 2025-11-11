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
                                        
                                        @if($report->status !== 'approved')
                                            <a href="{{ route('ketua-rt.reports.edit', $report) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif

                                        @if($report->status == 'draft')
                                            <!-- Kirim -->
                                            <form action="{{ route('ketua-rt.reports.submit', $report) }}" 
                                                  method="POST" class="d-inline form-submit">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success btn-kirim" title="Kirim">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </form>

                                            <!-- Hapus -->
                                            <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $report->id }}" title="Hapus">
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

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Konfirmasi Kirim ===
    document.querySelectorAll('.btn-kirim').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Kirim laporan ini ke admin?',
                text: "Pastikan semua data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // === Konfirmasi Hapus ===
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            Swal.fire({
                title: 'Yakin ingin menghapus laporan ini?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-' + id).submit();
                }
            });
        });
    });
});
</script>
@endpush

<style>
/* === Tambahkan jarak antar tombol aksi === */
.table .btn-group {
    gap: 12px; /* ubah ke 10px jika mau agak renggang */
}

/* === Ukuran seragam tombol aksi (semua warna, termasuk hijau) === */
.table .btn-group .btn,
.table .btn-group form button {
    width: 35px !important;        /* sisi sama panjang */
    height: 35px !important;
    padding: 0 !important;         /* hilangkan padding default Bootstrap */
    display: inline-flex !important;
    justify-content: center;
    align-items: center;
    border-radius: 10px !important;
    border: none !important;
    box-sizing: border-box;
    line-height: 1;
    cursor: pointer;
    transition: all 0.2s ease;

}



/* === Pastikan ikon rata tengah === */
.table .btn-group .btn i,
.table .btn-group form button i {
    font-size: 18px;
    line-height: 1;
}

/* === Warna tetap dari Bootstrap === */
.btn-info    { background-color: #0dcaf0 !important; color: #fff !important; }
.btn-warning { background-color: #ffc107 !important; color: #000 !important; }
.btn-success { background-color: #198754 !important; color: #fff !important; }
.btn-danger  { background-color: #dc3545 !important; color: #fff !important; }

/* === Hover halus === */
.table .btn-group .btn:hover,
.table .btn-group form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

/* === RESPONSIF UNTUK TABLET === */
@media (max-width: 992px) {
    .table .btn-group {
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .table .btn-group .btn,
    .table .btn-group form button {
        width: 44px !important;
        height: 44px !important;
        border-radius: 10px !important;
    }
}

/* === PERBAIKAN RESPONSIF UNTUK HP (AGAR TIDAK TERPOTONG) === */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100% !important;
    }

    .card {
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }

    .btn.btn-success {
        width: 100%;
        text-align: center;
    }
}

/* ====== Perapihan global biar tidak ada scroll horizontal ====== */
html, body {
    overflow-x: hidden; /* cegah konten “keluar” ke samping */
}

/* ====== Sidebar overlay mode di mobile/tablet (tidak mendorong konten) ====== */
@media (max-width: 992px) {
    /* Pastikan konten full dan tidak ikut terdorong */
    #content-wrapper, .content-wrapper, .container-fluid {
        margin-left: 0 !important;
        width: 100% !important;
    }

    /* Jadikan sidebar bertumpuk di atas konten */
    #accordionSidebar, .sidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1050;                 /* di atas konten */
        width: 240px;                   /* lebar sidebar */
        max-width: 80%;
        background: #ffffff;            /* samakan dengan sidebar-mu */
        box-shadow: 2px 0 12px rgba(0,0,0,.18);
        transform: translateX(-100%);   /* default: tersembunyi di kiri */
        transition: transform .28s ease;
    }

    /* SB-Admin2 biasanya menambah class ini di <body> saat toggle */
    body.sidebar-toggled #accordionSidebar,
    body.sidebar-toggled .sidebar {
        transform: translateX(0);       /* tampil tanpa menggeser konten */
    }

    /* Rapikan area header halaman di mobile */
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }

    /* Tombol “Buat Laporan Baru” full-width di HP enak dipakai jempol */
    .btn.btn-success {
        width: 100%;
        text-align: center;
    }
}

/* ====== Meja/ kartu supaya pas di layar kecil ====== */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 0.875rem !important;
        padding-right: 0.875rem !important;
    }
    .card {
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
        box-sizing: border-box !important;
    }
}

/* === RESPONSIF UNTUK HP === */
@media (max-width: 576px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table .btn-group {
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }

    .table .btn-group .btn,
    .table .btn-group form button {
        width: 46px !important;
        height: 46px !important;
        border-radius: 10px !important;
    }

    .table td, .table th {
        white-space: nowrap;
        font-size: 0.85rem;
        padding: 8px 4px !important;
    }

    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
}
</style>
