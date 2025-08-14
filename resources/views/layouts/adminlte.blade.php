<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            transition: all 0.5s;
            z-index: 1040;
        }

        .sidebar a {
            color: #ccc;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            white-space: nowrap;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #495057;
            color: #fff;
        }

        .sidebar .collapse a {
            padding-left: 40px;
            font-size: 0.95rem;
        }

        .main-content {
            margin-left: 250px;
            padding-top: 56px;
            width: 100%;
            background-color: #f8f9fa;
            transition: margin-left 0.3s;
        }

        .navbar-custom {
            background-color: #212529;
            color: white;
            position: fixed;
            width: 100%;
            z-index: 1050;
            height: 56px;
            top: 0;
            left: 0;
        }

        .navbar-custom .navbar-brand {
            color: white;
        }

        #toggleSidebar {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            #toggleSidebar {
                display: inline-block;
            }
        }
    </style>

    @yield('head')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark navbar-custom d-flex justify-content-between align-items-center px-3">
        <div class="d-flex align-items-center">
            <button id="toggleSidebar" class="d-md-none"><i class="fa fa-bars"></i></button>
            <span class="navbar-brand mb-0">Hotel Abadi</span>
        </div>
        <div class="d-flex align-items-center">
            <i class="fas fa-user-circle me-2"></i> {{ auth()->user()->name ?? 'Admin' }}
            <form action="{{ route('logout') }}" method="POST" class="ms-3 mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <div class="wrapper">
        {{-- Sidebar --}}
        <div class="sidebar" id="sidebar">
            <h5 class="text-center text-light mb-4 mt-3">Hotel Abadi</h5>

            {{-- Profil Saya --}}
            <a href="{{ route(auth()->user()->role . '.profile.show') }}" class="{{ 
                request()->routeIs('admin.profile.*') || 
                request()->routeIs('resepsionis.profile.*') ? 'active' : '' }}">
                <i class="fa fa-user me-2"></i> Profil Saya
            </a>

            @php $role = auth()->user()->role; @endphp

            {{-- Dashboard --}}
            <a href="{{ route($role . '.dashboard') }}" class="{{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i> Dashboard
            </a>

            {{-- Dropdown Manajemen Hotel --}}
            <div>
                <a class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuHotel" role="button"
                   aria-expanded="{{ 
                       request()->is($role . '/rooms*') || 
                       request()->is($role . '/guests*') || 
                       request()->is($role . '/bookings*') ? 'true' : 'false' }}"
                   aria-controls="menuHotel">
                    <span><i class="fa fa-hotel me-1"></i> Manajemen Hotel</span>
                    <i class="bi {{ 
                        request()->is($role . '/rooms*') || 
                        request()->is($role . '/guests*') || 
                        request()->is($role . '/bookings*') ? 'bi-chevron-up' : 'bi-chevron-down' }}">
                    </i>
                </a>
                <div class="collapse {{ 
                    request()->is($role . '/rooms*') || 
                    request()->is($role . '/guests*') || 
                    request()->is($role . '/bookings*') ? 'show' : '' }}" id="menuHotel">
                    <a href="{{ route($role . '.rooms.index') }}" class="{{ request()->routeIs($role . '.rooms.*') ? 'active' : '' }}">
                        <i class="fa fa-bed me-1"></i> Manajemen Kamar
                    </a>
                    <a href="{{ route($role . '.guests.index') }}" class="{{ request()->routeIs($role . '.guests.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-1"></i> Daftar Tamu
                    </a>
                    <a href="{{ route($role . '.bookings.index') }}" class="{{ request()->routeIs($role . '.bookings.*') ? 'active' : '' }}">
                        <i class="fa fa-calendar-check me-1"></i> Booking Kamar
                    </a>
                    <a href="{{ route($role . '.payments.index') }}" class="{{ request()->routeIs($role . '.payments.*') ? 'active' : '' }}">
                        <i class="fa fa-receipt me-1"></i> Transaksi
                    </a>
                </div>
            </div>

            {{-- Admin Only --}}
            @if($role === 'admin')
            <div>
                <a class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuData" role="button"
                   aria-expanded="{{ 
                       request()->is('admin/users*') || 
                       request()->is('admin/laporan_keuangan*') || 
                       request()->is('admin/activities*') ? 'true' : 'false' }}"
                   aria-controls="menuData">
                    <span><i class="fa fa-database me-1"></i> Manajemen Data</span>
                    <i class="bi {{ 
                        request()->is('admin/users*') || 
                        request()->is('admin/laporan_keuangan*') || 
                        request()->is('admin/activities*') ? 'bi-chevron-up' : 'bi-chevron-down' }}">
                    </i>
                </a>
                <div class="collapse {{ 
                    request()->is('admin/users*') || 
                    request()->is('admin/laporan_keuangan*') || 
                    request()->is('admin/activities*') ? 'show' : '' }}" id="menuData">
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-user-cog me-1"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.laporan_keuangan.index') }}" class="{{ request()->routeIs('admin.laporan_keuangan.*') ? 'active' : '' }}">
                        <i class="fa fa-file-invoice-dollar me-1"></i> Laporan Keuangan
                    </a>
                    <a href="{{ route('admin.activities.index') }}" class="{{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                        <i class="fa fa-history me-1"></i> Aktifitas User
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- Main Content --}}
        <div class="main-content">
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="text-center py-3 mt-auto text-dark" style="margin-left: 250px;">
        <div class="container">
            <small>&copy; {{ date('Y') }} Hotel Abadi. All rights reserved.</small>
        </div>
    </footer>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Sidebar toggle untuk mobile
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Ganti ikon collapse ketika diklik
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const icon = this.querySelector('.bi');
                setTimeout(() => {
                    icon.classList.toggle('bi-chevron-up');
                    icon.classList.toggle('bi-chevron-down');
                }, 150);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>