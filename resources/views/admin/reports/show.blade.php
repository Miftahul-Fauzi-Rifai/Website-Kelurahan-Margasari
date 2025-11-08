@extends('layouts.admin')

@section('title', 'Detail Laporan RT')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan RT</h1>
            <p class="text-muted">RT {{ $report->rt_code }} - {{ $report->formatted_month }}</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Report Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                    <div>
                        {!! $report->status_badge !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">{{ $report->title }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> Dikirim: {{ $report->submitted_at ? $report->submitted_at->format('d F Y, H:i') : '-' }}
                        </small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Deskripsi</h6>
                        <p class="text-muted" style="white-space: pre-line;">{{ $report->description }}</p>
                    </div>

                    @if($report->activities)
                    <div class="mb-3">
                        <h6 class="font-weight-bold">Kegiatan yang Dilakukan</h6>
                        @php
                            $activities = json_decode($report->activities, true);
                            if (!is_array($activities)) {
                                // Fallback untuk format lama
                                $activities = [];
                            }
                        @endphp
                        @if(count($activities) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
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
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    @if(!empty($activity['date']))
                                                        {{ \Carbon\Carbon::parse($activity['date'])->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $activity['task'] ?? '-' }}</td>
                                                <td>{{ $activity['note'] ?? '-' }}</td>
                                                <td>
                                                    @if(!empty($activity['photo']))
                                                        <img src="{{ asset('storage/' . $activity['photo']) }}" 
                                                             alt="Foto Kegiatan" 
                                                             class="img-thumbnail" 
                                                             style="max-width: 100px; max-height: 80px; cursor: pointer;" 
                                                             data-bs-toggle="modal" 
                                                             data-bs-target="#photoModal{{ $index }}">
                                                        
                                                        <!-- Photo Modal -->
                                                        <div class="modal fade" id="photoModal{{ $index }}" tabindex="-1">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Foto Kegiatan #{{ $index + 1 }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset('storage/' . $activity['photo']) }}" 
                                                                             class="img-fluid" alt="Foto Kegiatan">
                                                                        <div class="mt-3 text-start">
                                                                            <p class="mb-1"><strong>Tanggal:</strong> {{ !empty($activity['date']) ? \Carbon\Carbon::parse($activity['date'])->format('d/m/Y') : '-' }}</p>
                                                                            <p class="mb-1"><strong>Uraian:</strong> {{ $activity['task'] ?? '-' }}</p>
                                                                            <p class="mb-0"><strong>Keterangan:</strong> {{ $activity['note'] ?? '-' }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada kegiatan</p>
                        @endif
                    </div>
                    @endif

                    @if($report->issues)
                    <div class="mb-3">
                        <h6 class="font-weight-bold">Permasalahan</h6>
                        <p class="text-muted" style="white-space: pre-line;">{{ $report->issues }}</p>
                    </div>
                    @endif

                    @if($report->suggestions)
                    <div class="mb-3">
                        <h6 class="font-weight-bold">Saran/Usulan</h6>
                        <p class="text-muted" style="white-space: pre-line;">{{ $report->suggestions }}</p>
                    </div>
                    @endif

                    @if($report->admin_notes)
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h6 class="font-weight-bold">Catatan Admin</h6>
                        <p class="mb-0" style="white-space: pre-line;">{{ $report->admin_notes }}</p>
                        @if($report->reviewed_at)
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-clock"></i> {{ $report->reviewed_at->format('d F Y, H:i') }}
                        </small>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- RT Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi RT</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>RT:</strong> {{ $report->rt_code }}
                    </div>
                    <div class="mb-2">
                        <strong>Ketua RT:</strong><br>
                        {{ $report->user->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Kontak:</strong><br>
                        {{ $report->user->phone ?? '-' }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $report->user->email }}
                    </div>
                    
                    <hr>
                    
                    <button type="button" class="btn btn-success btn-sm w-100 mb-2" onclick="printReport()">
                        <i class="bi bi-printer"></i> Cetak Laporan
                    </button>
                    
                    <a href="tel:{{ $report->user->phone ?? '' }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-telephone"></i> Hubungi Ketua RT
                    </a>
                </div>
            </div>

            <!-- Review Actions -->
            @if(in_array($report->status, ['submitted', 'reviewed']))
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Review Laporan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reports.update-status', $report) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="reviewed">Direview</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Berikan catatan atau feedback...">{{ $report->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Print Container (Hidden) -->
<div id="printContainer" style="display: none;">
    <div id="printContent"></div>
</div>
@endsection

@push('scripts')
<script>
function printReport() {
    // Show loading indicator
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memuat...';
    btn.disabled = true;
    
    // Fetch print content via AJAX
    fetch('{{ route('admin.reports.print', $report) }}')
        .then(response => response.text())
        .then(html => {
            // Create temporary iframe for printing
            const iframe = document.createElement('iframe');
            iframe.style.position = 'fixed';
            iframe.style.right = '0';
            iframe.style.bottom = '0';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = 'none';
            
            document.body.appendChild(iframe);
            
            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write(html);
            doc.close();
            
            // Wait for content to load then print
            iframe.onload = function() {
                setTimeout(() => {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                    
                    // Remove iframe after printing
                    setTimeout(() => {
                        document.body.removeChild(iframe);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    }, 100);
                }, 250);
            };
        })
        .catch(error => {
            console.error('Error loading print content:', error);
            alert('Gagal memuat konten cetak. Silakan coba lagi.');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        });
}
</script>
@endpush

@push('styles')
<style>
@media print {
    .btn, .modal, .sidebar, .card-header, nav { display: none !important; }
    .card { border: 1px solid #000 !important; box-shadow: none !important; }
    .col-lg-8 { width: 100% !important; }
}
</style>
@endpush

