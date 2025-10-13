@extends('layouts.app')

@section('title', 'Tentang Kami - Kelurahan Marga Sari')
@section('meta_description', 'Profil dan sejarah Kelurahan Marga Sari, Kota Balikpapan. Visi, misi, dan struktur organisasi kelurahan.')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold">Tentang Kelurahan Marga Sari</h1>
                <p class="lead">Mengenal lebih dekat profil, sejarah, visi misi, dan struktur organisasi Kelurahan Marga Sari</p>
            </div>
        </div>
    </div>
</section>

<!-- Profile Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h2 class="fw-bold mb-4">Profil Kelurahan</h2>
                <p class="text-muted mb-4">
                    Kelurahan Marga Sari merupakan salah satu kelurahan yang berada di wilayah Kecamatan Balikpapan Utara, 
                    Kota Balikpapan, Provinsi Kalimantan Timur. Kelurahan ini memiliki luas wilayah sekitar 15,2 km² 
                    dengan jumlah penduduk lebih dari 12.500 jiwa.
                </p>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Luas Wilayah</h6>
                                <small class="text-muted">15,2 km²</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle p-3 me-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Jumlah Penduduk</h6>
                                <small class="text-muted">12.500+ jiwa</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-white rounded-circle p-3 me-3">
                                <i class="bi bi-house"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Jumlah RT</h6>
                                <small class="text-muted">15 RT</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning text-white rounded-circle p-3 me-3">
                                <i class="bi bi-houses"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Jumlah RW</h6>
                                <small class="text-muted">5 RW</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/kelurahan-building.jpg') }}" 
                     alt="Kantor Kelurahan Marga Sari" 
                     class="img-fluid rounded shadow"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDUwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjUwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmOGY5ZmEiLz48dGV4dCB4PSIyNTAiIHk9IjE1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE4IiBmaWxsPSIjNjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5LYW50b3IgS2VsdXJhaGFuPC90ZXh0Pjwvc3ZnPg=='">
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Visi & Misi</h2>
            <p class="text-muted">Arah dan tujuan pembangunan Kelurahan Marga Sari</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="text-primary mb-4">
                            <i class="bi bi-eye" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-4">Visi</h4>
                        <p class="text-muted">
                            "Mewujudkan Kelurahan Marga Sari yang Maju, Sejahtera, dan Berkarakter 
                            melalui Pelayanan Prima dan Pemberdayaan Masyarakat"
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="text-success mb-4">
                                <i class="bi bi-target" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="fw-bold text-success mb-4">Misi</h4>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Meningkatkan kualitas pelayanan publik yang prima
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Memberdayakan ekonomi masyarakat lokal
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Menjaga keamanan dan ketertiban lingkungan
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Meningkatkan partisipasi masyarakat dalam pembangunan
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Melestarikan budaya dan lingkungan hidup
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Organization Structure -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Struktur Organisasi</h2>
            <p class="text-muted">Pimpinan dan staf Kelurahan Marga Sari</p>
        </div>
        
        <div class="row justify-content-center">
            <!-- Lurah -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-primary mx-auto d-flex align-items-center justify-content-center text-white" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold">Drs. Ahmad Wijaya, M.Si</h5>
                        <p class="text-primary fw-bold mb-2">Lurah</p>
                        <small class="text-muted">
                            Memimpin dan mengkoordinasikan seluruh kegiatan pemerintahan kelurahan
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Sekretaris -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-success mx-auto d-flex align-items-center justify-content-center text-white" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold">Siti Nurhaliza, S.Sos</h6>
                        <p class="text-success fw-bold mb-2 small">Sekretaris Kelurahan</p>
                        <small class="text-muted">
                            Mengelola administrasi dan kesekretariatan kelurahan
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Kasi Pemerintahan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-info mx-auto d-flex align-items-center justify-content-center text-white" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold">Bambang Sutrisno, S.AP</h6>
                        <p class="text-info fw-bold mb-2 small">Kasi Pemerintahan</p>
                        <small class="text-muted">
                            Mengelola urusan pemerintahan dan kependudukan
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Kasi Kesejahteraan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-warning mx-auto d-flex align-items-center justify-content-center text-white" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold">Dr. Maya Sari, S.KM</h6>
                        <p class="text-warning fw-bold mb-2 small">Kasi Kesejahteraan</p>
                        <small class="text-muted">
                            Mengelola program kesejahteraan masyarakat
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Kasi Ekonomi -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="rounded-circle bg-danger mx-auto d-flex align-items-center justify-content-center text-white" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold">Rudi Hartono, S.E</h6>
                        <p class="text-danger fw-bold mb-2 small">Kasi Ekonomi</p>
                        <small class="text-muted">
                            Mengelola pemberdayaan ekonomi masyarakat
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-4">Hubungi Kami</h2>
                <p class="lead mb-4">
                    Kami siap melayani Anda dengan sepenuh hati. Jangan ragu untuk menghubungi kami 
                    untuk berbagai keperluan administrasi dan pelayanan publik.
                </p>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="bi bi-geo-alt display-6 mb-3"></i>
                            <h5>Alamat</h5>
                            <p>Jl. Marga Sari No. 123<br>Balikpapan Utara, Balikpapan</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="bi bi-telephone display-6 mb-3"></i>
                            <h5>Telepon</h5>
                            <p>(0542) 123-456<br>0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="bi bi-envelope display-6 mb-3"></i>
                            <h5>Email</h5>
                            <p>admin@margasari.id<br>info@margasari.id</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('complaint.create') }}" class="btn btn-warning btn-lg px-4">
                        <i class="bi bi-envelope me-2"></i>Kirim Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
