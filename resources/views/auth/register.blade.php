@extends('layouts.app')

@section('title', 'Daftar - Kelurahan Marga Sari')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Daftar Akun Baru
                    </h4>
                    <p class="mb-0 mt-2 opacity-75">Bergabung dengan sistem informasi kelurahan</p>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="bi bi-telephone me-1"></i>No. Telepon
                                </label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="rt" class="form-label">
                                    <i class="bi bi-house me-1"></i>RT <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('rt') is-invalid @enderror" id="rt" name="rt" required>
                                    <option value="">Pilih RT</option>
                                    @for($i = 1; $i <= 15; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" {{ old('rt') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="rw" class="form-label">
                                    <i class="bi bi-houses me-1"></i>RW <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('rw') is-invalid @enderror" id="rw" name="rw" required>
                                    <option value="">Pilih RW</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" {{ old('rw') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap Anda"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary">syarat dan ketentuan</a> yang berlaku
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </button>
                    </form>
                </div>
                
                <div class="card-footer text-center py-3 bg-light">
                    <p class="mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        if (type === 'password') {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    });

    // Phone number formatting
    const phoneField = document.getElementById('phone');
    phoneField.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('0')) {
            e.target.value = value;
        } else if (value.startsWith('8')) {
            e.target.value = '0' + value;
        }
    });
});
</script>
@endpush
