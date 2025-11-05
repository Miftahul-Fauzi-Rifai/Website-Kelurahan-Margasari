<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard Ketua RT') - Kelurahan Marga Sari</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 1.5rem 1rem 0.5rem;
            color: #5a5c69;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }
        
        .nav-link {
            color: #5a5c69;
            padding: 0.75rem 1rem;
            border-radius: 0;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: #5a5c69;
            background-color: #eaecf4;
        }
        
        .nav-link i {
            width: 1.5rem;
            text-align: center;
        }
        
        .content-wrapper {
            background-color: #f8f9fc;
            min-height: 100vh;
        }
        
        .topbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Topbar enhancements */
        .topbar .nav-link {
            padding: 0.5rem 0.75rem;
        }

        .topbar .nav-link:hover {
            background-color: transparent;
        }

        /* Dropdown animations */
        .animated--grow-in {
            animation: growIn 0.2s ease-in-out;
        }

        @keyframes growIn {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Dropdown improvements */
        .dropdown-menu {
            border: 0;
            border-radius: 0.35rem;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            font-weight: 800;
            font-size: 0.65rem;
            text-transform: uppercase;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fc;
            padding-left: 1.25rem;
        }

        /* User avatar in topbar */
        .topbar .rounded-circle {
            transition: transform 0.2s;
        }

        .topbar .nav-link:hover .rounded-circle {
            transform: scale(1.05);
        }
        
         /* === SIDEBAR RESPONSIVE UNIVERSAL === */
        @media (max-width: 1200px) {
            body {
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch; /* smooth scroll iOS */
            }
        
            /* Sidebar default tertutup di layar kecil-menengah */
            #sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                width: 260px;
                background-color: #fff;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
                transform: translateX(-100%);
                opacity: 0;
                visibility: hidden;
                transition: transform 0.3s ease, opacity 0.2s ease, visibility 0.2s ease;
                z-index: 1050;
                will-change: transform, opacity;
            }
        
            /* Saat aktif, sidebar muncul */
            #sidebar.active {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }
        
            /* Overlay di belakang sidebar */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1040;
                display: none;
                opacity: 0;
                transition: opacity 0.2s ease;
                backdrop-filter: blur(2px); /* efek blur elegan */
            }
        
            .sidebar-overlay.active {
                display: block;
                opacity: 1;
            }
        
            /* Pastikan konten tidak bergeser */
            .content-wrapper {
                margin-left: 0 !important;
                transition: none !important;
            }
        
            /* Tombol hamburger selalu muncul di semua layar kecil-menengah */
            #sidebarToggleTop {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background-color: transparent;
                color: #198754;
                font-size: 1.3rem;
                transition: background-color 0.2s ease;
            }
        
            #sidebarToggleTop:hover {
                background-color: rgba(25, 135, 84, 0.1);
            }
        }


        /* === Overlay Sidebar di Mobile (tidak menggeser konten) === */
        @media (max-width: 992px) {
           body {
               overflow-x: hidden;
           }
       
           #sidebar {
               position: fixed !important;
               top: 0;
               left: 0;
               height: 100vh;
               width: 250px;
               background-color: #fff;
               box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
               transform: translateX(-100%);
               opacity: 0;
               transition: transform 0.3s ease, opacity 0.2s ease;
               z-index: 1050;
           }
       
           #sidebar.active {
               transform: translateX(0);
               opacity: 1;
           }
       
           .sidebar-overlay {
               position: fixed;
               top: 0;
               left: 0;
               right: 0;
               bottom: 0;
               background: rgba(0, 0, 0, 0.4);
               z-index: 1040;
               display: none;
               transition: opacity 0.2s ease;
               opacity: 0;
           }
       
           .sidebar-overlay.active {
               display: block;
               opacity: 1;
           }
       
           .content-wrapper {
               margin-left: 0 !important;
               transition: none !important;
           }
        }       

    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-white sidebar" id="sidebar">
            <div class="sidebar-brand d-flex align-items-center justify-content-center py-4">
                <div class="sidebar-brand-text mx-3">
                    <div class="text-success fw-bold">Dashboard Ketua RT</div>
                    <small class="text-muted">RT {{ Auth::user()->rt }}</small>
                </div>
            </div>
            
            <hr class="sidebar-divider my-0">
            
            <nav class="nav flex-column">
                <!-- Dashboard -->
                <a class="nav-link {{ request()->routeIs('ketua-rt.dashboard') ? 'active' : '' }}" 
                   href="{{ route('ketua-rt.dashboard') }}">
                    <i class="bi bi-speedometer2 me-3"></i>
                    Dashboard
                </a>
                
                <div class="sidebar-heading">Laporan</div>
                
                <!-- Laporan Bulanan -->
                <a class="nav-link {{ request()->routeIs('ketua-rt.reports.*') ? 'active' : '' }}" 
                   href="{{ route('ketua-rt.reports.index') }}">
                    <i class="bi bi-file-earmark-text me-3"></i>
                    Laporan Bulanan
                </a>
            </nav>
        </div>

        <!-- Content Wrapper -->
        <div class="flex-grow-1 content-wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand topbar mb-4 static-top py-2">
                <!-- Sidebar Toggle (Mobile) -->
                <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" 
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 fw-semibold">
                                {{ Auth::user()->name }}
                            </span>
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" 
                                 style="width: 40px; height: 40px; font-size: 1.1rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" style="min-width: 200px;">
                            <div class="dropdown-header bg-light">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                                @if(Auth::user()->rt)
                                <div class="small text-success fw-semibold mt-1">RT {{ Auth::user()->rt }}</div>
                                @endif
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2 text-success"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-globe me-2 text-success"></i>
                                Lihat Website
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggleTop');

    // --- Pastikan sidebar default tertutup di mobile ---
    if (window.innerWidth <= 992) {
        sidebar.classList.remove('active');
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.opacity = '0';
    }

    // --- Buat overlay jika belum ada ---
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }

    // --- Fungsi toggle sidebar ---
    const toggleSidebar = () => {
        const isActive = sidebar.classList.toggle('active');
        overlay.classList.toggle('active', isActive);

        if (isActive) {
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.opacity = '1';
        } else {
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.opacity = '0';
        }
    };

    // --- Klik tombol hamburger ---
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSidebar();
    });

    // --- Klik overlay menutup sidebar ---
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.opacity = '0';
    });

    // --- Tutup otomatis saat resize ke layar besar ---
    window.addEventListener('resize', () => {
        if (window.innerWidth > 992) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            sidebar.style.transform = 'none';
            sidebar.style.opacity = '1';
        } else {
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.opacity = '0';
        }
    });

    // --- Auto-hide alert setelah 5 detik ---
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // --- Tutup dropdown kalau klik di luar ---
    document.addEventListener('click', e => {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            if (!menu.parentElement.contains(e.target)) {
                const dropdown = bootstrap.Dropdown.getInstance(menu.previousElementSibling);
                if (dropdown) dropdown.hide();
            }
        });
    });
});
</script>
@stack('scripts')
</body>
</html>