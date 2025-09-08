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

        // Pencarian berdasarkan nomor, tipe, atau status
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $statusFilter = $request->input('status_filter', 'all');
        $allowedStatuses = ['tersedia', 'terisi', 'maintenance', 'dipesan', 'all'];

        if (!in_array($statusFilter, $allowedStatuses)) {
            $statusFilter = 'all';
        }

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $rooms = $query->paginate(5);
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
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imge'), $filename);
            $validated['photo'] = $filename;
        }

        $room = Room::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'create',
            'description' => 'Menambahkan kamar baru: ' . $room->number,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role
        ]);

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

        $oldData = $room->toArray();

        // Hapus gambar jika checkbox di centang
        if ($request->has('hapus_gambar')) {
            if ($room->photo && file_exists(public_path('imge/' . $room->photo))) {
                unlink(public_path('imge/' . $room->photo));
            }
            $validated['photo'] = null;
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus gambar lama jika ada
            if ($room->photo && file_exists(public_path('imge/' . $room->photo))) {
                unlink(public_path('imge/' . $room->photo));
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imge'), $filename);
            $validated['photo'] = $filename;
        }

        $room->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'update',
            'description' => 'Memperbarui data kamar: ' . $room->number,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData),
            'new_values' => json_encode($validated)
        ]);

        return redirect()->route(auth()->user()->role . '.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Room $room)
    {
        // Hapus foto jika ada
        if ($room->photo && file_exists(public_path('imge/' . $room->photo))) {
            unlink(public_path('imge/' . $room->photo));
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'delete',
            'description' => 'Menghapus kamar: ' . $room->number,
            'ip_address' => request()->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($room->toArray())
        ]);

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}