<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website resmi Kelurahan Marga Sari, Kota Balikpapan')">
    <meta name="keywords" content="@yield('meta_keywords', 'kelurahan, marga sari, balikpapan, layanan, berita, pengumuman')">
    
    <title>@yield('title', 'Kelurahan Marga Sari - Kota Balikpapan')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Running Text CSS -->
    <style>
        /* Running Text Animation */
        .running-text-container {
            width: 100%;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            background-color: #212529;
            transition: background-color 0.3s ease;
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000;
        }

        .running-text {
            display: inline-block;
            animation: marquee 45s linear infinite;
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1.5;
            will-change: transform;
        }

        .running-text-item {
            display: inline-block;
            margin-right: 4rem;
            white-space: nowrap;
        }

        .running-text-separator {
            margin: 0 2rem;
            color: #adb5bd;
            font-weight: bold;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100vw);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Pause animation on hover with smooth transition */
        .running-text-container:hover .running-text {
            animation-play-state: paused;
            cursor: pointer;
        }

        /* Smooth hover effect */

        .running-text-container:hover {
            background-color: #495057;
        }

        /* Icons styling in running text */
        .running-text .bi {
            color: #ffc107;
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Enhanced mobile styling */
        @media (max-width: 767px) {
            .running-text {
                animation: marquee 30s linear infinite;
                font-size: 0.75rem;
            }
            
            .running-text-item {
                margin-right: 2rem;
            }
            
            .running-text-separator {
                margin: 0 1rem;
            }
        }

    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white">
        <!-- Top Bar - Running Text (All Devices) -->
        <div class="bg-dark py-2 overflow-hidden">
            <div class="running-text-container">
                <div class="running-text">
                    <span class="running-text-item">
                        <i class="bi bi-envelope me-2"></i>Email: admin@margasari.id
                    </span>
                    <span class="running-text-separator">•</span>
                    <span class="running-text-item">
                        <i class="bi bi-telephone me-2"></i>Telepon: (0542) 123-456
                    </span>
                    <span class="running-text-separator">•</span>
                    <span class="running-text-item">
                        <i class="bi bi-clock me-2"></i>Jam Operasional: Senin - Jumat: 08:00 - 16:00
                    </span>
                    <span class="running-text-separator">•</span>
                    <span class="running-text-item">
                        <i class="bi bi-geo-alt me-2"></i>Alamat: Jl. Marga Sari No. 123, Balikpapan Barat
                    </span>
                    <span class="running-text-separator">•</span>
                    <span class="running-text-item">
                        <i class="bi bi-info-circle me-2"></i>Selamat datang di website resmi Kelurahan Marga Sari
                    </span>
                </div>
            </div>
        </div>

        
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="me-2" onerror="this.style.display='none'">
                    Kelurahan Marga Sari
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs(['news', 'announcements']) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Informasi
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('news') }}">Berita</a></li>
                                <li><a class="dropdown-item" href="{{ route('announcements') }}">Pengumuman</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rt.*') ? 'active' : '' }}" href="{{ route('rt.index') }}">Data RT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('complaint.*') ? 'active' : '' }}" href="{{ route('complaint.create') }}">Pengaduan</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus me-1"></i>Daftar
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                        </a></li>
                                    @elseif(Auth::user()->isKetuaRT())
                                        <li><a class="dropdown-item" href="{{ route('ketua-rt.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard Ketua RT
                                        </a></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">Kelurahan Marga Sari</h5>
                    <p class="text-light">
                        Melayani masyarakat dengan sepenuh hati untuk kemajuan bersama.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <div class="text-light">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            Jl. Marga Sari No. 123, Balikpapan Utara
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            (0542) 123-456
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            admin@margasari.id
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}" class="text-light text-decoration-none">Layanan</a></li>
                        <li class="mb-2"><a href="{{ route('news') }}" class="text-light text-decoration-none">Berita</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="bg-black py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <small>&copy; {{ date('Y') }} Kelurahan Marga Sari. All rights reserved.</small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small>Kota Balikpapan, Kalimantan Timur</small>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
