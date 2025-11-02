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
        <div class="col-lg-8">
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

                        <div class="mb-3">
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

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Ketua RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror bg-light" 
                                   id="name" name="name" value="{{ old('name') }}" required readonly>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Otomatis terisi dari data RT</small>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror bg-light" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required readonly>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Otomatis terisi dari data RT</small>
                        </div>

                        <hr>

                        <h6 class="text-primary mb-3">Informasi Akun Login</h6>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email untuk Login <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Contoh: ketuart001@margasari.id" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
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

                        <hr>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                Batal
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

