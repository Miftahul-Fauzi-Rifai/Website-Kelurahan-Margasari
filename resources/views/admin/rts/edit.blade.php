@extends('layouts.admin')

@section('title', 'Edit Data RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Data RT</h1>
            <p class="text-muted">Perbarui data RT {{ str_pad($rt->rt_code, 3, '0', STR_PAD_LEFT) }}</p>
        </div>
        <a href="{{ route('admin.rts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Data RT</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rts.update', $rt) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- RT Code -->
                        <div class="mb-3">
                            <label for="rt_code" class="form-label">Kode RT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('rt_code') is-invalid @enderror" 
                                   id="rt_code" 
                                   name="rt_code" 
                                   value="{{ old('rt_code', $rt->rt_code) }}"
                                   required>
                            @error('rt_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama RT</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $rt->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   value="{{ old('ketua_rt_name', $rt->ketua_rt_name) }}"
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
                                   value="{{ old('ketua_rt_phone', $rt->ketua_rt_phone) }}"
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
                                       value="{{ old('num_households', $rt->num_households) }}"
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
                                       value="{{ old('num_population', $rt->num_population) }}"
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
                                       value="{{ old('num_male', $rt->num_male) }}"
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
                                       value="{{ old('num_female', $rt->num_female) }}"
                                       min="0"
                                       required>
                                @error('num_female')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Location Data -->
                        <h6 class="text-primary mb-3">Koordinat Lokasi</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" 
                                       class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" 
                                       name="latitude" 
                                       value="{{ old('latitude', $rt->latitude) }}"
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
                                       value="{{ old('longitude', $rt->longitude) }}"
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
                                <i class="bi bi-save me-1"></i>Perbarui Data RT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <!-- RT Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="bi bi-info-circle me-2"></i>Informasi RT
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Kode RT:</strong></td>
                            <td>{{ str_pad($rt->rt_code, 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $rt->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Update Terakhir:</strong></td>
                            <td>{{ $rt->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="bi bi-lightbulb me-2"></i>Tips
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning small mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        <strong>Perhatian:</strong> Perubahan nama Ketua RT atau nomor telepon akan mempengaruhi informasi yang ditampilkan di website publik.
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

