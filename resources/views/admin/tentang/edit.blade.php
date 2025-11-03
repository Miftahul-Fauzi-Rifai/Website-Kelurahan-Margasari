@extends('layouts.admin')

@section('title', 'Edit Tentang Kelurahan')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h4 mb-4">Edit Tentang Kelurahan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tentang Kelurahan -->
    <form action="{{ route('admin.tentang.update') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm rounded-3 mb-4">
        @csrf
        <h5 class="mb-3 fw-bold text-primary">Informasi Umum</h5>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi', $tentang->deskripsi ?? '') }}</textarea>
        </div>

        <div class="row text-center">
            <div class="col-md-6 mb-3 d-flex flex-column align-items-center">
                <label class="form-label fw-semibold">Gambar Kantor</label>
                <div class="image-preview">
                    @if(!empty($tentang->gambar_kantor))
                        <img src="{{ asset($tentang->gambar_kantor) }}" alt="Gambar Kantor">
                    @else
                        <span class="text-muted small">Belum ada gambar</span>
                    @endif
                </div>
                <input type="file" name="gambar" class="form-control mt-1" accept="image/*">
            </div>

            <div class="col-md-6 mb-3 d-flex flex-column align-items-center">
                <label class="form-label fw-semibold">Logo Kelurahan</label>
                <div class="image-preview">
                    @if(!empty($tentang->logo))
                        <img src="{{ asset($tentang->logo) }}" alt="Logo Kelurahan">
                    @else
                        <span class="text-muted small">Belum ada logo</span>
                    @endif
                </div>
                <input type="file" name="logo" class="form-control mt-1" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3 w-100">Simpan Perubahan</button>
    </form>

    <!-- Struktur Organisasi -->
    <div class="card p-4 shadow-sm rounded-3 mb-4">
        <h5 class="mb-3 fw-bold text-primary">Struktur Organisasi</h5>

        <form action="{{ route('admin.tentang.struktur.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required placeholder="Contoh: Lurah">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required placeholder="Nama pejabat">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" placeholder="0" min="0" step="1">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100">Tambah</button>
                </div>
            </div>
        </form>

        @if($struktur->isEmpty())
            <p class="text-muted text-center mb-0">Belum ada data struktur organisasi.</p>
        @else
            <table class="table table-bordered align-middle" id="tableStruktur">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Jabatan</th>
                        <th>Nama</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($struktur as $item)
                        <tr data-id="{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="jabatan-text">{{ $item->jabatan }}</td>
                            <td class="nama-text">{{ $item->nama }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm btn-edit-struktur">Edit</button>
                                <button type="button" class="btn btn-success btn-sm btn-save-struktur d-none">Simpan</button>
                                <form action="{{ route('admin.tentang.struktur.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Sosial Media -->
    <div class="card p-4 shadow-sm rounded-3 mb-4">
        <h5 class="mb-3 fw-bold text-primary">Sosial Media Kelurahan</h5>

        <form action="{{ route('admin.tentang.sosial.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Platform</label>
                    <input type="text" name="platform" class="form-control" required placeholder="Contoh: Instagram">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL</label>
                    <input type="url" name="url" class="form-control" required placeholder="https://...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100">Tambah</button>
                </div>
            </div>
        </form>

        @if($sosmed->isEmpty())
            <p class="text-muted text-center mb-0">Belum ada sosial media terdaftar.</p>
        @else
            <table class="table table-bordered align-middle" id="tableSosial">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Platform</th>
                        <th>URL</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sosmed as $sm)
                        <tr data-id="{{ $sm->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="platform-text">{{ $sm->platform }}</td>
                            <td class="url-text"><a href="{{ $sm->url }}" target="_blank">{{ $sm->url }}</a></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm btn-edit-sosial">Edit</button>
                                <button type="button" class="btn btn-success btn-sm btn-save-sosial d-none">Simpan</button>
                                <form action="{{ route('admin.tentang.sosial.destroy', $sm->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function() {
    // === STRUKTUR ===
    $('.btn-edit-struktur').click(function() {
        let row = $(this).closest('tr');
        row.find('.btn-edit-struktur').addClass('d-none');
        row.find('.btn-save-struktur').removeClass('d-none');
        let jabatan = row.find('.jabatan-text').text();
        let nama = row.find('.nama-text').text();
        row.find('.jabatan-text').html(`<input type="text" class="form-control jabatan-input" value="${jabatan}">`);
        row.find('.nama-text').html(`<input type="text" class="form-control nama-input" value="${nama}">`);
    });

    $('.btn-save-struktur').click(function() {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let jabatan = row.find('.jabatan-input').val();
        let nama = row.find('.nama-input').val();

        $.ajax({
            url: `/admin/tentang/struktur/${id}`,
            type: 'PUT',
            data: { jabatan, nama, _token: '{{ csrf_token() }}' },
            success: function() {
                row.find('.jabatan-text').text(jabatan);
                row.find('.nama-text').text(nama);
                row.find('.btn-edit-struktur').removeClass('d-none');
                row.find('.btn-save-struktur').addClass('d-none');
                row.css('background', '#e8f5e9').delay(400).queue(function(next){
                    $(this).css('background', '');
                    next();
                });
            }
        });
    });

    // === SOSIAL MEDIA ===
    $('.btn-edit-sosial').click(function() {
        let row = $(this).closest('tr');
        row.find('.btn-edit-sosial').addClass('d-none');
        row.find('.btn-save-sosial').removeClass('d-none');
        let platform = row.find('.platform-text').text();
        let url = row.find('.url-text a').attr('href');
        row.find('.platform-text').html(`<input type="text" class="form-control platform-input" value="${platform}">`);
        row.find('.url-text').html(`<input type="url" class="form-control url-input" value="${url}">`);
    });

    $('.btn-save-sosial').click(function() {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let platform = row.find('.platform-input').val();
        let url = row.find('.url-input').val();

        $.ajax({
            url: `/admin/tentang/sosial/${id}`,
            type: 'PUT',
            data: { platform, url, _token: '{{ csrf_token() }}' },
            success: function() {
                row.find('.platform-text').text(platform);
                row.find('.url-text').html(`<a href="${url}" target="_blank">${url}</a>`);
                row.find('.btn-edit-sosial').removeClass('d-none');
                row.find('.btn-save-sosial').addClass('d-none');
                row.css('background', '#e8f5e9').delay(400).queue(function(next){
                    $(this).css('background', '');
                    next();
                });
            }
        });
    });
});
</script>

<style>
/* ==== Umum ==== */
.container-fluid {
    padding-left: 1rem;
    padding-right: 1rem;
}
.card {
    border-radius: 10px;
    overflow: hidden;
}
h1.h4 {
    font-size: clamp(1.1rem, 2.2vw, 1.5rem);
}
h5.mb-3 {
    font-size: clamp(1rem, 2vw, 1.2rem);
}

/* ==== Gambar Kantor & Logo ==== */
.image-preview {
    width: 150px;
    height: 150px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    margin-bottom: 8px;
    transition: 0.3s ease;
}
.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.image-preview img:hover {
    transform: scale(1.05);
}
.row.text-center .col-md-6 {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* ==== Input dan Tombol ==== */
input[type="file"],
input[type="text"],
input[type="number"],
textarea,
select {
    max-width: 100%;
    width: 100%;
    border-radius: 6px;
}
button.btn {
    font-weight: 500;
    transition: all 0.25s ease;
}
button.btn:hover {
    transform: translateY(-1px);
}

/* ==== Tabel ==== */
.table {
    width: 100%;
    font-size: 0.95rem;
    border-collapse: collapse;
}
.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    padding: 10px;
}
.table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered {
    border-radius: 8px;
    overflow: hidden;
}

/* Bungkus tabel agar bisa di-scroll di layar kecil */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* ==== Form antar section ==== */
form .row.g-3 {
    gap: 0.5rem;
}
form .form-label {
    font-weight: 500;
    margin-bottom: 5px;
}

/* ==== Efek kecil hover untuk tombol aksi ==== */
.btn-sm {
    transition: background 0.2s ease, transform 0.2s ease;
}
.btn-sm:hover {
    transform: scale(1.05);
}

/* ==== Responsif Tablet ==== */
@media (max-width: 992px) {
    .col-md-6, .col-md-4, .col-md-2 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    .btn {
        width: 100%;
        margin-top: 8px;
    }
    .image-preview {
        width: 130px;
        height: 130px;
    }
    .table {
        font-size: 0.9rem;
    }
}

/* ==== Responsif Mobile ==== */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    .card {
        padding: 1rem;
    }
    .image-preview {
        width: 110px;
        height: 110px;
    }
    .table {
        font-size: 0.85rem;
    }
    h5.mb-3 {
        text-align: center;
    }
    .btn {
        font-size: 0.9rem;
    }
}

/* ==== Responsif Kecil Banget (HP mini) ==== */
@media (max-width: 480px) {
    h1.h4 {
        font-size: 1rem;
    }
    .image-preview {
        width: 90px;
        height: 90px;
    }
    .table {
        font-size: 0.8rem;
    }
    button.btn {
        padding: 6px 10px;
    }
}
</style>
@endpush