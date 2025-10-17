@extends('layouts.app')

@section('title', 'Pengaduan Berhasil Dikirim - Kelurahan Marga Sari')

@section('content')
<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center p-5">
                        <!-- Success Icon -->
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-check-lg fs-1"></i>
                        </div>

                        <!-- Success Message -->
                        <h2 class="fw-bold text-success mb-3">Pengaduan Berhasil Dikirim!</h2>
                        <p class="text-muted mb-4 fs-6">
                            Terima kasih atas partisipasi Anda dalam membangun Kelurahan Marga Sari yang lebih baik. 
                            Pengaduan Anda telah kami terima dan akan ditindaklanjuti oleh tim terkait.
                        </p>

                        <!-- What's Next -->
                        <div class="bg-light rounded p-4 mb-4">
                            <h5 class="fw-bold mb-3">Apa yang Terjadi Selanjutnya?</h5>
                            <div class="row text-start">
                                <div class="col-12 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                             style="width: 30px; height: 30px; font-size: 0.8rem;">1</div>
                                        <div>
                                            <strong>Verifikasi Tim</strong>
                                            <p class="mb-0 small text-muted">Tim admin akan memverifikasi dan mengkategorikan pengaduan Anda</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                             style="width: 30px; height: 30px; font-size: 0.8rem;">2</div>
                                        <div>
                                            <strong>Proses Penanganan</strong>
                                            <p class="mb-0 small text-muted">Pengaduan akan diteruskan ke unit kerja yang berwenang</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                             style="width: 30px; height: 30px; font-size: 0.8rem;">3</div>
                                        <div>
                                            <strong>Feedback & Update</strong>
                                            <p class="mb-0 small text-muted">Anda akan mendapat update perkembangan melalui kontak yang diberikan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Important Info -->
                        <div class="alert alert-info d-flex align-items-start" role="alert">
                            <i class="bi bi-info-circle me-2 mt-1"></i>
                            <div class="text-start">
                                <strong>Penting!</strong> 
                                Tim kami akan menghubungi Anda melalui kontak yang telah diberikan untuk memberikan update perkembangan pengaduan.
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="{{ route('complaint.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus me-2"></i>Buat Pengaduan Baru
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-house me-2"></i>Kembali ke Beranda
                            </a>
                        </div>

                        <!-- Contact Info -->
                        <div class="mt-5 pt-4 border-top">
                            <p class="small text-muted mb-2">
                                <strong>Butuh bantuan lebih lanjut?</strong>
                            </p>
                            <p class="small text-muted">
                                Hubungi kami di <strong>(0542) 123456</strong> atau email <strong>kelurahan@margasari.go.id</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 576px) {
    .card-body {
        padding: 2rem 1.5rem !important;
    }
    
    .d-flex.flex-column.flex-sm-row {
        flex-direction: column !important;
    }
    
    .d-flex.flex-column.flex-sm-row .btn {
        margin-bottom: 0.5rem;
    }
}

/* Animation for success icon */
@keyframes successPulse {
    0% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.bg-success.rounded-circle {
    animation: successPulse 0.6s ease-out;
}
</style>
@endpush
