@extends('layouts.admin')

@section('title', 'Tambah Ketua RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah Ketua RT</h1>
            <p class="text-muted">Buat akun baru untuk Ketua RT</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Ketua RT</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi Kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Section 1: Data RT -->
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-house-fill me-2"></i>Data RT
                        </h6>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="rt_code" class="form-label">Pilih RT <span class="text-danger">*</span></label>
                                <select class="form-select @error('rt_code') is-invalid @enderror" 
                                        id="rt_code" name="rt_code" required>
                                    <option value="">-- Pilih RT --</option>
                                    @foreach($rts as $rt)
                                        <option value="{{ $rt->rt_code }}" 
                                                data-name="{{ $rt->ketua_rt_name }}"
                                                data-phone="{{ $rt->ketua_rt_phone }}"
                                                {{ old('rt_code') == $rt->rt_code ? 'selected' : '' }}>
                                            RT {{ $rt->rt_code }} - {{ $rt->ketua_rt_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rt_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih RT terlebih dahulu, nama dan telepon akan otomatis terisi</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Ketua RT <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror bg-light" 
                                       id="name" name="name" value="{{ old('name') }}" required readonly>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Otomatis terisi dari data RT</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror bg-light" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required readonly>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Otomatis terisi dari data RT</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Section 2: Informasi Akun -->
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-person-lock me-2"></i>Informasi Akun Login
                        </h6>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email untuk Login <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Contoh: ketuart001@margasari.id" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required minlength="8">
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required minlength="8">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Section 3: Alamat -->
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-geo-alt me-2"></i>Alamat
                        </h6>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" 
                                          placeholder="Masukkan alamat lengkap Ketua RT" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Data
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-2">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="bi bi-info-circle me-2"></i>Panduan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p class="mb-2"><strong>Langkah-langkah:</strong></p>
                        <ol class="mb-0 ps-3">
                            <li class="mb-2">Pilih RT dari dropdown</li>
                            <li class="mb-2">Nama & telepon otomatis terisi</li>
                            <li class="mb-2">Isi email untuk login</li>
                            <li class="mb-2">Buat password</li>
                            <li>Isi alamat lengkap</li>
                        </ol>
                        
                        <hr class="my-3">
                        
                        <div class="alert alert-light border mb-0 p-2">
                            <small>
                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                <strong>Tips:</strong> Pastikan email unik dan mudah diingat oleh Ketua RT.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rtSelect = document.getElementById('rt_code');
    const nameInput = document.getElementById('name');
    const phoneInput = document.getElementById('phone');

    // Auto-fill saat RT dipilih
    rtSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const name = selectedOption.getAttribute('data-name');
            const phone = selectedOption.getAttribute('data-phone');
            
            nameInput.value = name;
            phoneInput.value = phone;
        } else {
            nameInput.value = '';
            phoneInput.value = '';
        }
    });

    // Trigger change jika ada old value (saat error validation)
    if (rtSelect.value) {
        rtSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

