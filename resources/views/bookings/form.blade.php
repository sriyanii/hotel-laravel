@extends('layouts.adminlte')

@section('title', 'Tambah Booking')
@php use Illuminate\Support\Facades\Auth; @endphp
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0 fw-bold text-primary">
                <i class="fas fa-bed me-2"></i>Tambah Booking
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route(auth()->user()->role . '.bookings.store') }}" method="POST">
                @csrf

                {{-- TAMU --}}
                <div class="mb-3">
                    <label for="guest_id" class="form-label">Pilih Tamu</label>
                    <select name="guest_id" id="guest_id" class="form-select">
                        <option value="">-- Pilih Tamu Terdaftar --</option>
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}">{{ $guest->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- TAMBAH TAMU BARU --}}
                <div class="mb-3">
                    <label for="new_guest_name" class="form-label">Atau Tambah Tamu Baru</label>
                    <input type="text" name="new_guest_name" id="new_guest_name" class="form-control" placeholder="Contoh: Andi Wijaya">
                    <div class="form-text">Isi jika tamu belum terdaftar.</div>
                </div>


                {{-- KAMAR --}}
                <div class="mb-3">
                    <label for="room_id" class="form-label">Pilih Kamar</label>
                    <select name="room_id" id="room_id" class="form-select" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                {{ $room->number }} - {{ $room->type }} (Rp{{ number_format($room->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- CHECK-IN / OUT --}}
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="check_in" class="form-label">Check-In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="check_out" class="form-label">Check-Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                {{-- TOTAL HARGA --}}
                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Harga</label>
                    <input type="text" name="total_price" id="total_price" class="form-control bg-light" readonly>
                </div>

                {{-- PENANGGUNG JAWAB --}}
                <div class="mb-3">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status Booking</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Booked" selected>Booked</option>
                        <option value="Check-In">Check-In</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <button type="button" id="editBtn" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i> Ubah Data Booking
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    const roomSelect = document.getElementById('room_id');
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const totalPriceInput = document.getElementById('total_price');
    const editBtn = document.getElementById('editBtn');
    let isEditing = false;

    function calculateTotalPrice() {
        const roomOption = roomSelect.options[roomSelect.selectedIndex];
        const price = parseFloat(roomOption.getAttribute('data-price') || 0);

        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (!isNaN(checkIn.getTime()) && !isNaN(checkOut.getTime()) && checkOut > checkIn) {
            const nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
            const total = nights * price;
            totalPriceInput.value = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        } else {
            totalPriceInput.value = '';
        }
    }

    [roomSelect, checkInInput, checkOutInput].forEach(input => {
        input.addEventListener('change', calculateTotalPrice);
    });

    editBtn.addEventListener('click', () => {
        isEditing = !isEditing;

        checkInInput.readOnly = !isEditing;
        checkOutInput.readOnly = !isEditing;
        roomSelect.disabled = !isEditing;

        editBtn.textContent = isEditing ? 'Selesai Mengedit' : 'Ubah Data Booking';

        if (!isEditing) {
            calculateTotalPrice();
        }
    });

    checkInInput.addEventListener('change', function () {
        checkOutInput.min = checkInInput.value;
    });
</script>
@endsection
