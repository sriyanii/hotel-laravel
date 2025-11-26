@extends('layouts.adminlte')

@section('title', 'Room Status - HotelMaster')

    <style>
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
        
        /* Room Status Cards */
        .status-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .status-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .status-filter {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            background-color: white;
        }
        
        .status-filter:hover, .status-filter.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .room-search {
            position: relative;
            margin-bottom: 20px;
        }
        
        .room-search input {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .room-search i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #9ca3af;
        }
        
        /* Room Grid */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .room-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .room-card-header {
            position: relative;
            height: 120px;
            background-size: cover;
            background-position: center;
        }
        
        .room-status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-available {
            background-color: var(--success);
            color: white;
        }
        
        .status-occupied {
            background-color: var(--danger);
            color: white;
        }
        
        .status-maintenance {
            background-color: var(--warning);
            color: black;
        }
        
        .status-cleaning {
            background-color: var(--info);
            color: white;
        }
        
        .room-card-body {
            padding: 20px;
        }
        
        .room-type {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .room-number {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .room-features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .room-feature {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: #f3f4f6;
            color: #4b5563;
        }
        
        .room-price {
            font-weight: 700;
            font-size: 18px;
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        .room-price span {
            font-size: 14px;
            font-weight: 400;
            color: #6b7280;
        }
        
        .room-guest {
            display: flex;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
        }
        
        .guest-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .guest-info h6 {
            margin-bottom: 2px;
            font-size: 14px;
        }
        
        .guest-info p {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 0;
        }
        
        /* Room Details Modal */
        .room-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .room-modal .modal-footer {
            border-top: none;
            padding-top: 0;
        }
        
        .room-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .room-gallery img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .room-gallery img:hover {
            opacity: 0.8;
        }
        
        .room-details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .room-details-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
        }
        
        .room-details-list li:last-child {
            border-bottom: none;
        }
        
        .room-details-list .label {
            color: #6b7280;
        }
        
        .room-details-list .value {
            font-weight: 500;
        }
        
        /* Status Overview */
        .status-overview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .status-overview-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .status-overview-card .count {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .status-overview-card .label {
            color: #6b7280;
            font-size: 14px;
        }
        
        /* Floor Selector */
        .floor-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        
        .floor-btn {
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            background-color: white;
            white-space: nowrap;
        }
        
        .floor-btn:hover, .floor-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        
    </style>

@section('content')

    <!-- Header -->
    <div class="header">
        <h2><i class="fas fa-bed me-2"></i> Room Status</h2>
        <div class="user-menu">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->photo ? asset('images/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <span class="ms-2">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Status Overview -->
    <div class="status-overview">
        <div class="status-overview-card">
            <div class="count">{{ $roomStats['total'] }}</div>
            <div class="label">Total Rooms</div>
        </div>
        <div class="status-overview-card">
            <div class="count" style="color: var(--success);">{{ $roomStats['available'] }}</div>
            <div class="label">Available</div>
        </div>
        <div class="status-overview-card">
            <div class="count" style="color: var(--danger);">{{ $roomStats['occupied'] }}</div>
            <div class="label">Occupied</div>
        </div>
        <div class="status-overview-card">
            <div class="count" style="color: var(--warning);">{{ $roomStats['maintenance'] }}</div>
            <div class="label">Maintenance</div>
        </div>
        <div class="status-overview-card">
            <div class="count" style="color: var(--info);">{{ $roomStats['reserved'] }}</div>
            <div class="label">Reserved</div>
        </div>
    </div>

   <!-- Filters and Search -->
<div class="status-card">
    <div class="d-flex flex-column mb-4">
        
        <!-- Floor Selector di atas -->
        <div class="floor-selector mb-3">
            <button class="floor-btn active" data-floor="all">All Floors</button>
            @php
                $floors = $rooms->pluck('floor')->unique()->sort();
            @endphp
            @foreach($floors as $floor)
                <button class="floor-btn" data-floor="{{ $floor }}">{{ $floor }}th Floor</button>
            @endforeach
        </div>
        
        <!-- Search Bar di bawah dengan align-self-end -->
        <div class="room-search align-self-start">
            <i class="fas fa-search"></i>
            <input type="text" class="form-control" placeholder="Search rooms by number or type..." id="roomSearch">
        </div>
    </div>
    
    <div class="status-filters">
        <button class="status-filter active" data-filter="all">All Rooms</button>
        <button class="status-filter" data-filter="tersedia">Available</button>
        <button class="status-filter" data-filter="terisi">Occupied</button>
        <button class="status-filter" data-filter="maintenance">Maintenance</button>
        <button class="status-filter" data-filter="dipesan">Reserved</button>
    </div>
</div>
        
<!-- Room Grid -->
<div class="room-grid" id="roomGrid">
    @foreach($rooms as $room)
        <div class="room-card" data-status="{{ $room->status }}" data-floor="{{ $room->floor }}" data-room-id="{{ $room->id }}">
            <div class="room-card-header" style="background-image: url('{{ $room->photo ? asset('image/' . $room->photo) : 'https://images.unsplash.com/photo-1566669437685-2c5a1f510d3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}');">
                <span class="room-status-badge status-{{ $room->status === 'tersedia' ? 'available' : ($room->status === 'terisi' ? 'occupied' : ($room->status === 'maintenance' ? 'maintenance' : 'reserved')) }}">
                    {{ $room->status === 'tersedia' ? 'Available' : ($room->status === 'terisi' ? 'Occupied' : ($room->status === 'maintenance' ? 'Maintenance' : 'Reserved')) }}
                </span>
            </div>
            <div class="room-card-body">
                <div class="room-type">{{ $room->tipeKamar->tipe_kamar ?? $room->type ?? 'Standard Room' }}</div>
                <div class="room-number text-primary fw-bold">{{ $room->number }}</div>
                <div class="room-features">
                    @if($room->room_size)
                        <span class="room-feature">{{ $room->room_size }}m²</span>
                    @endif
                    @if($room->bed_type)
                        <span class="room-feature">{{ $room->bed_type }}</span>
                    @endif
                    @if($room->view)
                        <span class="room-feature">{{ $room->view }} View</span>
                    @endif
                    @if($room->beds)
                        <span class="room-feature">{{ $room->beds }} {{ $room->beds > 1 ? 'Beds' : 'Bed' }}</span>
                    @endif
                </div>
                <div class="room-price text-dark fw-bold">$ {{ number_format($room->price / 15000, 2) }} <span class="text-muted fw-normal">/ night</span></div>
                
                @if($room->status === 'terisi' && $room->currentBooking)
                    <div class="room-guest">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($room->currentBooking->guest->name) }}&background=random" alt="Guest" class="guest-avatar">
                        <div class="guest-info">
                            <h6 class="mb-1">{{ $room->currentBooking->guest->name }}</h6>
                            <p class="mb-0 text-muted small">Until {{ $room->currentBooking->check_out->format('d M') }}</p>
                        </div>
                    </div>
                @endif
                
                <button class="btn btn-outline-primary w-100 mt-3 view-room-details" 
                        data-room-id="{{ $room->id }}"
                        data-bs-toggle="modal" 
                        data-bs-target="#roomModal">
                    <i class=""></i>View Details
                </button>
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>

<!-- Room Details Modal -->
<div class="modal fade room-modal" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomModalLabel">
                    <i class="fas fa-bed me-2"></i>Room Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="roomModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading room details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Change Room Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeStatusForm">
                    @csrf
                    <input type="hidden" id="roomId" name="room_id">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Select Status</label>
                        <select class="form-select" id="statusSelect" name="status">
                            <option value="tersedia">Available</option>
                            <option value="terisi">Occupied</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="dipesan">Reserved</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveStatusBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// =============================================
// GLOBAL VARIABLES AND FUNCTIONS
// =============================================
let currentRoomId = null;

// Global function untuk membuka modal change status
window.changeRoomStatusModal = function(roomId) {
    currentRoomId = roomId;
    document.getElementById('roomId').value = roomId;
    
    // Get current room status and set it in the dropdown
    const roomCard = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
    if (roomCard) {
        const currentStatus = roomCard.getAttribute('data-status');
        const statusSelect = document.getElementById('statusSelect');
        if (statusSelect) {
            statusSelect.value = currentStatus;
        }
    }
    
    // Close current modal and open status modal
    const roomModal = bootstrap.Modal.getInstance(document.getElementById('roomModal'));
    if (roomModal) {
        roomModal.hide();
    }
    
    const statusModal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
    statusModal.show();
}

// Global function untuk change room status
window.changeRoomStatus = async function() {
    console.log('=== CHANGE ROOM STATUS DEBUG ===');
    console.log('changeRoomStatus function called');
    console.log('currentRoomId:', currentRoomId);
    
    if (!currentRoomId) {
        console.error('No room selected');
        alert('No room selected');
        return;
    }
    
    const statusSelect = document.getElementById('statusSelect');
    if (!statusSelect) {
        console.error('Status select element not found');
        alert('Status select element not found');
        return;
    }
    
    const status = statusSelect.value;
    
    // CARI CSRF TOKEN DENGAN CARA YANG LEBIH ROBUST
    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Jika tidak ditemukan di meta tag, coba cari di form
    if (!csrfToken) {
        const csrfInput = document.querySelector('input[name="_token"]');
        if (csrfInput) {
            csrfToken = csrfInput.value;
        }
    }
    
    console.log('Updating room', currentRoomId, 'to status:', status);
    console.log('CSRF Token:', csrfToken ? 'Found' : 'NOT FOUND');
    
    if (!csrfToken) {
        alert('CSRF token missing. Please refresh the page.');
        return;
    }
    
    try {
        console.log('Sending PUT request to:', `/resepsionis/room/${currentRoomId}/status`);
        
        const response = await fetch(`/resepsionis/room/${currentRoomId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                status: status
            })
        });
        
        console.log('Response status:', response.status);
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        console.log('Content-Type:', contentType);
        
        let result;
        if (contentType && contentType.includes('application/json')) {
            result = await response.json();
        } else {
            const text = await response.text();
            console.log('Non-JSON response:', text);
            throw new Error('Server returned non-JSON response: ' + text);
        }
        
        console.log('Server response:', result);
        
        if (response.ok) {
            console.log('Success! Room status updated');
            alert('Room status updated successfully!');
            
            // Close modal
            const statusModal = bootstrap.Modal.getInstance(document.getElementById('changeStatusModal'));
            if (statusModal) {
                statusModal.hide();
            }
            
            // Reload page to reflect changes
            location.reload();
        } else {
            console.error('Server returned error:', result);
            alert('Error changing room status: ' + (result.message || 'Unknown error'));
        }
        
    } catch (error) {
        console.error('Fetch error:', error);
        alert('Error changing room status: ' + error.message);
    }
}

// Global helper functions
window.getStatusColor = function(status) {
    const colorMap = {
        'tersedia': 'success',
        'terisi': 'danger',
        'maintenance': 'warning',
        'dipesan': 'info'
    };
    return colorMap[status] || 'secondary';
}

window.getStatusText = function(status) {
    const textMap = {
        'tersedia': 'Available',
        'terisi': 'Occupied',
        'maintenance': 'Maintenance',
        'dipesan': 'Reserved'
    };
    return textMap[status] || status;
}

window.formatNumber = function(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// =============================================
// DOM CONTENT LOADED
// =============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Room management script loaded successfully');

    // Filter buttons functionality
    const filterButtons = document.querySelectorAll('.status-filter');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            filterRooms(filter);
        });
    });
    

    // Floor selector functionality - SOLUSI YANG DIPERBAIKI
    const floorButtons = document.querySelectorAll('.floor-btn');
    floorButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Floor button clicked:', this.textContent);
            
            // Remove active class from all buttons
            floorButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get floor value from data attribute
            const floor = this.getAttribute('data-floor');
            console.log('Selected floor from data attribute:', floor);
            
            filterRoomsByFloor(floor);
        });
    });

    function filterRoomsByFloor(floor) {
        console.log('=== FILTER ROOMS BY FLOOR ===');
        console.log('Filtering for floor:', floor);
        
        const roomCards = document.querySelectorAll('.room-card');
        console.log('Total rooms found:', roomCards.length);
        
        let visibleCount = 0;
        
        roomCards.forEach((card, index) => {
            const cardFloor = card.getAttribute('data-floor');
            const roomId = card.getAttribute('data-room-id');
            const roomNumber = card.querySelector('.room-number')?.textContent || 'Unknown';
            
            console.log(`Room ${index + 1}: ID=${roomId}, Number=${roomNumber}, Floor=${cardFloor}`);
            
            // Show card if:
            // - floor is 'all' OR
            // - floor matches card's floor
            if (floor === 'all' || cardFloor === floor) {
                card.style.display = 'block';
                visibleCount++;
                console.log(`✓ SHOWING Room ${roomNumber} (Floor ${cardFloor})`);
            } else {
                card.style.display = 'none';
                console.log(`✗ HIDING Room ${roomNumber} (Floor ${cardFloor})`);
            }
        });
        
        console.log(`Total rooms visible: ${visibleCount}`);
        console.log('=== END FILTER ===');
    }

    // Room search functionality
    const roomSearch = document.querySelector('#roomSearch');
    if (roomSearch) {
        roomSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterRoomsBySearch(searchTerm);
        });
    }
    
    // View room details
    const viewButtons = document.querySelectorAll('.view-room-details');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            currentRoomId = roomId;
            loadRoomDetails(roomId);
        });
    });

    // Change status functionality - Event listener untuk Save button
    const saveStatusBtn = document.getElementById('saveStatusBtn');
    if (saveStatusBtn) {
        saveStatusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Save button clicked');
            changeRoomStatus(); // Sekarang fungsi ini global
        });
    }
    
    // Also allow form submission with Enter key
    const changeStatusForm = document.getElementById('changeStatusForm');
    if (changeStatusForm) {
        changeStatusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            changeRoomStatus();
        });
    }

    // Filter functions (bisa tetap di dalam DOMContentLoaded karena tidak dipanggil dari HTML)
    function filterRooms(status) {
        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(card => {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    function filterRoomsByFloor(floor) {
        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(card => {
            if (floor === 'All Floors' || card.getAttribute('data-floor') == floor) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    function filterRoomsBySearch(searchTerm) {
        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(card => {
            const roomNumber = card.querySelector('.room-number')?.textContent.toLowerCase();
            const roomType = card.querySelector('.room-type')?.textContent.toLowerCase();
            
            if ((roomNumber && roomNumber.includes(searchTerm)) || (roomType && roomType.includes(searchTerm))) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Load room details function
    async function loadRoomDetails(roomId) {
        try {
            console.log('Loading room details for ID:', roomId);
            
            // Show loading state
            const roomModalBody = document.getElementById('roomModalBody');
            if (roomModalBody) {
                roomModalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading room details...</p>
                    </div>
                `;
            }

            const response = await fetch(`/resepsionis/room/${roomId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const room = await response.json();
            console.log('Room data received:', room);
            
            // Process facilities and features
            let facilities = [];
            let features = [];
            
            try {
                facilities = typeof room.facilities === 'string' ? 
                            JSON.parse(room.facilities) : 
                            (Array.isArray(room.facilities) ? room.facilities : []);
            } catch (e) {
                console.warn('Error parsing facilities:', e);
                facilities = [];
            }
            
            try {
                features = typeof room.features === 'string' ? 
                          JSON.parse(room.features) : 
                          (Array.isArray(room.features) ? room.features : []);
            } catch (e) {
                console.warn('Error parsing features:', e);
                features = [];
            }
            
            // Get room type name
            const roomType = room.tipe_kamar ? room.tipe_kamar.tipe_kamar : (room.type || 'Standard Room');
            
            // Build the modal content
            const modalContent = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="room-image-container">
                            <img src="${room.photo ? '{{ asset("image/") }}/' + room.photo : 'https://images.unsplash.com/photo-1566669437685-2c5a1f510d3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'}" 
                                 alt="${roomType}" 
                                 class="img-fluid rounded mb-3" 
                                 style="height: 250px; width: 100%; object-fit: cover;">
                        </div>
                        
                        <!-- Quick Info Card -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Quick Info
                                </h6>
                                <div class="row small">
                                    <div class="col-6 mb-2">
                                        <strong>Floor:</strong><br>
                                        <span class="text-muted">${room.floor}th</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <strong>Capacity:</strong><br>
                                        <span class="text-muted">${room.capacity} Person${room.capacity > 1 ? 's' : ''}</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <strong>Max Occupancy:</strong><br>
                                        <span class="text-muted">${room.max_occupancy} Person${room.max_occupancy > 1 ? 's' : ''}</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <strong>Beds:</strong><br>
                                        <span class="text-muted">${room.beds} ${room.beds > 1 ? 'Beds' : 'Bed'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Header Section -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="text-primary mb-1">${roomType}</h4>
                                <h5 class="text-muted mb-2">Room ${room.number}</h5>
                                <span class="badge bg-${getStatusColor(room.status)} fs-6">
                                    ${getStatusText(room.status)}
                                </span>
                            </div>
                            <div class="text-end">
                                <h3 class="text-success mb-0">$ ${(room.price / 15000).toFixed(2)}</h3>
                                <small class="text-muted">per night</small>
                            </div>
                        </div>
                        
                        <!-- Room Specifications -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-ruler-combined me-2"></i>Room Specifications
                            </h6>
                            <div class="row small">
                                ${room.room_size ? `
                                <div class="col-6 mb-2">
                                    <strong>Size:</strong><br>
                                    <span class="text-muted">${room.room_size} m²</span>
                                </div>
                                ` : ''}
                                ${room.bed_type ? `
                                <div class="col-6 mb-2">
                                    <strong>Bed Type:</strong><br>
                                    <span class="text-muted">${room.bed_type}</span>
                                </div>
                                ` : ''}
                                ${room.view ? `
                                <div class="col-6 mb-2">
                                    <strong>View:</strong><br>
                                    <span class="text-muted">${room.view}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        
                        <!-- Facilities -->
                        ${facilities.length > 0 ? `
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-tv me-2"></i>Facilities
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                ${facilities.slice(0, 6).map(facility => `
                                    <span class="badge bg-light text-dark border small">${facility}</span>
                                `).join('')}
                                ${facilities.length > 6 ? `
                                    <span class="badge bg-secondary small">+${facilities.length - 6} more</span>
                                ` : ''}
                            </div>
                        </div>
                        ` : ''}
                        
                        <!-- Features -->
                        ${features.length > 0 ? `
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-star me-2"></i>Features
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                ${features.slice(0, 6).map(feature => `
                                    <span class="badge bg-light text-dark border small">${feature}</span>
                                `).join('')}
                                ${features.length > 6 ? `
                                    <span class="badge bg-secondary small">+${features.length - 6} more</span>
                                ` : ''}
                            </div>
                        </div>
                        ` : ''}
                        
                        <!-- Description -->
                        ${room.description ? `
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt me-2"></i>Description
                            </h6>
                            <p class="text-muted small">${room.description}</p>
                        </div>
                        ` : ''}
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary btn-lg" onclick="changeRoomStatusModal(${room.id})">
                                <i class="fas fa-sync-alt me-2"></i>Change Status
                            </button>
                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Close
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            if (roomModalBody) {
                roomModalBody.innerHTML = modalContent;
            }
            
        } catch (error) {
            console.error('Error loading room details:', error);
            const roomModalBody = document.getElementById('roomModalBody');
            if (roomModalBody) {
                roomModalBody.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error loading room details</strong><br>
                        <small class="text-muted">${error.message}</small>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary" onclick="loadRoomDetails(${roomId})">
                                <i class="fas fa-redo me-1"></i>Try Again
                            </button>
                        </div>
                    </div>
                `;
            }
        }
    }
});
</script>
@endpush