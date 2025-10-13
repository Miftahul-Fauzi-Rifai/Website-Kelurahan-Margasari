@extends('layouts.admin')

@section('title', 'Manajemen Posts')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manajemen Posts</h1>
            <p class="text-muted">Kelola artikel, berita, dan pengumuman</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Buat Post Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Posts Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Posts</h6>
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Judul</th>
                                <th width="10%">Tipe</th>
                                <th width="10%">Status</th>
                                <th width="15%">Penulis</th>
                                <th width="15%">Tanggal Publish</th>
                                <th width="10%">Views</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($post->title, 50) }}</div>
                                        @if($post->excerpt)
                                            <small class="text-muted">{{ Str::limit($post->excerpt, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->type === 'berita')
                                            <span class="badge bg-info">Berita</span>
                                        @elseif($post->type === 'pengumuman')
                                            <span class="badge bg-warning">Pengumuman</span>
                                        @else
                                            <span class="badge bg-success">Agenda</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if($post->published_at)
                                            <small>{{ $post->published_at->format('d M Y H:i') }}</small>
                                        @else
                                            <small class="text-muted">Belum publish</small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($post->views) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.posts.show', $post) }}" 
                                               class="btn btn-sm btn-outline-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.posts.edit', $post) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete({{ $post->id }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
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
                        Menampilkan {{ $posts->firstItem() }} sampai {{ $posts->lastItem() }} 
                        dari {{ $posts->total() }} posts
                    </div>
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum ada post</h5>
                    <p class="text-muted">Mulai buat konten untuk website kelurahan</p>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Buat Post Pertama
                    </a>
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
                Apakah Anda yakin ingin menghapus post ini? Tindakan ini tidak dapat dibatalkan.
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
function confirmDelete(postId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/posts/${postId}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
