@extends('layouts.admin')

@section('title', 'Tambah RT Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah RT Baru</h1>
            <p class="text-muted">Tambahkan data Rukun Tetangga baru</p>
        </div>
        <a href="{{ route('admin.rts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Form Data RT</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rts.store') }}" method="POST">
                        @csrf

                        <!-- RT Code -->
                        <div class="mb-3">
                            <label for="rt_code" class="form-label">Kode RT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('rt_code') is-invalid @enderror" 
                                   id="rt_code" 
                                   name="rt_code" 
                                   value="{{ old('rt_code') }}"
                                   placeholder="Contoh: 01 atau 1"
                                   required>
                            @error('rt_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: 01, 02, 03, dst (2 digit)</small>
                        </div>

                        <!-- Name (Optional) -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama RT (Opsional)</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Akan otomatis dibuat jika dikosongkan">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Contoh: RT 001 atau RT Melati</small>
                        </div>

                        <hr>

                        <!-- Ketua RT Info -->
                        <h6 class="text-primary mb-3">Informasi Ketua RT</h6>

                        <div class="mb-3">
                            <label for="ketua_rt_name" class="form-label">Nama Ketua RT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('ketua_rt_name') is-invalid @enderror" 
                                   id="ketua_rt_name" 
                                   name="ketua_rt_name" 
                                   value="{{ old('ketua_rt_name') }}"
                                   required>
                            @error('ketua_rt_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ketua_rt_phone" class="form-label">No. Telepon Ketua RT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('ketua_rt_phone') is-invalid @enderror" 
                                   id="ketua_rt_phone" 
                                   name="ketua_rt_phone" 
                                   value="{{ old('ketua_rt_phone') }}"
                                   placeholder="Contoh: 0812-3456-7890"
                                   required>
                            @error('ketua_rt_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Population Data -->
                        <h6 class="text-primary mb-3">Data Penduduk</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="num_households" class="form-label">Jumlah KK <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('num_households') is-invalid @enderror" 
                                       id="num_households" 
                                       name="num_households" 
                                       value="{{ old('num_households', 0) }}"
                                       min="0"
                                       required>
                                @error('num_households')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="num_population" class="form-label">Total Populasi <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('num_population') is-invalid @enderror" 
                                       id="num_population" 
                                       name="num_population" 
                                       value="{{ old('num_population', 0) }}"
                                       min="0"
                                       required>
                                @error('num_population')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="num_male" class="form-label">Laki-laki <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('num_male') is-invalid @enderror" 
                                       id="num_male" 
                                       name="num_male" 
                                       value="{{ old('num_male', 0) }}"
                                       min="0"
                                       required>
                                @error('num_male')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="num_female" class="form-label">Perempuan <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('num_female') is-invalid @enderror" 
                                       id="num_female" 
                                       name="num_female" 
                                       value="{{ old('num_female', 0) }}"
                                       min="0"
                                       required>
                                @error('num_female')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Location Data -->
                        <h6 class="text-primary mb-3">Koordinat Lokasi (Opsional)</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" 
                                       class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" 
                                       name="latitude" 
                                       value="{{ old('latitude') }}"
                                       placeholder="Contoh: -1.2379">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" 
                                       class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" 
                                       name="longitude" 
                                       value="{{ old('longitude') }}"
                                       placeholder="Contoh: 116.8289">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.rts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Data RT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Panduan
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="text-primary">Tips Pengisian:</h6>
                    <ul class="small">
                        <li>Kode RT harus unik</li>
                        <li>Format kode RT: 001, 002, 003, dst</li>
                        <li>Pastikan nama dan nomor telepon Ketua RT benar</li>
                        <li>Jumlah Laki-laki + Perempuan harus sama dengan Total Populasi</li>
                        <li>Koordinat dapat diambil dari Google Maps</li>
                    </ul>

                    <hr>

                    <h6 class="text-primary">Cara Mendapatkan Koordinat:</h6>
                    <ol class="small">
                        <li>Buka Google Maps</li>
                        <li>Klik kanan pada lokasi RT</li>
                        <li>Pilih "What's here?"</li>
                        <li>Copy koordinat yang muncul</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto calculate total population
    const numMale = document.getElementById('num_male');
    const numFemale = document.getElementById('num_female');
    const numPopulation = document.getElementById('num_population');

    function updateTotal() {
        const male = parseInt(numMale.value) || 0;
        const female = parseInt(numFemale.value) || 0;
        numPopulation.value = male + female;
    }

    numMale.addEventListener('input', updateTotal);
    numFemale.addEventListener('input', updateTotal);
});
</script>
@endpush

