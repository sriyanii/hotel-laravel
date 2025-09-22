<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TipeKamar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $allowedRoles = ['admin', 'resepsionis'];
            if (!auth()->check() || !in_array(auth()->user()->role, $allowedRoles)) {
                return redirect()->route('login')->with('error', 'Akses ditolak!');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%$search%")
                  ->orWhereHas('tipeKamar', function ($q) use ($search) {
                      $q->where('tipe_kamar', 'like', "%$search%");
                  })
                  ->orWhere('status', 'like', "%$search%");
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

        $rooms = $query->with('tipeKamar')->paginate(5);
        $currentStatus = $statusFilter;

        return view('rooms.index', compact('rooms', 'currentStatus'));
    }

    public function create()
    {
        $isEdit = false;
        $room = new Room();
        $tipeKamar = TipeKamar::all();
        return view('rooms.form', compact('isEdit', 'room', 'tipeKamar'));
    }

    public function edit($id)
    {
        $isEdit = true;
        $room = Room::findOrFail($id);
        $tipeKamar = TipeKamar::all();
        return view('rooms.form', compact('isEdit', 'room', 'tipeKamar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:rooms',
            'price' => 'required|numeric',
            'status' => 'required',
            'description' => 'nullable|string',
            'tipe_kamar_id' => 'nullable|exists:tipe_kamar,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $defaultTipeId = TipeKamar::first()?->id ?? 1;
        $validated['tipe_kamar_id'] = $validated['tipe_kamar_id'] ?? $defaultTipeId;

        // Simpan data dasar kamar
        $room = Room::create($validated);

        // Jika ada foto, simpan ke folder dan update database
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $room->photo = $filename; // simpan nama file ke kolom photo
            $room->save();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'create',
            'description' => 'Menambahkan kamar baru: ' . $room->number,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role
        ]);

        $routeName = auth()->user()->role . '.rooms.index';
        return redirect()->route($routeName)->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:rooms,number,' . $room->id,
            'tipe_kamar_id' => 'nullable|exists:tipe_kamar,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terisi,maintenance,dipesan',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $defaultTipeId = TipeKamar::first()?->id ?? 1;
        $validated['tipe_kamar_id'] = $validated['tipe_kamar_id'] ?? $defaultTipeId;

        // Simpan perubahan data dasar
        $room->update($validated);

        // Jika centang hapus gambar, hapus file lama
        if ($request->has('hapus_gambar') && $room->photo) {
            $oldPhotoPath = public_path('image/' . $room->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
            $room->photo = null;
            $room->save();
        }

        // Jika upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($room->photo) {
                $oldPhotoPath = public_path('image/' . $room->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Simpan foto baru
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $room->photo = $filename;
            $room->save();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'update',
            'description' => 'Memperbarui data kamar: ' . $room->number,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($room->toArray()),
            'new_values' => json_encode($validated)
        ]);

        $routeName = auth()->user()->role . '.rooms.index';
        return redirect()->route($routeName)->with('success', 'Sukses mengedit data!');
    }

    public function show($id)
    {
        $room = Room::with('tipeKamar')->findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function destroy(Room $room)
    {
        // Hapus foto jika ada
        if ($room->photo && file_exists(public_path('image/' . $room->photo))) {
            unlink(public_path('image/' . $room->photo));
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

        $routeName = auth()->user()->role . '.rooms.index';
        return redirect()->route($routeName)->with('success', 'Kamar berhasil dihapus.');
    }
}