@extends('layouts.ketua-rt')

@section('title', 'Buat Laporan Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Buat Laporan Baru</h1>
            <p class="text-muted">Laporan bulanan RT {{ Auth::user()->rt }}</p>
        </div>
        <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Form Laporan</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi Kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('ketua-rt.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan Laporan <span class="text-danger">*</span></label>
                            <input type="month" class="form-control @error('month') is-invalid @enderror" 
                                   id="month" name="month" value="{{ old('month', now()->format('Y-m')) }}" required>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Contoh: Laporan Kegiatan RT 01 Bulan Oktober 2025" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi/Ringkasan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required 
                                      placeholder="Tuliskan ringkasan kondisi lingkungan dan warga pada bulan ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: Kondisi lingkungan dan warga pada bulan ini baik</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kegiatan yang Dilakukan</label>
                            <small class="text-muted d-block mb-3">Isi setiap kegiatan dengan detail tanggal, uraian tugas, keterangan, dan foto (opsional)</small>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered" id="activities-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">NO</th>
                                            <th width="15%">TANGGAL</th>
                                            <th width="40%">URAIAN TUGAS</th>
                                            <th width="20%">KETERANGAN</th>
                                            <th width="20%">FOTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < 5; $i++)
                                            <tr class="activity-row">
                                                <td class="text-center align-middle row-number">{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="date" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][date]" 
                                                           value="{{ old('activities.'.$i.'.date') }}">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][task]" 
                                                           value="{{ old('activities.'.$i.'.task') }}"
                                                           placeholder="Contoh: Kerja bakti membersihkan lingkungan">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][note]" 
                                                           value="{{ old('activities.'.$i.'.note') }}"
                                                           placeholder="Opsional">
                                                </td>
                                                <td>
                                                    <input type="file" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $i }}][photo]"
                                                           accept="image/*">
                                                    <small class="text-muted">Max 2MB</small>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted d-block mt-2">Isi kegiatan yang ada saja, maksimal 5 kegiatan. Baris kosong akan diabaikan.</small>
                        </div>

                        <script>
                            // Script removed - fixed 5 rows only
                        </script>

                        <div class="mb-3">
                            <label for="issues" class="form-label">Permasalahan yang Ada</label>
                            <textarea class="form-control @error('issues') is-invalid @enderror" 
                                      id="issues" name="issues" rows="3" 
                                      placeholder="Tuliskan permasalahan atau kendala yang ada (jika ada)">{{ old('issues') }}</textarea>
                            @error('issues')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="suggestions" class="form-label">Saran/Usulan</label>
                            <textarea class="form-control @error('suggestions') is-invalid @enderror" 
                                      id="suggestions" name="suggestions" rows="3" 
                                      placeholder="Saran atau usulan untuk perbaikan">{{ old('suggestions') }}</textarea>
                            @error('suggestions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan sebagai Draft
                            </button>
                            <a href="{{ route('ketua-rt.reports.index') }}" class="btn btn-secondary">
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

