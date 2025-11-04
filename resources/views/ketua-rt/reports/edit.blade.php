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
                            <small class="text-muted">Tuliskan ringkasan kondisi lingkungan dan warga pada bulan ini</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kegiatan yang Dilakukan</label>
                            <small class="text-muted d-block mb-3">Isi setiap kegiatan dengan detail tanggal, uraian tugas, keterangan, dan foto (opsional)</small>
                            
                            @php
                                $activities = $report->activities ? json_decode($report->activities, true) : [];
                                if (!is_array($activities)) {
                                    // Fallback untuk format lama (string)
                                    $activitiesText = explode("\n", trim($report->activities));
                                    $activities = [];
                                    foreach($activitiesText as $act) {
                                        if(trim($act)) {
                                            $activities[] = ['date' => '', 'task' => trim($act), 'note' => '', 'photo' => ''];
                                        }
                                    }
                                }
                                // Batasi maksimal 5 kegiatan
                                $activities = array_slice($activities, 0, 5);
                                // Pastikan minimal ada 5 slot
                                while(count($activities) < 5) {
                                    $activities[] = ['date' => '', 'task' => '', 'note' => '', 'photo' => ''];
                                }
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered" id="activities-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">NO</th>
                                            <th width="15%">TANGGAL</th>
                                            <th width="35%">URAIAN TUGAS</th>
                                            <th width="20%">KETERANGAN</th>
                                            <th width="25%">FOTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activities as $index => $activity)
                                            <tr class="activity-row">
                                                <td class="text-center align-middle row-number">{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="date" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $index }}][date]" 
                                                           value="{{ old('activities.'.$index.'.date', $activity['date'] ?? '') }}">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $index }}][task]" 
                                                           value="{{ old('activities.'.$index.'.task', $activity['task'] ?? '') }}"
                                                           placeholder="Contoh: Kerja bakti membersihkan lingkungan">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $index }}][note]" 
                                                           value="{{ old('activities.'.$index.'.note', $activity['note'] ?? '') }}"
                                                           placeholder="Opsional">
                                                </td>
                                                <td>
                                                    @if(!empty($activity['photo']))
                                                        <div class="mb-1">
                                                            <a href="{{ asset('storage/' . $activity['photo']) }}" target="_blank" class="text-primary">
                                                                <i class="bi bi-image"></i> Lihat Foto
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <input type="file" 
                                                           class="form-control form-control-sm" 
                                                           name="activities[{{ $index }}][photo]"
                                                           accept="image/*">
                                                    <small class="text-muted">Max 2MB</small>
                                                    @if(!empty($activity['photo']))
                                                        <input type="hidden" name="activities[{{ $index }}][photo_old]" value="{{ $activity['photo'] }}">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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

