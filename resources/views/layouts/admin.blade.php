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
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
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
                
                <!-- Posts -->
                <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" 
                   href="{{ route('admin.posts.index') }}">
                    <i class="bi bi-newspaper me-3"></i>
                    Artikel & Berita
                </a>
                
                <!-- Services -->
                <a class="nav-link" href="#">
                    <i class="bi bi-card-list me-3"></i>
                    Layanan
                </a>
                
                <!-- Complaints -->
                <a class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}" href="{{ route('admin.complaints.index') }}">
                    <i class="bi bi-megaphone me-3"></i>
                    Pengaduan
                    @if(\App\Models\Complaint::where('status', 'baru')->count() > 0)
                        <span class="badge badge-warning ms-2">{{ \App\Models\Complaint::where('status', 'baru')->count() }}</span>
                    @endif
                </a>

                <div class="sidebar-heading">Pengguna</div>
                
                <!-- Users -->
                <a class="nav-link" href="#">
                    <i class="bi bi-people me-3"></i>
                    Kelola Pengguna
                </a>
                
                <!-- Roles -->
                <a class="nav-link" href="#">
                    <i class="bi bi-shield-check me-3"></i>
                    Role & Permission
                </a>
                
                <div class="sidebar-heading">Sistem</div>
                
                <!-- Settings -->
                <a class="nav-link" href="#">
                    <i class="bi bi-gear me-3"></i>
                    Pengaturan
                </a>
                
                <!-- Backup -->
                <a class="nav-link" href="#">
                    <i class="bi bi-cloud-download me-3"></i>
                    Backup Data
                </a>
            </nav>
            
            <hr class="sidebar-divider">
            
            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="btn btn-link border-0 text-muted" id="sidebarToggle">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="flex-grow-1 content-wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand topbar mb-4 static-top">
                <!-- Sidebar Toggle (Mobile) -->
                <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Nav Item - Alerts Dropdown -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            <i class="bi bi-bell-fill"></i>
                            <span class="badge bg-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow">
                            <h6 class="dropdown-header">
                                Notifikasi
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="me-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="bi bi-file-text text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">12 Desember 2023</div>
                                    <span class="font-weight-bold">Artikel baru menunggu review</span>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small">
                                {{ Auth::user()->name }}
                            </span>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow">
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-globe me-2 text-gray-400"></i>
                                Lihat Website
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2 text-gray-400"></i>
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
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('d-none');
        });
        
        // Mobile sidebar toggle
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('d-none');
        });
        
        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
