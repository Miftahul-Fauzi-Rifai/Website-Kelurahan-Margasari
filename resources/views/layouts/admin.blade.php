<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') - Kelurahan Marga Sari</title>
    
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

        .topbar .nav-link i {
            color: #858796;
        }

        .topbar .nav-link:hover i {
            color: #4e73df;
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

        /* Badge position fix */
        .position-relative {
            position: relative !important;
        }

        .position-absolute {
            position: absolute !important;
        }

        /* User avatar in topbar */
        .topbar .rounded-circle {
            transition: transform 0.2s;
        }

        .topbar .nav-link:hover .rounded-circle {
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .topbar-divider {
                display: none !important;
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
                    <div class="text-primary fw-bold">Admin Panel</div>
                    <small class="text-muted">Kelurahan Marga Sari</small>
                </div>
            </div>
            
            <hr class="sidebar-divider my-0">
            
            <nav class="nav flex-column">
                <!-- Dashboard -->
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-3"></i>
                    Dashboard
                </a>
                
                <div class="sidebar-heading">Konten</div>
                
                <!-- Tentang Kelurahan -->
                <a class="nav-link {{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}" href="{{ route('admin.tentang.edit', 1) }}">
                    <i class="bi bi-info-circle me-3"></i>
                    Tentang Kelurahan
                </a>
                <!-- Posts -->
                <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" 
                   href="{{ route('admin.posts.index') }}">
                    <i class="bi bi-newspaper me-3"></i>
                    Artikel & Berita
                </a>
                
                <!-- Complaints -->
                <a class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}" href="{{ route('admin.complaints.index') }}">
                    <i class="bi bi-megaphone me-3"></i>
                    Pengaduan
                    @if(\App\Models\Complaint::where('status', 'baru')->count() > 0)
                        <span class="badge badge-warning ms-2">{{ \App\Models\Complaint::where('status', 'baru')->count() }}</span>
                    @endif
                </a>
                
                <!-- Reports -->
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-file-earmark-text me-3"></i>
                    Laporan RT
                    @if(\App\Models\Report::where('status', 'submitted')->count() > 0)
                        <span class="badge bg-info ms-2">{{ \App\Models\Report::where('status', 'submitted')->count() }}</span>
                    @endif
                </a>
                
                <div class="sidebar-heading">Manajemen</div>
                
                <!-- Data RT -->
                <a class="nav-link {{ request()->routeIs('admin.rts.*') ? 'active' : '' }}" href="{{ route('admin.rts.index') }}">
                    <i class="bi bi-house-fill me-3"></i>
                    Data RT
                </a>
                
                <!-- Users (Ketua RT) -->
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people-fill me-3"></i>
                    Kelola Ketua RT
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
                    <!-- Nav Item - Alerts Dropdown -->
                    <li class="nav-item dropdown no-arrow me-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center position-relative" 
                           href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill fs-5"></i>
                            <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle" 
                                  style="font-size: 0.65rem; padding: 0.25rem 0.4rem;">3+</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" style="min-width: 320px;">
                            <h6 class="dropdown-header bg-primary text-white">
                                <i class="bi bi-bell me-2"></i>Notifikasi Terbaru
                            </h6>
                            <a class="dropdown-item d-flex align-items-center py-3 border-bottom" href="#">
                                <div class="me-3">
                                    <div class="icon-circle bg-primary d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; border-radius: 50%;">
                                        <i class="bi bi-file-text text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-muted">12 Desember 2023</div>
                                    <span class="fw-semibold">Artikel baru menunggu review</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-3 border-bottom" href="#">
                                <div class="me-3">
                                    <div class="icon-circle bg-warning d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; border-radius: 50%;">
                                        <i class="bi bi-megaphone text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-muted">11 Desember 2023</div>
                                    <span class="fw-semibold">Pengaduan baru masuk</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center py-3" href="#">
                                <div class="me-3">
                                    <div class="icon-circle bg-success d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; border-radius: 50%;">
                                        <i class="bi bi-person-check text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-muted">10 Desember 2023</div>
                                    <span class="fw-semibold">Ketua RT baru terdaftar</span>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-primary py-2 bg-light" href="#">
                                <i class="bi bi-arrow-right me-1"></i>Lihat Semua Notifikasi
                            </a>
                        </div>
                    </li>

                    <!-- Divider -->
                    <div class="topbar-divider d-none d-sm-block" style="width: 0; height: 2rem; border-right: 1px solid #e3e6f0; margin: 0 1rem;"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" 
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 fw-semibold">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </span>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                 style="width: 40px; height: 40px; font-size: 1rem;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" style="min-width: 200px;">
                            <div class="dropdown-header bg-light">
                                <div class="fw-bold">{{ Auth::user()->name ?? 'Admin' }}</div>
                                <div class="small text-muted">{{ Auth::user()->name ?? 'Admin' }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2 text-primary"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2 text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-globe me-2 text-primary"></i>
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

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', function() {
                    const sidebar = document.getElementById('sidebar');
                    sidebar.classList.toggle('d-none');
                });
            }
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdowns = document.querySelectorAll('.dropdown-menu.show');
                dropdowns.forEach(function(dropdown) {
                    if (!dropdown.parentElement.contains(e.target)) {
                        const bsDropdown = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                        if (bsDropdown) {
                            bsDropdown.hide();
                        }
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
