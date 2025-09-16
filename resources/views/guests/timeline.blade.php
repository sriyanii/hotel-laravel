@extends('layouts.adminlte')

@section('title', 'Timeline Pemesanan Kamar')

@section('content_header')
    <h1 class="fw-bold text-dark">
        <i class="fas fa-calendar-alt me-2 text-secondary"></i> Room Bookings
    </h1>
@stop

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-1"></i> Tidak ada pemesanan saat ini.
                </div>
            @else
                <?php
                    $now = \Carbon\Carbon::now();
                    $year = request('year', $now->year);
                    $month = request('month', $now->month);

                    $startOfMonth = \Carbon\Carbon::create($year, $month, 1)->startOfWeek(\Carbon\Carbon::MONDAY);
                    $endOfMonth = \Carbon\Carbon::create($year, $month, $now->daysInMonth)->endOfWeek(\Carbon\Carbon::SUNDAY);

                    // Kelompokkan booking per tanggal
                    $bookingsByDate = [];
                    foreach ($bookings as $booking) {
                        $checkIn = \Carbon\Carbon::parse($booking->check_in)->startOfDay();
                        $checkOut = \Carbon\Carbon::parse($booking->check_out)->startOfDay();

                        for ($date = $checkIn; $date->lte($checkOut); $date->addDay()) {
                            $dateKey = $date->toDateString();
                            if (!isset($bookingsByDate[$dateKey])) {
                                $bookingsByDate[$dateKey] = [];
                            }
                            $bookingsByDate[$dateKey][] = $booking;
                        }
                    }

                    // Navigasi bulan
                    $prevMonth = $month == 1 ? 12 : $month - 1;
                    $prevYear = $month == 1 ? $year - 1 : $year;
                    $nextMonth = $month == 12 ? 1 : $month + 1;
                    $nextYear = $month == 12 ? $year + 1 : $year;
                ?>

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">Room Bookings</h3>

                    <div class="d-flex align-items-center gap-2">
                        <a href="?year={{ $prevYear }}&month={{ $prevMonth }}" class="text-decoration-none text-dark">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <span class="fw-bold">{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}</span>
                        <a href="?year={{ $nextYear }}&month={{ $nextMonth }}" class="text-decoration-none text-dark">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Grid Kalender Modern -->
                <div class="d-grid gap-1" style="grid-template-columns: repeat(7, 1fr);">
                    <!-- Header Hari -->
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                        <div class="text-center fw-bold bg-light border py-2">{{ $day }}</div>
                    @endforeach

                    <?php
                        $current = $startOfMonth->copy();
                        $daysInCalendar = $startOfMonth->diffInDays($endOfMonth) + 1;
                    ?>

                    @for ($i = 0; $i < $daysInCalendar; $i++)
                        <?php
                            $dateKey = $current->toDateString();
                            $bookingsToday = $bookingsByDate[$dateKey] ?? [];
                            $hasBookings = count($bookingsToday) > 0;
                            $isCurrentMonth = $current->month == $month;
                        ?>
                        <div class="border p-2 d-flex flex-column justify-content-start"
                             style="min-height: 100px; background-color: {{ $isCurrentMonth ? '#fff' : '#f8f9fa' }}">
                            <div class="text-end fw-bold small mb-1">{{ $current->day }}</div>
                            @if($hasBookings)
                                @foreach($bookingsToday as $booking)
                                    <?php
                                        $statusClass = match($booking->status) {
                                            'booked', 'confirmed' => 'bg-warning',
                                            'checked_in' => 'bg-success',
                                            'checked_out' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    ?>
                                    <div class="d-flex flex-column align-items-start mb-1">
                                        <span class="badge rounded-pill {{ $statusClass }} text-white small"
                                              style="font-size: 0.75em; padding: 0.2em 0.5em;">
                                            {{ $booking->guest->name ?? 'Tamu Tanpa Nama' }}
                                        </span>
                                        <div class="text-muted" style="font-size: 0.7em;">
                                            @if($booking->room && $booking->room->tipeKamar)
                                                ({{ ucfirst($booking->room->tipeKamar->tipe_kamar) }})
                                            @else
                                                (Tipe Tidak Ditemukan)
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <?php $current->addDay(); ?>
                    @endfor
                </div>

                <div class="col-12 mt-3 text-end">
                    <a href="{{ route(auth()->user()->role.'.guests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-bed me-1"></i> Daftar Tamu
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection