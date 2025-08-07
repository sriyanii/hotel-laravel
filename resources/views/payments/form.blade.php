@extends('layouts.adminlte')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<div class="container mt-4">
    <h1 class="mb-4">{{ $payment->exists ? 'Edit Transaksi' : 'Tambah Transaksi' }}</h1>

    <form action="{{ $action }}" method="POST">
        @csrf
        @if($payment->exists)
            @method('PUT')
        @endif

        {{-- Booking --}}
        <div class="mb-3">
            <label for="booking_id" class="form-label">Pilih Booking</label>
            <select name="booking_id" id="booking_id" class="form-select" required>
                <option value="">-- Pilih Booking --</option>
                @foreach ($bookings as $booking)
                    <option value="{{ $booking->id }}" {{ $payment->booking_id == $booking->id ? 'selected' : '' }}>
                        #{{ $booking->id }} - {{ $booking->guest->name ?? 'Tamu' }} - Kamar {{ $booking->room->name ?? 'ID '.$booking->room_id }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Bayar (Rp)</label>
            <input
                type="number"
                name="amount"
                id="amount"
                class="form-control"
                value="{{ old('amount', $payment->amount) }}"
                min="0"
                required
            >
        </div>

        {{-- Tanggal Bayar --}}
        <div class="mb-3">
            <label for="paid_at" class="form-label">Tanggal Bayar</label>
            <input
                type="date"
                name="paid_at"
                id="paid_at"
                class="form-control"
                value="{{ old('paid_at', optional($payment->paid_at)->format('Y-m-d')) }}"
                required
            >
        </div>

        {{-- Metode Pembayaran --}}
        <div class="mb-3">
            <label for="method" class="form-label">Metode Pembayaran</label>
            <select name="method" id="method" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                @foreach (['cash', 'transfer', 'qris'] as $method)
                    <option value="{{ $method }}" {{ $payment->method == $method ? 'selected' : '' }}>
                        {{ ucfirst($method) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route($role . '.payments.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
