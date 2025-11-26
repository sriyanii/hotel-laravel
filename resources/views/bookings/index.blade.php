@extends('layouts.adminlte')
@section('title', 'Daftar Booking')

@section('content')

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
        
        /* Header Styles */
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
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            text-align: center;
            transition: all 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary);
        }
        .stats-card p {
            color: #6b7280;
            margin-bottom: 0;
            font-size: 14px;
        }
        
/* Calendar Cards */
        .calendar-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            height: auto;
            overflow: visible;
            display: flex;
            flex-direction: column;

        }
        .calendar-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        .calendar-card .card-title {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }
        
        /* Calendar Container */
        .calendar-container {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            height: auto;
            flex: 1
        }
        
        /* Booking Status Badge */
        .booking-status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .booking-status.confirmed {
            background-color: #ecfdf5;
            color: var(--success);
        }
        .booking-status.pending {
            background-color: #fffbeb;
            color: var(--warning);
        }
        .booking-status.canceled {
            background-color: #fef2f2;
            color: var(--danger);
        }
        .booking-status.checked-in {
            background-color: #eff6ff;
            color: var(--info);
        }
        .booking-status.checked-out {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        /* Guest Avatar */
        .guest-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 15px;
            }
            .header h2 {
                font-size: 1.5rem;
            }
            .stats-card h3 {
                font-size: 1.5rem;
            }
        }
    </style>

<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-calendar-alt me-2"></i> Bookings Management</h2>

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

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <h3>{{ $stats['confirmed'] ?? 0 }}</h3>
                <p>Confirmed</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
                <p>Pending</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <h3>{{ $stats['checked_in'] ?? 0 }}</h3>
                <p>Checked in</p>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
 
        <!-- Booking Calendar -->
        <div class="col-lg-12">
            <div class="calendar-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Booking Calendar</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="calendarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="calendarDropdown">
                            <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['year' => $prevDate->year, 'month' => $prevDate->month]) }}">{{ $prevDate->format('F Y') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['year' => $year, 'month' => $month]) }}">{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['year' => $nextDate->year, 'month' => $nextDate->month]) }}">{{ $nextDate->format('F Y') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <div id="bookingCalendar"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>

<!-- Recent Bookings Table -->
    <div class="row">
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="calendar-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Recent Bookings</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#newBookingModal">
                            <i class="fas fa-plus me-1"></i> New Booking
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index') }}">All Bookings</a></li>
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['status' => 'confirmed']) }}">Confirmed</a></li>
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['status' => 'booked']) }}">Pending</a></li>
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['status' => 'canceled']) }}">Canceled</a></li>
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['status' => 'checked_in']) }}">Checked In</a></li>
                                <li><a class="dropdown-item" href="{{ route(auth()->user()->role . '.bookings.index', ['status' => 'checked_out']) }}">Checked Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success rounded-pill px-4 py-2 mb-0">
                            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if($bookings->isEmpty())
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-bed fa-2x mb-3"></i><br>
                            No bookings found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 mx-3">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Guest</th>
                                        <th>Room</th>
                                        <th>Dates</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $booking->guest->photo ? asset('image/' . $booking->guest->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->guest->name) }}"
                                                         class="guest-avatar"
                                                         alt="{{ $booking->guest->name }}">
                                                    <span>{{ $booking->guest->name ?? 'Guest' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $booking->room->tipeKamar->tipe_kamar ?? 'N/A' }}<br>
                                                <small class="text-muted">Room {{ $booking->room->number }}</small>
                                            </td>
                                            <td>
                                                <small>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('d M') }}</small><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($booking->check_out)->diffInDays($booking->check_in) }} nights</small>
                                            </td>
                                            <td>
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($booking->status) {
                                                        'booked' => 'pending',
                                                        'confirmed' => 'confirmed',
                                                        'checked_in' => 'checked-in',
                                                        'checked_out' => 'checked-out',
                                                        'canceled' => 'canceled',
                                                        default => 'pending'
                                                    };
                                                @endphp
                                                <span class="booking-status {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route(auth()->user()->role . '.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary me-1">View</a>
                                                @if($booking->status === 'booked')
                                                    <form action="{{ route(auth()->user()->role . '.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-success">Confirm</button>
                                                    </form>
                                                @elseif($booking->status === 'confirmed')
                                                    <form action="{{ route(auth()->user()->role . '.bookings.checkin', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-success">Check In</button>
                                                    </form>
                                                @elseif($booking->status === 'checked_in')
                                                    <form action="{{ route(auth()->user()->role . '.bookings.checkout', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning">Check Out</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    


   

    <!-- Right Column: Today's Arrivals & Departures -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="calendar-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Today's Arrivals & Departures</h5>
                
            </div>
            <div class="card-body p-0">
                @if($todayArrivals->isEmpty() && $todayDepartures->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-bed fa-2x mb-3"></i><br>
                        No arrivals or departures today.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 mx-3">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>ROOM</th>
                                    <th>TIME</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Arrivals -->
                                @foreach($todayArrivals as $booking)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $booking->guest->photo ? asset('image/' . $booking->guest->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->guest->name) }}"
                                                     class="guest-avatar"
                                                     alt="{{ $booking->guest->name }}">
                                                <span>{{ $booking->guest->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $booking->room->tipeKamar->tipe_kamar ?? 'N/A' }}<br>
                                            <small class="text-muted">Room {{ $booking->room->number }}</small>
                                        </td>
                                        <td>
                                            <small>14:00</small> <!-- Jika tidak ada kolom waktu, gunakan default -->
                                        </td>
                                        <td>
                                            @if($booking->canCheckIn())
                                                <form action="{{ route(auth()->user()->role . '.bookings.checkin', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success">Check In</button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">Checked In</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Departures -->
                                @foreach($todayDepartures as $booking)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $booking->guest->photo ? asset('image/' . $booking->guest->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->guest->name) }}"
                                                     class="guest-avatar"
                                                     alt="{{ $booking->guest->name }}">
                                                <span>{{ $booking->guest->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $booking->room->tipeKamar->tipe_kamar ?? 'N/A' }}<br>
                                            <small class="text-muted">Room {{ $booking->room->number }}</small>
                                        </td>
                                        <td>
                                            <small>12:00</small> <!-- Jika tidak ada kolom waktu, gunakan default -->
                                        </td>
                                        <td>
                                            @if($booking->canCheckOut())
                                                <form action="{{ route(auth()->user()->role . '.bookings.checkout', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">Check Out</button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">Checked Out</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<!-- New Booking Modal -->
<div class="modal fade" id="newBookingModal" tabindex="-1" aria-labelledby="newBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newBookingModalLabel">Create New Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route(auth()->user()->role . '.bookings.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bookingGuest" class="form-label">Guest</label>
                            <select class="form-select" id="bookingGuest" name="guest_id" required>
                                <option value="">Select Guest</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="bookingSource" class="form-label">Booking Source</label>
                            <select class="form-select" id="bookingSource" name="booking_source">
                                <option value="">Select Source</option>
                                <option value="website">Website</option>
                                <option value="booking_com">Booking.com</option>
                                <option value="agoda">Agoda</option>
                                <option value="walk_in">Walk-in</option>
                                <option value="phone">Phone</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="checkInDate" class="form-label">Check-in Date</label>
                            <input type="date" class="form-control" id="checkInDate" name="check_in" required>
                        </div>
                        <div class="col-md-6">
                            <label for="checkOutDate" class="form-label">Check-out Date</label>
                            <input type="date" class="form-control" id="checkOutDate" name="check_out" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="adults" class="form-label">Adults</label>
                            <input type="number" class="form-control" id="adults" name="adults" min="1" value="1">
                        </div>
                        <div class="col-md-6">
                            <label for="children" class="form-label">Children</label>
                            <input type="number" class="form-control" id="children" name="children" min="0" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="roomSelection" class="form-label">Select Room</label>
                        <select class="form-select" id="roomSelection" name="room_id" size="5" required>
                            <option value="">Select Room</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nights" class="form-label">Nights</label>
                            <input type="text" class="form-control" id="nights" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="totalAmount" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="specialRequests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="specialRequests" name="special_requests" rows="2"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="confirmBooking" name="confirm_immediately" checked>
                        <label class="form-check-label" for="confirmBooking">Confirm booking immediately</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('bookingForm').submit()">Create Booking</button>
            </div>
        </div>
    </div>
</div>

<script>
    // FullCalendar untuk Booking Calendar
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('bookingCalendar');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents ?? []),
                eventClick: function(info) {
                    const bookingId = info.event.extendedProps?.booking_id;
                    if (bookingId) {
                        const role = "{{ auth()->user()->role }}";
                        window.location.href = `/${role}/bookings/${bookingId}`;
                    }
                },
                locale: 'id',
                height: 'auto'
            });
            calendar.render();
        }

        // FullCalendar untuk Room Availability Calendar
        const roomCalendarEl = document.getElementById('roomCalendar');
        if (roomCalendarEl) {
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

            const roomCalendar = new FullCalendar.Calendar(roomCalendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
                allDaySlot: true,
                displayEventTime: false,
                height: 'auto',
                locale: 'id'
            });

            roomCalendar.render();
        }

        // Load data on modal open
        $('#newBookingModal').on('show.bs.modal', function () {
            loadGuests();
            loadRooms();
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkInDate').min = today;
        });

        function loadGuests() {
            $.get("{{ route(auth()->user()->role . '.bookings.get-guests') }}", function(data) {
                const sel = $('#bookingGuest');
                sel.empty().append('<option value="">Select Guest</option>');
                data.guests.forEach(g => {
                    sel.append(`<option value="${g.id}">${g.name} (${g.phone})</option>`);
                });
            });
        }

        function loadRooms() {
            $.get("{{ route(auth()->user()->role . '.bookings.get-rooms') }}", function(data) {
                const sel = $('#roomSelection');
                sel.empty().append('<option value="">Select Room</option>');
                data.rooms.forEach(r => {
                    sel.append(`<option value="${r.id}" data-price="${r.price}">${r.tipe_kamar} - Room ${r.number} - Rp ${parseInt(r.price).toLocaleString('id-ID')}/night</option>`);
                });
            });
        }

        function calculateBooking() {
            const checkIn = new Date(document.getElementById('checkInDate').value);
            const checkOut = new Date(document.getElementById('checkOutDate').value);
            const roomSel = document.getElementById('roomSelection');
            const price = roomSel.selectedOptions[0]?.dataset.price || 0;
            if (checkIn && checkOut && checkOut > checkIn && price > 0) {
                const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                document.getElementById('nights').value = nights;
                document.getElementById('totalAmount').value = (nights * price).toLocaleString('id-ID');
            } else {
                document.getElementById('nights').value = '';
                document.getElementById('totalAmount').value = '';
            }
        }

        document.getElementById('checkInDate')?.addEventListener('change', calculateBooking);
        document.getElementById('checkOutDate')?.addEventListener('change', calculateBooking);
        document.getElementById('roomSelection')?.addEventListener('change', calculateBooking);
    });
</script>

@endsection