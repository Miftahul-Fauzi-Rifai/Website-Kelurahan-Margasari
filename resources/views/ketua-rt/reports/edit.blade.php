@extends('layouts.ketua-rt')

@section('title', 'Edit Laporan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Laporan</h1>
            <p class="text-muted">Ubah laporan RT {{ Auth::user()->rt }}</p>
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
                    <h6 class="m-0 font-weight-bold text-success">Form Edit Laporan</h6>
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

                    <form action="{{ route('ketua-rt.reports.update', $report) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan Laporan <span class="text-danger">*</span></label>
                            <input type="month" class="form-control @error('month') is-invalid @enderror" 
                                   id="month" name="month" value="{{ old('month', $report->month) }}" required>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $report->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi/Ringkasan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $report->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="activities" class="form-label">Kegiatan yang Dilakukan</label>
                            <textarea class="form-control @error('activities') is-invalid @enderror" 
                                      id="activities" name="activities" rows="4">{{ old('activities', $report->activities) }}</textarea>
                            @error('activities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_residents" class="form-label">Total Warga</label>
                                <input type="number" class="form-control @error('total_residents') is-invalid @enderror" 
                                       id="total_residents" name="total_residents" 
                                       value="{{ old('total_residents', $report->total_residents) }}" min="0">
                                @error('total_residents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="total_households" class="form-label">Total KK</label>
                                <input type="number" class="form-control @error('total_households') is-invalid @enderror" 
                                       id="total_households" name="total_households" 
                                       value="{{ old('total_households', $report->total_households) }}" min="0">
                                @error('total_households')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="issues" class="form-label">Permasalahan yang Ada</label>
                            <textarea class="form-control @error('issues') is-invalid @enderror" 
                                      id="issues" name="issues" rows="3">{{ old('issues', $report->issues) }}</textarea>
                            @error('issues')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="suggestions" class="form-label">Saran/Usulan</label>
                            <textarea class="form-control @error('suggestions') is-invalid @enderror" 
                                      id="suggestions" name="suggestions" rows="3">{{ old('suggestions', $report->suggestions) }}</textarea>
                            @error('suggestions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">Lampiran (Opsional)</label>
                            @if($report->attachment)
                            <div class="mb-2">
                                <small class="text-muted">Lampiran saat ini: 
                                    <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank">Lihat File</a>
                                </small>
                            </div>
                            @endif
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" 
                                   id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Format: PDF, JPG, PNG. Maksimal 5MB. Kosongkan jika tidak ingin mengubah.</small>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Update Laporan
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

