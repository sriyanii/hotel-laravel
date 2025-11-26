<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckInOutController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Tamu yang perlu Check In HARI INI (status = 'booked')
        $checkInBookings = Booking::with(['guest', 'room'])
            ->whereDate('check_in', $today)
            ->where('status', 'booked')
            ->get();

        // Tamu yang Check Out HARI INI (sudah checked_in)
        $checkOutBookings = Booking::with(['guest', 'room'])
            ->whereDate('check_out', $today)
            ->where('status', 'checked_in')
            ->get();

        // Recent activity (last 5)
        $recentBookings = Booking::with(['guest', 'room'])
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->latest()
            ->take(5)
            ->get();

        // Kamar tersedia
        $availableRooms = Room::where('status', 'tersedia')->get();

        return view('resepsionis.cico.index', compact(
            'checkInBookings',
            'checkOutBookings',
            'recentBookings',
            'availableRooms'
        ));
    }

    public function checkIn(Request $request, $bookingId)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'identity_number' => 'required|string',
            'payment_method' => 'required|string',
            'deposit_amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($bookingId);
            
            // Update guest information
            $booking->guest->update([
                'identity_number' => $request->identity_number,
            ]);

            // Update booking
            $booking->update([
                'room_id' => $request->room_id,
                'status' => 'checked_in',
                'check_in_time' => now()->format('H:i:s'),
                'actual_check_in' => now(),
            ]);

            // Update room status
            Room::where('id', $request->room_id)->update(['status' => 'terpakai']);

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_amount,
                'deposit_amount' => $request->deposit_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'payment_date' => now(),
                'notes' => $request->payment_notes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Guest checked in successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkOut(Request $request, $bookingId)
    {
        $request->validate([
            'room_inspection' => 'required|array',
            'additional_charges' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($bookingId);
            
            // Calculate final amount
            $additionalCharges = $request->additional_charges ?? 0;
            $finalAmount = $booking->total_amount + $additionalCharges - $booking->deposit;

            // Update booking
            $booking->update([
                'status' => 'checked_out',
                'check_out_time' => now()->format('H:i:s'),
                'actual_check_out' => now(),
                'additional_charges' => $additionalCharges,
            ]);

            // Update room status
            Room::where('id', $booking->room_id)->update(['status' => 'dibersihkan']);

            // Create final payment record if there's balance
            if ($finalAmount > 0) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $finalAmount,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid',
                    'payment_date' => now(),
                    'notes' => 'Final payment upon checkout',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Guest checked out successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function walkInCheckIn(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'identity_number' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'payment_method' => 'required|string',
            'deposit_amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Create guest
            $guest = Guest::create([
                'guest_code' => 'W' . Str::random(8),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'identity_number' => $request->identity_number,
                'address' => $request->address,
                'nationality' => $request->nationality,
            ]);

            // Get room price
            $room = Room::find($request->room_id);
            $nights = Carbon::parse($request->check_in)->diffInDays($request->check_out);
            $totalAmount = $room->price * $nights;

            // Create booking
            $booking = Booking::create([
                'booking_code' => 'WALKIN' . Str::random(6),
                'guest_id' => $guest->id,
                'room_id' => $request->room_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'nights' => $nights,
                'total_amount' => $totalAmount,
                'deposit' => $request->deposit_amount,
                'status' => 'checked_in',
                'check_in_time' => now()->format('H:i:s'),
                'actual_check_in' => now(),
                'special_requests' => $request->special_requests,
            ]);

            // Update room status
            $room->update(['status' => 'terpakai']);

            // Create payment
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalAmount,
                'deposit_amount' => $request->deposit_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'payment_date' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Walk-in guest checked in successfully',
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableRooms()
    {
        $rooms = Room::where('status', 'tersedia')->get();
        
        return response()->json([
            'success' => true,
            'rooms' => $rooms
        ]);
    }
}