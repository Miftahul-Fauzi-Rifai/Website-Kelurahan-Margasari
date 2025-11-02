@extends('layouts.admin')

@section('title', 'Isi Detail Data RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Data RT {{ str_pad($rt->rt_code, 3, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-muted">Lengkapi data detail RT untuk informasi yang lebih komprehensif</p>
        </div>
        <a href="{{ route('admin.rts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.rts.update-detail', $rt) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-6">
                <!-- Profil Ketua RT -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-person-badge me-2"></i>Profil Ketua RT
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Ketua RT</label>
                            <input type="text" class="form-control bg-light" value="{{ $rt->ketua_rt_name }}" readonly>
                        </div>

                        <!-- Upload Foto Ketua RT -->
                        <div class="mb-3">
                            <label class="form-label">Foto Ketua RT</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center mb-3">
                                        @if($rt->ketua_rt_photo)
                                            <img src="{{ asset('storage/' . $rt->ketua_rt_photo) }}" 
                                                 alt="Foto {{ $rt->ketua_rt_name }}" 
                                                 class="img-thumbnail"
                                                 id="current-photo"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="border rounded d-flex align-items-center justify-content-center bg-light" 
                                                 style="width: 150px; height: 150px; margin: 0 auto;">
                                                <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" class="form-control @error('ketua_rt_photo') is-invalid @enderror" 
                                           id="photo-input" name="ketua_rt_photo" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                                    @error('ketua_rt_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview & Cropper Area -->
                                    <div id="image-crop-container" class="mt-3" style="display: none;">
                                        <img id="image-crop" style="max-width: 100%;">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="crop-button">
                                                <i class="bi bi-check-circle"></i> Gunakan Foto Ini
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" id="cancel-crop">
                                                <i class="bi bi-x-circle"></i> Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="cropped_image" id="cropped-image">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ketua_rt_age" class="form-label">Usia (tahun)</label>
                                <input type="number" class="form-control @error('ketua_rt_age') is-invalid @enderror" 
                                       id="ketua_rt_age" name="ketua_rt_age" 
                                       value="{{ old('ketua_rt_age', $rt->ketua_rt_age) }}" 
                                       min="17" max="100" placeholder="45">
                                @error('ketua_rt_age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ketua_rt_profession" class="form-label">Profesi</label>
                                <input type="text" class="form-control @error('ketua_rt_profession') is-invalid @enderror" 
                                       id="ketua_rt_profession" name="ketua_rt_profession" 
                                       value="{{ old('ketua_rt_profession', $rt->ketua_rt_profession) }}" 
                                       placeholder="Wiraswasta">
                                @error('ketua_rt_profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ketua_rt_tenure_years" class="form-label">Masa Jabatan (tahun)</label>
                                <input type="number" class="form-control @error('ketua_rt_tenure_years') is-invalid @enderror" 
                                       id="ketua_rt_tenure_years" name="ketua_rt_tenure_years" 
                                       value="{{ old('ketua_rt_tenure_years', $rt->ketua_rt_tenure_years) }}" 
                                       min="0" max="50" placeholder="3">
                                @error('ketua_rt_tenure_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Mata Pencaharian -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-briefcase me-2"></i>Mata Pencaharian (dalam %)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pedagang" class="form-label">Pedagang</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="pedagang" name="pedagang" 
                                           value="{{ old('pedagang', $rt->mata_pencaharian['pedagang'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="25">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="karyawan" class="form-label">Karyawan</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="karyawan" name="karyawan" 
                                           value="{{ old('karyawan', $rt->mata_pencaharian['karyawan'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="40">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="buruh" class="form-label">Buruh</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="buruh" name="buruh" 
                                           value="{{ old('buruh', $rt->mata_pencaharian['buruh'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="20">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mata_pencaharian_lainnya" class="form-label">Lainnya</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="mata_pencaharian_lainnya" name="mata_pencaharian_lainnya" 
                                           value="{{ old('mata_pencaharian_lainnya', $rt->mata_pencaharian['lainnya'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="15">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted"><i class="bi bi-info-circle"></i> Total sebaiknya 100%</small>
                    </div>
                </div>

                <!-- Bantuan Sosial -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-heart me-2"></i>Bantuan Sosial (Jumlah KK)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="pkh" class="form-label">PKH</label>
                                <input type="number" class="form-control" id="pkh" name="pkh" 
                                       value="{{ old('pkh', $rt->bantuan_sosial['pkh'] ?? 0) }}" 
                                       min="0" placeholder="15">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="blt" class="form-label">BLT</label>
                                <input type="number" class="form-control" id="blt" name="blt" 
                                       value="{{ old('blt', $rt->bantuan_sosial['blt'] ?? 0) }}" 
                                       min="0" placeholder="20">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bantuan_lainnya" class="form-label">Lainnya</label>
                                <input type="number" class="form-control" id="bantuan_lainnya" name="bantuan_lainnya" 
                                       value="{{ old('bantuan_lainnya', $rt->bantuan_sosial['lainnya'] ?? 0) }}" 
                                       min="0" placeholder="5">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tingkat Pendidikan -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-mortarboard me-2"></i>Tingkat Pendidikan (dalam %)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lulusan_sd" class="form-label">SD</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="lulusan_sd" name="lulusan_sd" 
                                           value="{{ old('lulusan_sd', $rt->tingkat_pendidikan['sd'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="20">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lulusan_smp" class="form-label">SMP</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="lulusan_smp" name="lulusan_smp" 
                                           value="{{ old('lulusan_smp', $rt->tingkat_pendidikan['smp'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="25">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lulusan_sma" class="form-label">SMA</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="lulusan_sma" name="lulusan_sma" 
                                           value="{{ old('lulusan_sma', $rt->tingkat_pendidikan['sma'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="35">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lulusan_kuliah" class="form-label">Kuliah</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="lulusan_kuliah" name="lulusan_kuliah" 
                                           value="{{ old('lulusan_kuliah', $rt->tingkat_pendidikan['kuliah'] ?? 0) }}" 
                                           min="0" max="100" step="0.1" placeholder="20">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted"><i class="bi bi-info-circle"></i> Total sebaiknya 100%</small>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-6">
                <!-- Kegiatan Rutin -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-calendar-event me-2"></i>Kegiatan Rutin (per Bulan)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pengajian" class="form-label">Pengajian</label>
                                <select class="form-select" id="pengajian" name="pengajian">
                                    <option value="">-- Pilih Frekuensi --</option>
                                    <option value="kurang_dari_3" {{ old('pengajian', $rt->kegiatan_rutin['pengajian'] ?? '') == 'kurang_dari_3' ? 'selected' : '' }}>Kurang dari 3x</option>
                                    <option value="lebih_dari_3" {{ old('pengajian', $rt->kegiatan_rutin['pengajian'] ?? '') == 'lebih_dari_3' ? 'selected' : '' }}>Lebih dari 3x</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="posyandu" class="form-label">Posyandu</label>
                                <select class="form-select" id="posyandu" name="posyandu">
                                    <option value="">-- Pilih Frekuensi --</option>
                                    <option value="kurang_dari_3" {{ old('posyandu', $rt->kegiatan_rutin['posyandu'] ?? '') == 'kurang_dari_3' ? 'selected' : '' }}>Kurang dari 3x</option>
                                    <option value="lebih_dari_3" {{ old('posyandu', $rt->kegiatan_rutin['posyandu'] ?? '') == 'lebih_dari_3' ? 'selected' : '' }}>Lebih dari 3x</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kerja_bakti" class="form-label">Kerja Bakti</label>
                                <select class="form-select" id="kerja_bakti" name="kerja_bakti">
                                    <option value="">-- Pilih Frekuensi --</option>
                                    <option value="kurang_dari_3" {{ old('kerja_bakti', $rt->kegiatan_rutin['kerja_bakti'] ?? '') == 'kurang_dari_3' ? 'selected' : '' }}>Kurang dari 3x</option>
                                    <option value="lebih_dari_3" {{ old('kerja_bakti', $rt->kegiatan_rutin['kerja_bakti'] ?? '') == 'lebih_dari_3' ? 'selected' : '' }}>Lebih dari 3x</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kegiatan_lainnya" class="form-label">Lainnya</label>
                                <select class="form-select" id="kegiatan_lainnya" name="kegiatan_lainnya">
                                    <option value="">-- Pilih Frekuensi --</option>
                                    <option value="kurang_dari_3" {{ old('kegiatan_lainnya', $rt->kegiatan_rutin['lainnya'] ?? '') == 'kurang_dari_3' ? 'selected' : '' }}>Kurang dari 3x</option>
                                    <option value="lebih_dari_3" {{ old('kegiatan_lainnya', $rt->kegiatan_rutin['lainnya'] ?? '') == 'lebih_dari_3' ? 'selected' : '' }}>Lebih dari 3x</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fasilitas Umum -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-buildings me-2"></i>Fasilitas Umum
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="masjid" class="form-label">Masjid</label>
                                <input type="number" class="form-control" id="masjid" name="masjid" 
                                       value="{{ old('masjid', $rt->fasilitas_umum['masjid'] ?? 0) }}" 
                                       min="0" placeholder="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="musholla" class="form-label">Musholla</label>
                                <input type="number" class="form-control" id="musholla" name="musholla" 
                                       value="{{ old('musholla', $rt->fasilitas_umum['musholla'] ?? 0) }}" 
                                       min="0" placeholder="2">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="posyandu_count" class="form-label">Posyandu</label>
                                <input type="number" class="form-control" id="posyandu_count" name="posyandu_count" 
                                       value="{{ old('posyandu_count', $rt->fasilitas_umum['posyandu'] ?? 0) }}" 
                                       min="0" placeholder="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bank_sampah" class="form-label">Bank Sampah</label>
                                <input type="number" class="form-control" id="bank_sampah" name="bank_sampah" 
                                       value="{{ old('bank_sampah', $rt->fasilitas_umum['bank_sampah'] ?? 0) }}" 
                                       min="0" placeholder="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pos_ronda" class="form-label">Pos Ronda</label>
                                <input type="number" class="form-control" id="pos_ronda" name="pos_ronda" 
                                       value="{{ old('pos_ronda', $rt->fasilitas_umum['pos_ronda'] ?? 0) }}" 
                                       min="0" placeholder="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fasum_lainnya" class="form-label">Lainnya</label>
                                <input type="text" class="form-control" id="fasum_lainnya" name="fasum_lainnya" 
                                       value="{{ old('fasum_lainnya', $rt->fasilitas_umum['lainnya'] ?? '') }}" 
                                       placeholder="Lapangan, dll">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kondisi Infrastruktur -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-hammer me-2"></i>Kondisi Infrastruktur
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kondisi_jalan" class="form-label">Jalan</label>
                            <select class="form-select" id="kondisi_jalan" name="kondisi_jalan">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ old('kondisi_jalan', $rt->kondisi_infrastruktur['jalan'] ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="sedang" {{ old('kondisi_jalan', $rt->kondisi_infrastruktur['jalan'] ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="buruk" {{ old('kondisi_jalan', $rt->kondisi_infrastruktur['jalan'] ?? '') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kondisi_saluran_air" class="form-label">Saluran Air</label>
                            <select class="form-select" id="kondisi_saluran_air" name="kondisi_saluran_air">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ old('kondisi_saluran_air', $rt->kondisi_infrastruktur['saluran_air'] ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="sedang" {{ old('kondisi_saluran_air', $rt->kondisi_infrastruktur['saluran_air'] ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="buruk" {{ old('kondisi_saluran_air', $rt->kondisi_infrastruktur['saluran_air'] ?? '') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kondisi_penerangan" class="form-label">Penerangan</label>
                            <select class="form-select" id="kondisi_penerangan" name="kondisi_penerangan">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ old('kondisi_penerangan', $rt->kondisi_infrastruktur['penerangan'] ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="sedang" {{ old('kondisi_penerangan', $rt->kondisi_infrastruktur['penerangan'] ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="buruk" {{ old('kondisi_penerangan', $rt->kondisi_infrastruktur['penerangan'] ?? '') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Masalah Lingkungan -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="bi bi-exclamation-triangle me-2"></i>Masalah Lingkungan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="masalah_banjir" name="masalah_banjir" 
                                   value="1" {{ old('masalah_banjir', $rt->masalah_lingkungan['banjir'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="masalah_banjir">
                                <i class="bi bi-droplet text-primary"></i> Rawan Banjir
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="masalah_sampah" name="masalah_sampah" 
                                   value="1" {{ old('masalah_sampah', $rt->masalah_lingkungan['sampah'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="masalah_sampah">
                                <i class="bi bi-trash text-warning"></i> Masalah Sampah
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save me-2"></i>Simpan Data Detail
                        </button>
                        <a href="{{ route('admin.rts.index') }}" class="btn btn-secondary btn-lg px-5 ms-2">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@push('scripts')
<!-- Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo-input');
    const imageCropContainer = document.getElementById('image-crop-container');
    const imageCrop = document.getElementById('image-crop');
    const cropButton = document.getElementById('crop-button');
    const cancelCrop = document.getElementById('cancel-crop');
    const croppedImageInput = document.getElementById('cropped-image');
    const currentPhoto = document.getElementById('current-photo');
    
    let cropper = null;

    // Ketika file dipilih
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                photoInput.value = '';
                return;
            }

            // Validasi tipe file
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar!');
                photoInput.value = '';
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(event) {
                // Tampilkan container cropper
                imageCropContainer.style.display = 'block';
                imageCrop.src = event.target.result;
                
                // Destroy cropper lama jika ada
                if (cropper) {
                    cropper.destroy();
                }
                
                // Initialize Cropper
                cropper = new Cropper(imageCrop, {
                    aspectRatio: 1, // Rasio 1:1 untuk foto profil
                    viewMode: 2,
                    minContainerWidth: 300,
                    minContainerHeight: 300,
                    autoCropArea: 1,
                    responsive: true,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Ketika tombol crop diklik
    cropButton.addEventListener('click', function() {
        if (cropper) {
            // Dapatkan canvas hasil crop
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            // Konversi canvas ke base64
            const croppedImage = canvas.toDataURL('image/jpeg', 0.9);
            
            // Simpan ke hidden input
            croppedImageInput.value = croppedImage;
            
            // Update preview foto
            if (currentPhoto) {
                currentPhoto.src = croppedImage;
            } else {
                // Jika belum ada foto, buat element baru
                const photoContainer = document.querySelector('.text-center.mb-3');
                photoContainer.innerHTML = `
                    <img src="${croppedImage}" 
                         alt="Preview" 
                         class="img-thumbnail"
                         id="current-photo"
                         style="width: 150px; height: 150px; object-fit: cover;">
                `;
            }
            
            // Sembunyikan cropper
            imageCropContainer.style.display = 'none';
            
            // Destroy cropper
            cropper.destroy();
            cropper = null;
            
            // Success message
            alert('Foto berhasil dipilih! Jangan lupa klik "Simpan Data Detail" untuk menyimpan perubahan.');
        }
    });

    // Ketika tombol batal diklik
    cancelCrop.addEventListener('click', function() {
        // Reset input file
        photoInput.value = '';
        
        // Sembunyikan container cropper
        imageCropContainer.style.display = 'none';
        
        // Destroy cropper
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });
});
</script>
@endpush

