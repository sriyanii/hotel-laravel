<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Hotel Abadi')</title>
    
    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-active: #334155;
            --navbar-height: 64px;
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }
        
        /* Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: all var(--transition-speed) ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-brand i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .nav-menu {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 0;
            transition: all 0.2s;
            text-decoration: none;
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: var(--sidebar-active);
        }
        
        .nav-link.active {
            border-left: 3px solid var(--primary-color);
        }
        
        .nav-link i {
            width: 1.25rem;
            text-align: center;
        }
        
        .submenu {
            padding-left: 3rem;
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .menu-toggle::after {
            display: inline-block;
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.75rem;
            transition: transform 0.2s;
            margin-left: auto;
        }
        
        .menu-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding-top: var(--navbar-height);
            transition: margin-left var(--transition-speed);
        }
        
        /* Navbar Styles */
        .navbar {
            height: var(--navbar-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 900;
            transition: left var(--transition-speed);
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            position: relative;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem;
            min-width: 200px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
        }
        
        .dropdown-item:hover {
            background-color: #f1f5f9;
        }
        
        .dropdown-divider {
            margin: 0.25rem 0;
            border-color: #e2e8f0;
        }
        
        /* Profile Section */
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .profile-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .profile-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 auto 1rem;
            overflow: hidden;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.25rem;
        }
        
        .profile-role {
            text-align: center;
            opacity: 0.9;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .profile-body {
            padding: 2rem;
            background-color: white;
        }
        
        .profile-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
            color: var(--primary-color);
        }
        
        .profile-info-item {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .profile-info-label {
            width: 150px;
            font-weight: 500;
            color: var(--secondary-color);
        }
        
        .profile-info-value {
            flex: 1;
        }
        
        .edit-profile-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.2s;
        }
        
        .edit-profile-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        /* Content Container */
        .content-container {
            padding: 2rem;
            min-height: calc(100vh - var(--navbar-height));
            display: flex;
            flex-direction: column;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Footer */
        .app-footer {
            margin-top: auto;
            padding: 1.5rem;
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .navbar, .main-content {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Utility Classes */
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
    </style>
    
    @yield('head')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <i class="fas fa-hotel"></i>
                    <span>Hotel Abadi</span>
                </div>
            </div>
            
            <div class="nav-menu">
                @php $role = auth()->user()->role; @endphp
                
                <div class="nav-item">
                    <a href="{{ route($role . '.dashboard') }}" class="nav-link {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Profile Link -->
                <div class="nav-item">
                    <a href="{{ route($role . '.profile') }}" class="nav-link {{ request()->routeIs($role . '.profile') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>
                
                <!-- Hotel Management Section -->
                <div class="nav-item">
                    <a class="nav-link menu-toggle {{ request()->is($role . '/rooms*') || request()->is($role . '/guests*') || request()->is($role . '/bookings*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" href="#hotelManagement" role="button" 
                       aria-expanded="{{ request()->is($role . '/rooms*') || request()->is($role . '/guests*') || request()->is($role . '/bookings*') ? 'true' : 'false' }}">
                        <i class="fas fa-hotel"></i>
                        <span>Manajemen Hotel</span>
                    </a>
                    
                    <div class="collapse {{ request()->is($role . '/rooms*') || request()->is($role . '/guests*') || request()->is($role . '/bookings*') ? 'show' : '' }}" id="hotelManagement">
                        <div class="submenu">
                            <a href="{{ route($role . '.rooms.index') }}" class="nav-link {{ request()->routeIs($role . '.rooms.*') ? 'active' : '' }}">
                                <i class="fas fa-bed"></i>
                                <span>Manajemen Kamar</span>
                            </a>
                            <a href="{{ route($role . '.guests.index') }}" class="nav-link {{ request()->routeIs($role . '.guests.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Daftar Tamu</span>
                            </a>
                            <a href="{{ route($role . '.bookings.index') }}" class="nav-link {{ request()->routeIs($role . '.bookings.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Booking Kamar</span>
                            </a>
                            <a href="{{ route($role . '.payments.index') }}" class="nav-link {{ request()->routeIs($role . '.payments.*') ? 'active' : '' }}">
                                <i class="fas fa-receipt"></i>
                                <span>Transaksi</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Admin Only Section -->
                @if($role === 'admin')
                <div class="nav-item">
                    <a class="nav-link menu-toggle {{ request()->is('admin/users*') || request()->is('admin/payments*') ? 'active' : '' }}" 
                       data-bs-toggle="collapse" href="#dataManagement" role="button" 
                       aria-expanded="{{ request()->is('admin/users*') || request()->is('admin/payments*') ? 'true' : 'false' }}">
                        <i class="fas fa-database"></i>
                        <span>Manajemen Data</span>
                    </a>
                    
                    <div class="collapse {{ request()->is('admin/users*') || request()->is('admin/payments*') ? 'show' : '' }}" id="dataManagement">
                        <div class="submenu">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-user-cog"></i>
                                <span>Manajemen User</span>
                            </a>
                            <a href="{{ route('admin.laporan_keuangan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan_keuangan.*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>Laporan Keuangan</span>
                            </a>
                            <a href="{{ route('admin.activities.index') }}" class="nav-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                                <i class="fas fa-history"></i>
                                <span>Aktifitas User</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand navbar-light bg-white">
                <div class="container-fluid">
                    <button class="btn btn-link d-lg-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="user-dropdown me-3" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                        </div>
                        
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route($role . '.profile') }}">
                                    <i class="fas fa-user-circle me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Content -->
            <div class="content-container">
                @if(request()->routeIs($role . '.profile'))
                    <!-- Profile Page Content -->
                    <div class="profile-container">
                        <div class="profile-card">
                            <div class="profile-header">
                                <button class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <div class="profile-avatar">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <h3 class="profile-name">{{ auth()->user()->name }}</h3>
                                <div class="profile-role">
                                    @if($role === 'admin')
                                        Administrator
                                    @elseif($role === 'receptionist')
                                        Resepsionis
                                    @else
                                        Staff
                                    @endif
                                </div>
                            </div>
                            <div class="profile-body">
                                <div class="mb-4">
                                    <h5 class="profile-section-title">Informasi Pribadi</h5>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Nama Lengkap</div>
                                        <div class="profile-info-value">{{ auth()->user()->name }}</div>
                                    </div>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Email</div>
                                        <div class="profile-info-value">{{ auth()->user()->email }}</div>
                                    </div>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Nomor Telepon</div>
                                        <div class="profile-info-value">{{ auth()->user()->phone ?? '-' }}</div>
                                    </div>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Alamat</div>
                                        <div class="profile-info-value">{{ auth()->user()->address ?? '-' }}</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h5 class="profile-section-title">Informasi Akun</h5>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Username</div>
                                        <div class="profile-info-value">{{ auth()->user()->username }}</div>
                                    </div>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Role</div>
                                        <div class="profile-info-value">
                                            @if($role === 'admin')
                                                <span class="badge bg-primary">Administrator</span>
                                            @elseif($role === 'receptionist')
                                                <span class="badge bg-success">Resepsionis</span>
                                            @else
                                                <span class="badge bg-secondary">Staff</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="profile-info-item">
                                        <div class="profile-info-label">Bergabung Pada</div>
                                        <div class="profile-info-value">{{ auth()->user()->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="profile-section-title">Keamanan</h5>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                            <i class="fas fa-key me-2"></i> Ubah Password
                                        </button>
                                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#twoFactorModal">
                                            <i class="fas fa-shield-alt me-2"></i> Autentikasi 2 Faktor
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Profile Modal -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route($role . '.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{ auth()->user()->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Change Password Modal -->
                    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route($role . '.profile.change-password') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Password Saat Ini</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Two Factor Auth Modal -->
                    <div class="modal fade" id="twoFactorModal" tabindex="-1" aria-labelledby="twoFactorModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="twoFactorModalLabel">Autentikasi 2 Faktor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Autentikasi dua faktor menambahkan lapisan keamanan tambahan ke akun Anda dengan memerlukan lebih dari sekadar password untuk masuk.</p>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enable2FA">
                                        <label class="form-check-label" for="enable2FA">Aktifkan Autentikasi 2 Faktor</label>
                                    </div>
                                    
                                    <div id="2faSetup" class="d-none">
                                        <hr>
                                        <h6>Langkah 1: Scan QR Code</h6>
                                        <div class="text-center mb-3">
                                            <img src="https://via.placeholder.com/200" alt="QR Code" class="img-fluid mb-2">
                                            <p class="small text-muted">Scan QR code ini menggunakan aplikasi authenticator seperti Google Authenticator atau Authy</p>
                                        </div>
                                        
                                        <h6>Langkah 2: Masukkan Kode Verifikasi</h6>
                                        <div class="mb-3">
                                            <label for="verificationCode" class="form-label">Kode Verifikasi</label>
                                            <input type="text" class="form-control" id="verificationCode" placeholder="Masukkan 6 digit kode">
                                        </div>
                                        
                                        <button class="btn btn-primary w-100">Verifikasi dan Aktifkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @yield('content')
                @endif
                
                <!-- Footer -->
                <footer class="app-footer">
                    <div class="container">
                        <small>&copy; {{ date('Y') }} Hotel Abadi. All rights reserved.</small>
                    </div>
                </footer>
            </div>
        </main>
    </div>
    
    {{-- JavaScript Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                event.target !== sidebarToggle && 
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
        
        // Update active state for menu items
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
                
                // Expand parent menus if this is a submenu item
                let parentMenu = link.closest('.collapse');
                if (parentMenu) {
                    parentMenu.classList.add('show');
                    const toggle = document.querySelector(`[href="#${parentMenu.id}"]`);
                    if (toggle) {
                        toggle.classList.add('active');
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });
        
        // Toggle 2FA setup section
        document.getElementById('enable2FA').addEventListener('change', function() {
            document.getElementById('2faSetup').classList.toggle('d-none', !this.checked);
        });
    </script>
    
    @yield('scripts')
</body>
</html>