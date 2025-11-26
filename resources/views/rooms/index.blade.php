@extends('layouts.adminlte')
@use('Illuminate\Support\Str')
@section('title', 'Manajemen Kamar')
@section('content_header')
    <h1 class="fw-bold text-dark"><i class="fas fa-bed me-2 text-white"></i>Manajemen Kamar</h1>
@stop
@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp
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
        
        /* Room Cards */
        .room-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            transition: all 0.3s;
            overflow: hidden;
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .room-card .card-img-top {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        
        .room-card .card-body {
            padding: 20px;
        }
        
        .room-card .room-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 18px;
        }
        
        .room-card .room-type {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .room-card .room-price {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .room-card .room-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #6b7280;
        }
        
        .room-card .room-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .room-card .room-status.available {
            background-color: #ecfdf5;
            color: var(--success);
        }
        
        .room-card .room-status.booked {
            background-color: #fef2f2;
            color: var(--danger);
        }
        
        .room-card .room-status.maintenance {
            background-color: #fffbeb;
            color: var(--warning);
        }
        
        /* Room Management Card */
        .management-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        
        .management-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .management-card .card-title {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }
        
        /* Room Table */
        .room-table {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .room-table .table {
            margin-bottom: 0;
        }
        
        .room-table .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .room-table .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-top: 1px solid #f3f4f6;
        }
        
        .room-features {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .room-feature {
            background-color: #f3f4f6;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #6b7280;
        }
        
        /* Room Status Badge */
        .status-badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-badge.available {
            background-color: #ecfdf5;
            color: var(--success);
        }
        
        .status-badge.booked {
            background-color: #fef2f2;
            color: var(--danger);
        }
        
        .status-badge.maintenance {
            background-color: #fffbeb;
            color: var(--warning);
        }
        
        .status-badge.reserved {
            background-color: #eff6ff;
            color: var(--info);
        }
        
        /* Calendar */
        .calendar-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 24px;
        }

        /* Room Status Overview */
        .room-status-overview {
            padding: 20px;
        }
        
        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .status-item:last-child {
            border-bottom: none;
        }
        
        .status-info {
            display: flex;
            align-items: center;
        }
        
        .status-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 12px;
        }
        
        .status-color.available {
            background-color: var(--success);
        }
        
        .status-color.booked {
            background-color: var(--danger);
        }
        
        .status-color.maintenance {
            background-color: var(--warning);
        }
        
        .status-color.reserved {
            background-color: var(--info);
        }
        
        .status-details {
            display: flex;
            flex-direction: column;
        }
        
        .status-name {
            font-weight: 500;
            font-size: 14px;
        }
        
        .status-count {
            font-size: 12px;
            color: #6b7280;
        }
        
        .status-percentage {
            font-weight: 600;
            font-size: 14px;
            color: var(--dark);
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
    </style>
    <script src="{{ asset('js/print.js') }}"></script>
</head>
<body>



<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-bed me-2"></i> Room Management</h2>

    <div class="user-menu">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User" class="rounded-circle" width="32" height="32">
                <span class="ms-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Sign out
                    </a>
                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

        <!-- Quick Stats as Filter Buttons -->
        <div class="row mb-4">
            @php
                $stats = [
                    'all' => ['label' => 'Total Rooms', 'count' => $rooms->count()],
                    'available' => ['label' => 'Available Rooms', 'count' => $rooms->where('status', 'tersedia')->count()],
                    'occupied' => ['label' => 'Occupied Rooms', 'count' => $rooms->where('status', 'terisi')->count()],
                    'maintenance' => ['label' => 'Maintenance', 'count' => $rooms->where('status', 'maintenance')->count()],
                ];
                $currentFilter = request('status_filter', 'all');
            @endphp

            @foreach($stats as $status => $data)
                <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                    <a href="{{ route($prefix . '.rooms.index', array_merge(['status_filter' => $status], request()->except('status_filter', 'page'))) }}"
                       class="text-decoration-none">
                        <div class="room-card card {{ $currentFilter === $status ? 'border-primary' : '' }}">
                            <div class="card-body text-center">
                                <h3 class="mb-2">{{ $data['count'] }}</h3>
                                <p class="text-muted mb-0">{{ $data['label'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Room Cards View -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="management-card card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">All Rooms</h5>
                        <div>
                            @if (in_array(auth()->user()->role, ['admin', 'resepsionis']))
                                <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                    <i class="fas fa-plus"></i> Add Room
                                </button>
                            @endif
                            <div class="btn-group ms-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route($prefix . '.rooms.index', ['status_filter' => 'all']) }}">All Rooms</a></li>
                                    <li><a class="dropdown-item" href="{{ route($prefix . '.rooms.index', ['status_filter' => 'tersedia']) }}">Available Only</a></li>
                                    <li><a class="dropdown-item" href="{{ route($prefix . '.rooms.index', ['status_filter' => 'terisi']) }}">Occupied</a></li>
                                    <li><a class="dropdown-item" href="{{ route($prefix . '.rooms.index', ['status_filter' => 'maintenance']) }}">In Maintenance</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    @foreach($tipeKamar as $tipe)
                                        <li><a class="dropdown-item" href="#">{{ $tipe->tipe_kamar }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($rooms->isEmpty())
                            <div class="alert alert-warning text-center rounded-pill shadow-sm">
                                <i class="fas fa-exclamation-triangle me-1"></i> Tidak ada kamar ditemukan.
                            </div>
                        @else
                            <div class="row">
                                @foreach($rooms as $room)
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="room-card card">
                                            <img src="{{ $room->photo ? asset('image/' . $room->photo) : 'https://via.placeholder.com/800x600?text=No+Image' }}" class="card-img-top" alt="Room Image">
                                            <div class="card-body">
                                                <h5 class="room-title mb-1">{{ $room->tipeKamar?->tipe_kamar ?? 'Tipe tidak ditemukan' }} {{ $room->number }}</h5>
                                                <p class="room-type text-muted mb-1">{{ ucfirst($room->tipeKamar?->tipe_kamar ?? '-') }}</p>
                                                <p class="room-price fw-semibold text-primary mb-2">Rp {{ number_format($room->price, 0, ',', '.') }} / night</p>
                                                <div class="room-meta text-muted small">
                                                    <span><i class="fas fa-bed me-1"></i> {{ $room->bed_type ?? 'N/A' }}</span><br>
                                                    <span><i class="fas fa-expand me-1"></i> {{ $room->room_size ?? 'N/A' }} m²</span>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                                <span class="status-badge {{
                                                    $room->status === 'tersedia' ? 'available' :
                                                    ($room->status === 'terisi' ? 'booked' :
                                                    ($room->status === 'maintenance' ? 'maintenance' :
                                                    ($room->status === 'dipesan' ? 'reserved' : '')))
                                                }}">
                                                    {{
                                                        $room->status === 'tersedia' ? 'Available' :
                                                        ($room->status === 'terisi' ? 'Booked' :
                                                        ($room->status === 'maintenance' ? 'Maintenance' :
                                                        ($room->status === 'dipesan' ? 'Reserved' : ucfirst($room->status))))
                                                    }}
                                                </span>
                                                <button class="btn btn-outline-primary btn-sm edit-room-btn"
                                                        data-room-id="{{ $room->id }}"
                                                        style="padding: 4px 10px; font-size: 0.85rem;">
                                                    Manage
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Management Tables -->
        <div class="row">
            <div class="col-lg-8">
                <div class="management-card card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Room Inventory</h5>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="window.location.reload()">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
<button class="btn btn-sm btn-outline-secondary" onclick="printRoomInventory()">
    <i class="fas fa-print me-1"></i> Print
</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="room-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Room No.</th>
                                        <th>Type</th>
                                        <th>Features</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $room)
                                        <tr>
                                            <td>{{ $room->number }}</td>
                                            <td>{{ $room->tipeKamar?->tipe_kamar ?? '-' }}</td>
                                            <td>
                                                <div class="room-features">
                                                    @if($room->bed_type)
                                                        <span class="room-feature">{{ $room->bed_type }}</span>
                                                    @endif
                                                    @if($room->room_size)
                                                        <span class="room-feature">{{ $room->room_size }} m²</span>
                                                    @endif
                                                    @if($room->features)
                                                        @foreach(json_decode($room->features) as $feature)
                                                            <span class="room-feature">{{ trim($feature) }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="status-badge {{
                                                    $room->status === 'tersedia' ? 'available' :
                                                    ($room->status === 'terisi' ? 'booked' :
                                                    ($room->status === 'maintenance' ? 'maintenance' :
                                                    ($room->status === 'dipesan' ? 'reserved' : '')))
                                                }}">
                                                    {{
                                                        $room->status === 'tersedia' ? 'Available' :
                                                        ($room->status === 'terisi' ? 'Booked' :
                                                        ($room->status === 'maintenance' ? 'Maintenance' :
                                                        ($room->status === 'dipesan' ? 'Reserved' : ucfirst($room->status))))
                                                    }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1 edit-room-btn" data-room-id="{{ $room->id }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route($prefix . '.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
<!-- Room Status Overview -->
<div class="management-card card mb-4">
    <div class="card-header">
        <h5 class="card-title">Room Status Overview</h5>
    </div>
    <div class="card-body">
        <canvas id="roomStatusChart" height="250"></canvas>
    </div>
</div>

                <!-- Room Types Table -->
                <div class="management-card card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Room Types</h5>
                        @if (auth()->user()->role === 'admin')
@if (auth()->user()->role === 'admin')
    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRoomTypeModal">
        <i class="fas fa-plus me-1"></i> Add Type
    </button>
@endif
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="room-table">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Total Rooms</th>
                                        <th>Base Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roomTypes as $type)
                                        <tr>
                                            <td>{{ $type->tipe_kamar ?? 'N/A' }}</td>
                                            <td>{{ $type->jumlah_kamar ?? 0 }}</td>
                                            <td>
                                                @if($type->price)
                                                    Rp {{ number_format($type->price, 0, ',', '.') }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Room Type Modal -->
<div class="modal fade" id="addRoomTypeModal" tabindex="-1" aria-labelledby="addRoomTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomTypeModalLabel">Add New Room Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRoomTypeForm" method="POST" action="{{ route('admin.tipe_kamar.save') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipe_kamar" class="form-label">Type Name *</label>
                        <input type="text" class="form-control" name="tipe_kamar" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Base Rate (Rp) *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kapasitas" class="form-label">Max Capacity *</label>
                            <input type="number" class="form-control" name="kapasitas" min="1" max="10" value="2" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_kamar" class="form-label">Total Rooms *</label>
                        <input type="number" class="form-control" name="jumlah_kamar" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Standard Features</label>
                        <select class="form-select" name="fitur[]" multiple size="5">
                            <option value="Air Conditioning">Air Conditioning</option>
                            <option value="TV">TV</option>
                            <option value="Minibar">Minibar</option>
                            <option value="Safe">Safe</option>
                            <option value="Balcony">Balcony</option>
                            <option value="Sea View">Sea View</option>
                            <option value="Bathtub">Bathtub</option>
                            <option value="Jacuzzi">Jacuzzi</option>
                            <option value="WiFi">WiFi</option>
                            <option value="Room Service">Room Service</option>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Room Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Room Type Modal -->
<div class="modal fade" id="editRoomTypeModal" tabindex="-1" aria-labelledby="editRoomTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomTypeModalLabel">Edit Room Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoomTypeForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_room_type_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tipe_kamar" class="form-label">Type Name *</label>
                        <input type="text" class="form-control" name="tipe_kamar" id="edit_tipe_kamar" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label">Base Rate (Rp) *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" class="form-control" name="price" id="edit_price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_kapasitas" class="form-label">Max Capacity *</label>
                            <input type="number" class="form-control" name="kapasitas" id="edit_kapasitas" min="1" max="10" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_kamar" class="form-label">Total Rooms *</label>
                        <input type="number" class="form-control" name="jumlah_kamar" id="edit_jumlah_kamar" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Standard Features</label>
                        <select class="form-select" name="fitur[]" id="edit_fitur" multiple size="5">
                            <option value="Air Conditioning">Air Conditioning</option>
                            <option value="TV">TV</option>
                            <option value="Minibar">Minibar</option>
                            <option value="Safe">Safe</option>
                            <option value="Balcony">Balcony</option>
                            <option value="Sea View">Sea View</option>
                            <option value="Bathtub">Bathtub</option>
                            <option value="Jacuzzi">Jacuzzi</option>
                            <option value="WiFi">WiFi</option>
                            <option value="Room Service">Room Service</option>
                        </select>
                        <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Room Type</button>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>
        </div>

<!-- Room Calendar -->
<div class="row mt-4">
    <div class="col-12">
        <div class="management-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Room Availability Calendar</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="calendarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="calendarDropdown">
                        <li><a class="dropdown-item" href="?year={{ $prevYear }}&month={{ $prevMonth }}">Previous Month</a></li>
                        <li><a class="dropdown-item" href="?year={{ $year }}&month={{ $month }}">Current Month</a></li>
                        <li><a class="dropdown-item" href="?year={{ $nextYear }}&month={{ $nextMonth }}">Next Month</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="calendar-container">
                    <div id="roomCalendar"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="roomForm" action="{{ route($prefix . '.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="number" class="form-label">Room Number *</label>
                                <input type="text" class="form-control" id="number" name="number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipe_kamar_id" class="form-label">Room Type *</label>
                                <select class="form-select" id="tipe_kamar_id" name="tipe_kamar_id" required>
                                    <option value="">Select Type</option>
                                    @foreach($tipeKamar as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->tipe_kamar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="floor" class="form-label">Floor *</label>
                                <input type="number" class="form-control" id="floor" name="floor" min="1" max="20" required>
                            </div>
                            <div class="col-md-6">
                                <label for="room_size" class="form-label">Room Size (m²)</label>
                                <input type="number" class="form-control" id="room_size" name="room_size" step="0.01">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bed_type" class="form-label">Bed Type</label>
                                <select class="form-select" id="bed_type" name="bed_type">
                                    <option value="">Select Bed Type</option>
                                    <option value="Single">Single</option>
                                    <option value="Queen">Queen</option>
                                    <option value="King">King</option>
                                    <option value="Twin">Twin</option>
                                    <option value="Double">Double</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="max_occupancy" class="form-label">Max Occupancy *</label>
                                <input type="number" class="form-control" id="max_occupancy" name="max_occupancy" min="1" max="10" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Room Features</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Air Conditioning" id="airConditioning">
                                        <label class="form-check-label" for="airConditioning">Air Conditioning</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="TV" id="tv">
                                        <label class="form-check-label" for="tv">TV</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Minibar" id="minibar">
                                        <label class="form-check-label" for="minibar">Minibar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="WiFi" id="wifi">
                                        <label class="form-check-label" for="wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Safe" id="safe">
                                        <label class="form-check-label" for="safe">Safe</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Balcony" id="balcony">
                                        <label class="form-check-label" for="balcony">Balcony</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Sea View" id="seaView">
                                        <label class="form-check-label" for="seaView">Sea View</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Room Service" id="roomService">
                                        <label class="form-check-label" for="roomService">Room Service</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">Base Rate (per night) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Room Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="tersedia">Available</option>
                                    <option value="terisi">Occupied</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="dipesan">Reserved</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">Room Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div class="form-text">Upload new photo to replace current one</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editRoomForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_number" class="form-label">Room Number *</label>
                                <input type="text" class="form-control" id="edit_number" name="number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_tipe_kamar_id" class="form-label">Room Type *</label>
                                <select class="form-select" id="edit_tipe_kamar_id" name="tipe_kamar_id" required>
                                    <option value="">Select Type</option>
                                    @foreach($tipeKamar as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->tipe_kamar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_floor" class="form-label">Floor *</label>
                                <input type="number" class="form-control" id="edit_floor" name="floor" min="1" max="20" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_room_size" class="form-label">Room Size (m²)</label>
                                <input type="number" class="form-control" id="edit_room_size" name="room_size" step="0.01">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_bed_type" class="form-label">Bed Type</label>
                                <select class="form-select" id="edit_bed_type" name="bed_type">
                                    <option value="">Select Bed Type</option>
                                    <option value="Single">Single</option>
                                    <option value="Queen">Queen</option>
                                    <option value="King">King</option>
                                    <option value="Twin">Twin</option>
                                    <option value="Double">Double</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_max_occupancy" class="form-label">Max Occupancy *</label>
                                <input type="number" class="form-control" id="edit_max_occupancy" name="max_occupancy" min="1" max="10" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Room Features</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Air Conditioning" id="edit_airConditioning">
                                        <label class="form-check-label" for="edit_airConditioning">Air Conditioning</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="TV" id="edit_tv">
                                        <label class="form-check-label" for="edit_tv">TV</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Minibar" id="edit_minibar">
                                        <label class="form-check-label" for="edit_minibar">Minibar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="WiFi" id="edit_wifi">
                                        <label class="form-check-label" for="edit_wifi">WiFi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Safe" id="edit_safe">
                                        <label class="form-check-label" for="edit_safe">Safe</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Balcony" id="edit_balcony">
                                        <label class="form-check-label" for="edit_balcony">Balcony</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Sea View" id="edit_seaView">
                                        <label class="form-check-label" for="edit_seaView">Sea View</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="Room Service" id="edit_roomService">
                                        <label class="form-check-label" for="edit_roomService">Room Service</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_price" class="form-label">Base Rate (per night) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_status" class="form-label">Room Status *</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="tersedia">Available</option>
                                    <option value="terisi">Occupied</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="dipesan">Reserved</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_photo" class="form-label">Room Photo</label>
                            <input type="file" class="form-control" id="edit_photo" name="photo" accept="image/*">
                            <div class="form-text">Upload new photo to replace current one</div>
                            
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_gambar" id="edit_hapus_gambar">
                                <label class="form-check-label text-danger" for="edit_hapus_gambar">
                                    Delete current photo
                                </label>
                            </div>
                            <div id="edit_current_photo" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manage Room Modal -->
    <div class="modal fade" id="manageRoomModal" tabindex="-1" aria-labelledby="manageRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageRoomModalLabel">Manage Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Room Details Display -->
                    <div id="roomDetails" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="room-image-container text-center mb-3">
                                    <img id="manage_room_photo" src="" alt="Room Photo" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 id="manage_room_name" class="text-primary"></h4>
                                <p class="text-muted mb-2" id="manage_room_type"></p>
                                <p class="fw-bold mb-2" id="manage_room_price"></p>
                                <div class="mb-2">
                                    <span class="badge" id="manage_room_status"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Room Number:</strong> <span id="manage_room_number"></span></p>
                                <p><strong>Floor:</strong> <span id="manage_room_floor"></span></p>
                                <p><strong>Room Size:</strong> <span id="manage_room_size"></span> m²</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Bed Type:</strong> <span id="manage_room_bed"></span></p>
                                <p><strong>Max Occupancy:</strong> <span id="manage_room_occupancy"></span></p>
                                <p><strong>Capacity:</strong> <span id="manage_room_capacity"></span></p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <strong>Features:</strong>
                            <div id="manage_room_features" class="mt-1"></div>
                        </div>
                        
                        <div class="mt-3">
                            <strong>Description:</strong>
                            <p id="manage_room_description" class="mt-1"></p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions mb-4">
                        <h6 class="border-bottom pb-2">Quick Actions</h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <button class="btn btn-outline-primary w-100 btn-sm" onclick="openEditModal()">
                                    <i class="fas fa-edit me-1"></i> Edit Room
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-outline-warning w-100 btn-sm" onclick="changeRoomStatus()">
                                    <i class="fas fa-sync me-1"></i> Change Status
                                </button>
                            </div>
                            <div class="col-md-4">
                                <form id="quickDeleteForm" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="confirmDelete()">
                                        <i class="fas fa-trash me-1"></i> Delete Room
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Booking History (Optional) -->
                    <div class="booking-history">
                        <h6 class="border-bottom pb-2">Recent Bookings</h6>
                        <div id="bookingHistory">
                            <p class="text-muted">Loading booking history...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="openEditModal()">
                        <i class="fas fa-edit me-1"></i> Edit Room
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing room management...');

        const baseUrl = '{{ url("/") }}';
        const prefix = '{{ $prefix }}';
        let currentRoomId = null;

        // Handle Manage buttons
        const manageButtons = document.querySelectorAll('.edit-room-btn');
        console.log('Found manage buttons:', manageButtons.length);
        
        manageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const roomId = this.getAttribute('data-room-id');
                console.log('Manage button clicked for room ID:', roomId);
                currentRoomId = roomId;
                openManageModal(roomId);
            });
        });

        // Open Manage Modal
        async function openManageModal(roomId) {
            try {
                const url = `/${prefix}/rooms/${roomId}/edit-data`;
                console.log('Fetching room data from:', url);
                
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const room = await response.json();
                console.log('Room data received:', room);
                
                // Populate manage modal
                populateManageModal(room);
                
                // Set delete form action
                document.getElementById('quickDeleteForm').action = `${baseUrl}/${prefix}/rooms/${roomId}`;
                
                // Show manage modal
                const manageModal = new bootstrap.Modal(document.getElementById('manageRoomModal'));
                manageModal.show();
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error loading room data: ' + error.message);
            }
        }

        // Populate Manage Modal with room data
        function populateManageModal(room) {
            // Basic info
            document.getElementById('manage_room_name').textContent = `${room.tipe_kamar?.tipe_kamar || 'Room'} ${room.number}`;
            document.getElementById('manage_room_type').textContent = room.tipe_kamar?.tipe_kamar || 'N/A';
            document.getElementById('manage_room_price').textContent = `Rp ${formatNumber(room.price)} / night`;
            document.getElementById('manage_room_number').textContent = room.number;
            document.getElementById('manage_room_floor').textContent = room.floor || 'N/A';
            document.getElementById('manage_room_size').textContent = room.room_size || 'N/A';
            document.getElementById('manage_room_bed').textContent = room.bed_type || 'N/A';
            document.getElementById('manage_room_occupancy').textContent = room.max_occupancy || 'N/A';
            document.getElementById('manage_room_capacity').textContent = room.capacity || 'N/A';
            document.getElementById('manage_room_description').textContent = room.description || 'No description';

            // Status badge
            const statusBadge = document.getElementById('manage_room_status');
            statusBadge.textContent = getStatusText(room.status);
            statusBadge.className = `badge ${getStatusClass(room.status)}`;

            // Photo
            const roomPhoto = document.getElementById('manage_room_photo');
            if (room.photo) {
                roomPhoto.src = `${baseUrl}/image/${room.photo}`;
                roomPhoto.style.display = 'block';
            } else {
                roomPhoto.src = 'https://via.placeholder.com/300x200?text=No+Image';
                roomPhoto.style.display = 'block';
            }

            // Features
            const featuresContainer = document.getElementById('manage_room_features');
            const features = room.features || [];
            if (features && features.length > 0) {
                featuresContainer.innerHTML = features.map(feature => 
                    `<span class="badge bg-light text-dark me-1 mb-1">${feature}</span>`
                ).join('');
            } else {
                featuresContainer.innerHTML = '<span class="text-muted">No features</span>';
            }
        }

        // Open Edit Modal from Manage Modal
        window.openEditModal = async function() {
            if (!currentRoomId) return;
            
            try {
                const url = `${baseUrl}/${prefix}/rooms/${currentRoomId}/edit-data`;
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                
                const room = await response.json();
                
                // Populate edit form
                populateEditForm(room);
                
                // Close manage modal and open edit modal
                const manageModal = bootstrap.Modal.getInstance(document.getElementById('manageRoomModal'));
                if (manageModal) manageModal.hide();
                
                const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
                editModal.show();
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error loading room data for edit: ' + error.message);
            }
        }

        // Populate Edit Form
        function populateEditForm(room) {
            document.getElementById('edit_number').value = room.number || '';
            document.getElementById('edit_tipe_kamar_id').value = room.tipe_kamar_id || '';
            document.getElementById('edit_floor').value = room.floor || '';
            document.getElementById('edit_room_size').value = room.room_size || '';
            document.getElementById('edit_bed_type').value = room.bed_type || '';
            document.getElementById('edit_max_occupancy').value = room.max_occupancy || '';
            document.getElementById('edit_price').value = room.price || '';
            document.getElementById('edit_status').value = room.status || 'tersedia';
            document.getElementById('edit_description').value = room.description || '';
            
            // Set features checkboxes
            document.querySelectorAll('#editRoomForm input[name="features[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            const features = room.features || [];
            if (Array.isArray(features)) {
                features.forEach(feature => {
                    const checkbox = document.querySelector(`#editRoomForm input[name="features[]"][value="${feature}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            }
            
            // Set current photo
            const currentPhotoDiv = document.getElementById('edit_current_photo');
            if (room.photo) {
                currentPhotoDiv.innerHTML = `
                    <small class="text-muted">Current Photo:</small><br>
                    <img src="${baseUrl}/image/${room.photo}" alt="Current Room Photo" style="max-width: 200px; max-height: 150px;" class="mt-1 border rounded">
                `;
            } else {
                currentPhotoDiv.innerHTML = '<small class="text-muted">No current photo</small>';
            }
            
            // Set form action
            document.getElementById('editRoomForm').action = `${baseUrl}/${prefix}/rooms/${currentRoomId}`;
            
            // Reset hapus gambar checkbox
            document.getElementById('edit_hapus_gambar').checked = false;
        }

        // Change Room Status - Simple implementation
        window.changeRoomStatus = function() {
            const newStatus = prompt('Enter new status (tersedia/terisi/maintenance/dipesan):');
            if (newStatus && ['tersedia', 'terisi', 'maintenance', 'dipesan'].includes(newStatus)) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `${baseUrl}/${prefix}/rooms/${currentRoomId}`;
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="${newStatus}">
                    <input type="hidden" name="quick_status_change" value="1">
                `;
                document.body.appendChild(form);
                form.submit();
            } else if (newStatus) {
                alert('Invalid status! Use: tersedia, terisi, maintenance, or dipesan');
            }
        }

        // Confirm Delete
        window.confirmDelete = function() {
            if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
                document.getElementById('quickDeleteForm').submit();
            }
        }

        // Helper functions
        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        function getStatusText(status) {
            const statusMap = {
                'tersedia': 'Available',
                'terisi': 'Occupied', 
                'maintenance': 'Maintenance',
                'dipesan': 'Reserved'
            };
            return statusMap[status] || status;
        }

        function getStatusClass(status) {
            const classMap = {
                'tersedia': 'bg-success',
                'terisi': 'bg-danger',
                'maintenance': 'bg-warning',
                'dipesan': 'bg-info'
            };
            return classMap[status] || 'bg-secondary';
        }

        // Form validation
        const roomForm = document.getElementById('roomForm');
        if (roomForm) {
            roomForm.addEventListener('submit', function(e) {
                if (!validateForm(this)) e.preventDefault();
            });
        }

        const editRoomForm = document.getElementById('editRoomForm');
        if (editRoomForm) {
            editRoomForm.addEventListener('submit', function(e) {
                if (!validateForm(this)) e.preventDefault();
            });
        }

        function validateForm(form) {
            const required = form.querySelectorAll('[required]');
            let valid = true;
            
            required.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                alert('Please fill in all required fields');
            }
            
            return valid;
        }

        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    });

 document.addEventListener('DOMContentLoaded', function() {
    const bookings = @json($bookingsByDate ?? []);
    const events = [];

    for (const [date, bookingsList] of Object.entries(bookings)) {
        if (Array.isArray(bookingsList)) {
            bookingsList.forEach(booking => {
                let color = '#6b7280';
                let title = 'Unknown';

                if (booking.guest?.name) {
                    const roomNum = booking.room?.number ? ` ${booking.room.number}` : '';
                    const roomType = booking.room?.tipeKamar?.tipe_kamar || 'Room';
                    title = `${booking.guest.name} - ${roomType}${roomNum}`;
                }

                if (['booked', 'confirmed', 'dipesan'].includes(booking.status)) {
                    color = '#3b82f6';
                } else if (['checked_in', 'terisi'].includes(booking.status)) {
                    color = '#10b981';
                } else if (booking.status === 'maintenance') {
                    color = '#f59e0b';
                    title = `Maintenance - ${booking.room?.number || 'Room'}`;
                }

                events.push({
                    title: title,
                    start: date,
                    end: date,
                    allDay: true,
                    color: color
                });
            });
        }
    }

    const calendarEl = document.getElementById('roomCalendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events,
        allDaySlot: true, // ✅ INI YANG AKTIFKAN TAMPILAN DI VIEW DAY
        displayEventTime: false,
        height: 'auto',
        locale: 'id'
    });

    calendar.render();
});

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('roomStatusChart').getContext('2d');

    // Ambil data dari perhitungan yang sudah ada di Blade
    const available = {{ $rooms->where('status', 'tersedia')->count() }};
    const booked = {{ $rooms->where('status', 'terisi')->count() }};
    const maintenance = {{ $rooms->where('status', 'maintenance')->count() }};
    const reserved = {{ $rooms->where('status', 'dipesan')->count() }};

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Booked', 'Maintenance', 'Reserved'],
            datasets: [{
                data: [available, booked, maintenance, reserved],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // success (Available)
                    'rgba(239, 68, 68, 0.8)',   // danger (Booked)
                    'rgba(245, 158, 11, 0.8)',  // warning (Maintenance)
                    'rgba(59, 130, 246, 0.8)'   // info (Reserved)
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',

                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} rooms (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
});


</script>
@endsection