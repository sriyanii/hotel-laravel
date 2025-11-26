<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        // Get room statistics
        $roomStats = [
            'total' => Room::count(),
            'available' => Room::where('status', 'tersedia')->count(),
            'occupied' => Room::where('status', 'terisi')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
            'reserved' => Room::where('status', 'dipesan')->count(),
        ];

        // Get all rooms with tipeKamar relationship
        $rooms = Room::with('tipeKamar')
                    ->orderBy('floor')
                    ->orderBy('number')
                    ->get();

        // Get current bookings for occupied rooms
        $occupiedRoomIds = $rooms->where('status', 'terisi')->pluck('id');
        $currentBookings = Booking::whereIn('room_id', $occupiedRoomIds)
                                ->whereIn('status', ['confirmed', 'checked_in'])
                                ->with('guest')
                                ->get()
                                ->keyBy('room_id');

        // Attach current bookings to rooms
        $rooms->each(function ($room) use ($currentBookings) {
            $room->currentBooking = $currentBookings->get($room->id);
        });

        return view('resepsionis.room.index', compact('roomStats', 'rooms'));
    }

    public function show($id)
    {
        $room = Room::with('tipeKamar')->find($id);
        
        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json($room);
    }

    public function updateRoomStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:tersedia,terisi,maintenance,dipesan'
        ]);

        $room = Room::find($id);
        
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Room not found']);
        }

        $room->status = $request->status;
        $room->save();

        return response()->json(['success' => true, 'message' => 'Room status updated successfully']);
    }
}