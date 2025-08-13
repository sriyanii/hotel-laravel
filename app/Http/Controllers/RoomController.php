<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class RoomController extends Controller
{
    public function index(Request $request)
{
    $query = Room::query();

    $statusFilter = $request->input('status_filter', 'all');
    $allowedStatuses = ['tersedia', 'terisi', 'maintenance', 'all'];

    if (!in_array($statusFilter, $allowedStatuses)) {
        $statusFilter = 'all';
    }

    if ($statusFilter !== 'all') {
        $query->where('status', $statusFilter);
    }

    // Gunakan paginate agar bisa pakai ->hasPages() dan ->links()
    $rooms = $query->paginate(10);

    $currentStatus = $statusFilter;

    return view('rooms.index', compact('rooms', 'currentStatus'));
}


    public function create()
    {
        $isEdit = false;
        $room = new Room();
        return view('rooms.form', compact('isEdit', 'room'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:rooms',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terisi,maintenance,dipesan',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('room-photos', 'public');
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $isEdit = true;
        return view('rooms.form', compact('room', 'isEdit'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:rooms,number,' . $room->id,
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terisi,maintenance,dipesan',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Jika user centang hapus foto
        if ($request->has('hapus_gambar')) {
            if ($room->photo) {
                Storage::disk('public')->delete($room->photo);
                $room->photo = null;
            }
        }

        if ($request->hasFile('photo')) {
            if ($room->photo) {
                Storage::disk('public')->delete($room->photo);
            }
            $validated['photo'] = $request->file('photo')->store('room-photos', 'public');
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Room $room)
    {
        if ($room->photo) {
            Storage::disk('public')->delete($room->photo);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}
