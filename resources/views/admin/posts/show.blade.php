@extends('layouts.admin')

@section('title', 'Preview Post')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Preview Post</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                    <li class="breadcrumb-item active">Preview</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Post Content -->
            <div class="card shadow mb-4">
                <div class="card-body p-0">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" class="card-img-top" style="height: 300px; object-fit: cover;">
                    @endif
                    
                    <div class="p-4">
                        <!-- Post Meta -->
                        <div class="mb-3">
                            <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                                <span>
                                    <i class="bi bi-person me-1"></i>{{ $post->user->name }}
                                </span>
                                <span>
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $post->published_at ? $post->published_at->format('d F Y H:i') : $post->created_at->format('d F Y H:i') }}
                                </span>
                                <span>
                                    <i class="bi bi-eye me-1"></i>{{ number_format($post->views) }} views
                                </span>
                                <span>
                                    @if($post->type === 'berita')
                                        <span class="badge bg-info">Berita</span>
                                    @elseif($post->type === 'pengumuman')
                                        <span class="badge bg-warning">Pengumuman</span>
                                    @else
                                        <span class="badge bg-success">Agenda</span>
                                    @endif
                                </span>
                                <span>
                                    @if($post->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="h2 mb-3">{{ $post->title }}</h1>

                        <!-- Excerpt -->
                        @if($post->excerpt)
                            <div class="lead text-muted mb-4">
                                {{ $post->excerpt }}
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="post-content">
                            {!! nl2br($post->content) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Post Information -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0">Informasi Post</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-sm">ID:</dt>
                        <dd class="col-sm-8 text-sm">{{ $post->id }}</dd>
                        
                        <dt class="col-sm-4 text-sm">Slug:</dt>
                        <dd class="col-sm-8 text-sm"><code class="small">{{ $post->slug }}</code></dd>
                        
                        <dt class="col-sm-4 text-sm">Tipe:</dt>
                        <dd class="col-sm-8 text-sm">{{ ucfirst($post->type) }}</dd>
                        
                        <dt class="col-sm-4 text-sm">Status:</dt>
                        <dd class="col-sm-8 text-sm">
                            @if($post->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4 text-sm">Penulis:</dt>
                        <dd class="col-sm-8 text-sm">{{ $post->user->name }}</dd>
                        
                        <dt class="col-sm-4 text-sm">Views:</dt>
                        <dd class="col-sm-8 text-sm">{{ number_format($post->views) }}</dd>
                        
                        <dt class="col-sm-4 text-sm">Dibuat:</dt>
                        <dd class="col-sm-8 text-sm">{{ $post->created_at->format('d M Y H:i') }}</dd>
                        
                        <dt class="col-sm-4 text-sm">Diperbarui:</dt>
                        <dd class="col-sm-8 text-sm">{{ $post->updated_at->format('d M Y H:i') }}</dd>
                        
                        @if($post->published_at)
                            <dt class="col-sm-4 text-sm">Dipublikasi:</dt>
                            <dd class="col-sm-8 text-sm">{{ $post->published_at->format('d M Y H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Post
                        </a>
                        
                        @if($post->status === 'published')
                            <a href="{{ route('post.show', $post->slug) }}" class="btn btn-success" target="_blank">
                                <i class="bi bi-eye me-2"></i>Lihat di Website
                            </a>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="bi bi-trash me-2"></i>Hapus Post
                        </button>
                    </div>
                </div>
            </div>

            <!-- SEO Info -->
            @if($post->status === 'published')
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h6 class="m-0">Info SEO</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="mb-2">
                                <strong>URL:</strong><br>
                                <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="text-decoration-none">
                                    {{ route('post.show', $post->slug) }}
                                </a>
                            </div>
                            <div class="mb-2">
                                <strong>Judul untuk Search Engine:</strong><br>
                                <span class="text-muted">{{ $post->title }}</span>
                            </div>
                            <div>
                                <strong>Deskripsi:</strong><br>
                                <span class="text-muted">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 160) }}</span>
                            </div>
                        </div>
                    </div>
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
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                </div>
                <p>Apakah Anda yakin ingin menghapus post ini?</p>
                <div class="alert alert-warning">
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Post dan gambar terkait akan dihapus permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.post-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.post-content h1, .post-content h2, .post-content h3, 
.post-content h4, .post-content h5, .post-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-content p {
    margin-bottom: 1rem;
}

.post-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    border-radius: 0.375rem;
}

.post-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.post-content ul, .post-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.post-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush
