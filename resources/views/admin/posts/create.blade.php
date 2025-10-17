@extends('layouts.admin')

@section('title', 'Buat Post Baru - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Buat Post Baru</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                    <li class="breadcrumb-item active">Buat Baru</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Create Form -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Post Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Ringkasan</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" 
                                      placeholder="Ringkasan singkat post (opsional)">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maksimal 500 karakter. Jika kosong, akan diambil dari konten otomatis.</div>
                        </div>

                        <!-- Content with WYSIWYG Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div class="mb-4">
                            <label for="featured_image" class="form-label">Gambar Utama</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih gambar utama untuk post (JPG, PNG, GIF, maksimal 2MB)
                            </div>
                        </div>

                        <div class="row">
                            <!-- Type -->
                            <div class="col-md-3 mb-3">
                                <label for="type" class="form-label">Tipe <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="berita" {{ old('type') == 'berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="pengumuman" {{ old('type') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Terbitkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Published Date -->
                            <div class="col-md-6 mb-3">
                                <label for="published_at" class="form-label">Tanggal Terbit</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                       id="published_at" name="published_at" value="{{ old('published_at') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan untuk menggunakan waktu saat ini (jika status: Terbitkan)</div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary" id="saveBtn">
                                    <i class="bi bi-check me-2"></i>Simpan Post
                                </button>
                                <button type="button" class="btn btn-success" id="saveAndNewBtn" onclick="saveAndNew()">
                                    <i class="bi bi-plus me-2"></i>Simpan & Buat Baru
                                </button>
                            </div>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveAndNew() {
    // Add hidden input to indicate save and new action
    const form = document.querySelector('form');
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'save_and_new';
    hiddenInput.value = '1';
    form.appendChild(hiddenInput);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, form ready');
    
    // Make sure buttons are enabled
    const submitButtons = document.querySelectorAll('button');
    submitButtons.forEach(button => {
        button.disabled = false;
    });
    
    // Form validation before submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const content = document.getElementById('content').value.trim();
        const type = document.getElementById('type').value;
        const status = document.getElementById('status').value;
        
        if (!title) {
            alert('Judul wajib diisi!');
            e.preventDefault();
            return false;
        }
        
        if (!content) {
            alert('Konten wajib diisi!');
            e.preventDefault();
            return false;
        }
        
        if (!type) {
            alert('Tipe wajib dipilih!');
            e.preventDefault();
            return false;
        }
        
        if (!status) {
            alert('Status wajib dipilih!');
            e.preventDefault();
            return false;
        }
        
        // Disable submit button to prevent double submission
        const submitBtn = document.getElementById('saveBtn');
        if (submitBtn && e.submitter === submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...';
        }
        
        console.log('Form validation passed, submitting...');
        return true;
    });
});
</script>
@endpush

@push('styles')
<style>
.ck-editor__editable {
    min-height: 300px;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}
</style>
@endpush