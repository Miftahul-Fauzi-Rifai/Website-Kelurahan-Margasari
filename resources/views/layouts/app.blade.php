<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="@yield('meta_description', 'Website resmi Kelurahan Marga Sari, Kota Balikpapan')">
    <meta name="keywords" content="@yield('meta_keywords', 'kelurahan, marga sari, balikpapan, layanan, berita, pengumuman')">
    
    <title>@yield('title', 'Kelurahan Marga Sari - Kota Balikpapan')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- White Header Styling -->
    <style>
        /* White navbar styling */
        .navbar-light .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: 500;
        }
        
        .navbar-light .navbar-nav .nav-link:hover,
        .navbar-light .navbar-nav .nav-link:focus {
            color: #007bff !important;
        }
        
        .navbar-light .navbar-nav .nav-link.active {
            color: #007bff !important;
            font-weight: 600;
        }
        
        .navbar-light .navbar-toggler {
            border-color: rgba(0,0,0,.1);
        }
        
        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Dropdown styling for white navbar */
        .navbar-light .navbar-nav .dropdown-menu {
            border: 1px solid #dee2e6;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .navbar-light .navbar-nav .dropdown-item {
            color: #333;
        }
        
        .navbar-light .navbar-nav .dropdown-item:hover,
        .navbar-light .navbar-nav .dropdown-item:focus {
            background-color: #f8f9fa;
            color: #007bff;
        }
        
        /* Header shadow */
        header.bg-white {
            border-bottom: 1px solid #e9ecef;
        }
        
        /* Sticky Header Styling */
        .navbar-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Mobile navbar behavior */
        @media (max-width: 991px) {
            .navbar-sticky {
                transform: translateY(0);
                transition: transform 0.3s ease;
            }
            
            .navbar-sticky.navbar-hidden {
                transform: translateY(-100%);
            }
            
            .navbar-sticky.navbar-visible {
                transform: translateY(0);
            }
        }
        
        /* Hide navbar initially on mobile for hero section */
        @media (max-width: 767px) {
            .navbar-sticky {
                transform: translateY(-100%);
            }
        }
        
        /* Scrolled state - transparent background */
        .navbar-sticky.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* Mobile Navbar: Hidden at top, Show on scroll */
        @media (max-width: 767px) {
            .navbar-sticky {
                transform: translateY(-100%);
                transition: transform 0.3s ease, background-color 0.3s ease;
            }
            
            .navbar-sticky.show-on-scroll {
                transform: translateY(0);
                background-color: rgba(255, 255, 255, 0.95) !important;
                backdrop-filter: blur(10px);
                box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15) !important;
            }
        }
        
        /* No body padding - let content flow naturally under fixed header */
        
        /* Smooth transitions for all navbar elements */
        .navbar-sticky .navbar-brand,
        .navbar-sticky .nav-link {
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 60px;             /* besarin logo */
            width: auto;
            transition: transform 0.3s ease;
            margin-top: 0px;         /* geser sedikit biar pas tengah */
        }

        .navbar {
            line-height: 1.2;         /* jaga agar navbar gak makin tinggi */
            padding-top: 0px;
            padding-bottom: 0px;
        }

        /* Efek hover biar elegan */
        .navbar-brand img:hover {
            transform: scale(1.05);
        }

        /* Responsif di HP: kecilin dikit */
        @media (max-width: 768px) {
            .navbar-brand img {
                height: 38px;
                margin-top: -3px;
            }
        }
    </style>
    
    <!-- Chatbot CSS -->
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    
    <!-- Chatbot Configuration -->
    <script>
        window.CHATBOT_CONFIG = {
            apiUrl: '{{ config('chatbot.api_url') }}',
            enabled: {{ config('chatbot.enabled') ? 'true' : 'false' }},
            timeout: {{ config('chatbot.timeout') }}
        };
    </script>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="bg-white shadow-sm navbar-sticky" id="mainHeader">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand fw-bold text-dark d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-Balikpapan.png') }}" alt="Logo Kelurahan" width="38" height="38" class="me-2">
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

    <!-- Chatbot Widget (Non-intrusive Integration) -->
    @include('components.chatbot-widget')

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
                        <a href="https://www.instagram.com/kel.margasari.bpn/" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@margasaribarat2791" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <div class="text-light">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            Jalan Semoi No.46 RT.14 Kel. Margasari, Kec. Balikpapan Barat, Kota Balikpapan, Kalimantan Timur.
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            0853-9330-6350
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            margasari33@gmail.com
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
    
    <!-- Sticky Header JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('mainHeader');
            const scrollThreshold = 50; // Pixels to scroll before header becomes transparent
            const mobileShowThreshold = 150; // Pixels to scroll before showing navbar on mobile
            let lastScrollTop = 0;
            
            function isMobile() {
                return window.innerWidth <= 767;
            }
            
            function updateHeader() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Regular desktop behavior
                if (scrollTop > scrollThreshold) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                // Mobile specific behavior
                if (isMobile()) {
                    if (scrollTop > mobileShowThreshold) {
                        // Show navbar when scrolled down past hero section
                        header.classList.add('show-on-scroll');
                    } else {
                        // Hide navbar in hero section (default state)
                        header.classList.remove('show-on-scroll');
                    }
                } else {
                    // Desktop - ensure mobile classes are removed
                    header.classList.remove('show-on-scroll');
                }
                
                lastScrollTop = scrollTop;
            }
            
            // Update header on scroll
            window.addEventListener('scroll', updateHeader);
            
            // Update header on page load
            updateHeader();
            
            // Throttle scroll events for better performance
            let ticking = false;
            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateHeader);
                    ticking = true;
                    setTimeout(() => ticking = false, 10);
                }
            }
            
            window.addEventListener('scroll', requestTick);
            
            // Handle window resize to update mobile detection
            window.addEventListener('resize', function() {
                // Reset and update header when switching between mobile/desktop
                header.classList.remove('show-on-scroll');
                updateHeader();
            });
        });
    </script>
    
    <!-- Chatbot JS -->
    <script src="{{ asset('js/chatbot.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
