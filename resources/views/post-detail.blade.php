@extends('layouts.app')

@section('title', $post->title . ' - Kelurahan Marga Sari')
@section('meta_description', $post->excerpt ?: Str::limit(strip_tags($post->content), 160))

@section('content')
<section class="bg-light py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ $post->type === 'berita' ? route('news') : route('announcements') }}">
                        {{ $post->type === 'berita' ? 'Berita' : 'Pengumuman' }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-5">
    <div class="container">
        <!-- Back Navigation -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ $post->type === 'berita' ? route('news') : route('announcements') }}" 
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke {{ $post->type === 'berita' ? 'Berita' : 'Pengumuman' }}
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Article Header -->
                <div class="mb-4">
                    <div class="mb-3">
                        <span class="badge bg-{{ $post->type === 'berita' ? 'primary' : 'success' }} me-2">
                            {{ $post->type === 'berita' ? 'Berita' : 'Pengumuman' }}
                        </span>
                        @if($post->type === 'pengumuman' && ($post->priority ?? false))
                            <span class="badge bg-danger">PENTING</span>
                        @endif
                    </div>
                    
                    <h1 class="display-6 fw-bold mb-3">{{ $post->title }}</h1>
                    
                    <div class="d-flex flex-wrap align-items-center text-muted mb-4">
                        @if($post->user)
                        <div class="me-4 mb-2">
                            <i class="bi bi-person me-1"></i>{{ $post->user->name }}
                        </div>
                        @endif
                        <div class="me-4 mb-2">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $post->published_at ? $post->published_at->format('d F Y, H:i') : $post->created_at->format('d F Y, H:i') }}
                        </div>
                        <div class="me-4 mb-2">
                            <i class="bi bi-eye me-1"></i>{{ number_format($post->views) }} views
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($post->featured_image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         class="img-fluid rounded shadow-sm w-100" 
                         alt="{{ $post->title }}" 
                         style="max-height: 400px; object-fit: cover;">
                </div>
                @endif

                <!-- Article Content -->
                <div class="article-content mb-5">
                    @if($post->excerpt)
                    <div class="lead text-muted mb-4 p-3 bg-light rounded">
                        {{ $post->excerpt }}
                    </div>
                    @endif
                    
                    <div class="content">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Share Buttons -->
                <div class="border-top border-bottom py-4 mb-5">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
                        <div class="mb-3 mb-sm-0">
                            <h6 class="mb-2">Bagikan artikel ini:</h6>
                            <div class="btn-group" role="group">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                                   target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" 
                                   target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                    <i class="bi bi-link-45deg"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-printer me-1"></i>Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // You could add a toast notification here
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}
</script>
@endpush

@push('styles')
<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content h1, .article-content h2, .article-content h3, 
.article-content h4, .article-content h5, .article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Handle base64 and inline images */
.article-content p img {
    display: block;
    margin: 1rem auto;
    max-width: 100%;
    height: auto;
}

.article-content blockquote {
    border-left: 4px solid #0d6efd;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}

.btn-group .btn {
    margin-right: 0;
}

@media print {
    .btn, nav, .border-top.border-bottom, .row.mt-5:last-child {
        display: none !important;
    }
    
    .container {
        width: 100% !important;
        max-width: none !important;
    }
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .article-content {
        font-size: 1rem;
    }
    
    .d-flex.flex-column.flex-sm-row {
        flex-direction: column !important;
    }
    
    .btn-group {
        display: flex;
        flex-wrap: wrap;
    }
}
</style>
@endpush
