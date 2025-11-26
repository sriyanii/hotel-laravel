<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HotelMaster')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
    
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --dark: #1f2937;
            --light: #f9fafb;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            position: fixed;
            z-index: 100;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h3 {
            color: white;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .sidebar-brand .logo-icon {
            font-size: 2rem;
            margin-right: 10px;
            color: #fff;
        }
        
        .nav-item {
            position: relative;
            margin: 5px 15px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 15px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }
        
        .nav-link .badge {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h2 {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        /* Role Badge */
        .role-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 10px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 15px;
            }
            
            .header h2 {
                font-size: 1.5rem;
            }
        }
        
        :root {
    --primary: #3a86ff;
    --secondary: #2667cc;
    --dark: #1f2937;
    --light: #f9fafb;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fb;
    color: var(--dark);
}

/* Sidebar */
.sidebar {
    width: 280px;
    min-height: 100vh;
    background: linear-gradient(180deg, var(--primary), var(--secondary));
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    position: fixed;
    z-index: 100;
}

.sidebar-brand {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-brand h3 {
    color: white;
    font-weight: 700;
    margin-bottom: 0;
}

.sidebar-brand .logo-icon {
    font-size: 2rem;
    margin-right: 10px;
    color: #fff;
}

.nav-item {
    position: relative;
    margin: 5px 15px;
    border-radius: 8px;
    overflow: hidden;
}

.nav-link {
    color: rgba(255,255,255,0.8);
    padding: 12px 15px;
    font-weight: 500;
    transition: all 0.3s;
}

.nav-link:hover, .nav-link.active {
    color: white;
    background-color: rgba(255,255,255,0.1);
}

.nav-link i {
    width: 24px;
    text-align: center;
    margin-right: 10px;
}

/* Main Content */
.main-content {
    margin-left: 280px;
    padding: 30px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header h2 {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0;
}

/* Guest Cards */
.guest-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 30px;
}

/* Guest Tabs */
.guest-tabs .nav-link {
    color: var(--dark);
    border: none;
    padding: 10px 20px;
    font-weight: 500;
}

.guest-tabs .nav-link.active {
    color: var(--primary);
    border-bottom: 3px solid var(--primary);
    background: transparent;
}

/* Guest Search */
.guest-search {
    position: relative;
    margin-bottom: 20px;
}

.guest-search input {
    padding-left: 40px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.guest-search i {
    position: absolute;
    left: 15px;
    top: 12px;
    color: #9ca3af;
}

/* Guest List */
.guest-list {
    max-height: 600px;
    overflow-y: auto;
}

.guest-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    background-color: #f9fafb;
    transition: all 0.3s;
}

.guest-item:hover {
    background-color: #f3f4f6;
    transform: translateX(5px);
}

.guest-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.guest-info {
    flex: 1;
}

.guest-status {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
}

.status-current {
    background-color: #d1fae5;
    color: #065f46;
}

.status-checkedout {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-vip {
    background-color: #fef3c7;
    color: #92400e;
}

/* Guest Details Modal */
.guest-modal .modal-header {
    border-bottom: none;
    padding-bottom: 0;
}

.guest-modal .modal-footer {
    border-top: none;
    padding-top: 0;
}

.guest-details {
    list-style: none;
    padding: 0;
    margin: 0;
}

.guest-details li {
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
}

.guest-details li:last-child {
    border-bottom: none;
}

.guest-details .label {
    width: 120px;
    color: #6b7280;
}

.guest-details .value {
    flex: 1;
    font-weight: 500;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e5e7eb;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--primary);
    border: 2px solid white;
}

.timeline-date {
    font-size: 12px;
    color: #6b7280;
}

.timeline-content {
    background: white;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Stats Cards */
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.stats-card .count {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
}

.stats-card .label {
    color: #6b7280;
    font-size: 14px;
}

/* New Guest Form */
.form-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.form-section h5 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        position: relative;
        min-height: auto;
    }
    
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .guest-item {
        flex-direction: column;
        text-align: center;
    }
    
    .guest-avatar {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .guest-status {
        margin: 10px 0;
    }
}
    </style>
    @stack('css')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand d-flex align-items-center">
            <i class="fas fa-hotel logo-icon"></i>
            <h3>HotelMaster</h3>
        </div>
        

        
        <ul class="nav flex-column">
            @if(auth()->user()->role === 'admin')
                <!-- ADMIN MENU -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/analytics*') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                        <i class="fas fa-chart-pie"></i> Analytics
                        <span class="badge bg-danger rounded-pill">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/finance*') ? 'active' : '' }}" href="{{ route('admin.finance') }}">
                        <i class="fas fa-wallet"></i> Finance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/rooms*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
                        <i class="fas fa-bed"></i> Room Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i> Staff Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                        <i class="fas fa-calendar-alt"></i> Bookings
                        <span class="badge bg-success rounded-pill">5</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/rate-plans*') ? 'active' : '' }}" href="{{ route('admin.rate-plans.index') }}">
                        <i class="fas fa-calendar-day"></i> Rate Plans
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i> Payments & Invoices
                    </a>
                </li>
<li class="nav-item">
    <a href="#" 
       class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}" 
       data-bs-toggle="modal" 
       data-bs-target="#couponModal">
        <i class="fas fa-tag"></i> Coupons
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link disabled" style="opacity: 0.6; cursor: not-allowed;">
        <i class="fas fa-cog"></i> Settings
        <span class="ms-1 text-muted">(Coming Soon)</span>
    </a>
</li>

                
            @else
                <!-- RESEPSIONIS MENU -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/dashboard*') ? 'active' : '' }}" href="{{ route('resepsionis.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/cico*') ? 'active' : '' }}" href="{{ route('resepsionis.cico.index') }}">
                        <i class="fas fa-calendar-check"></i> Check In/Out
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/rooms*') ? 'active' : '' }}" href="{{ route('resepsionis.room.index') }}">
                        <i class="fas fa-bed"></i> Room Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/guests*') ? 'active' : '' }}" href="{{ route('resepsionis.guests.index') }}">
                        <i class="fas fa-users"></i> Guests
                        <span class="badge bg-danger rounded-pill">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/payments*') ? 'active' : '' }}" href="{{ route('resepsionis.payments.index') }}">
                        <i class="fas fa-receipt"></i> Invoices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('resepsionis/notifications*') ? 'active' : '' }}" href="{{ route('resepsionis.notifications.index') }}">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <!-- <div class="header">
            <h2>
                <i class="fas @yield('header-icon', 'fa-tachometer-alt') me-2"></i>
                @yield('header-title', 'Dashboard')
            </h2>
            <div class="user-menu">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="ms-2">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    
    <script>
        // Sidebar toggle untuk mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        // Notifikasi dan konfirmasi
        document.addEventListener('DOMContentLoaded', function() {
            // Notifikasi sukses/error otomatis
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            // Konfirmasi delete universal
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const itemName = this.getAttribute('data-item-name') || 'data ini';

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        html: `Anda akan menghapus <b>${itemName}</b>.<br>Aksi ini tidak bisa dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>