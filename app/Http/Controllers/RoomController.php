<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TipeKamar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    // === 1. Filter & Query Rooms ===
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
$allowedStatuses = ['tersedia', 'maintenance', 'cleaning', 'all'];
    if (!in_array($statusFilter, $allowedStatuses)) {
        $statusFilter = 'all';
    }
    if ($statusFilter !== 'all') {
        $query->where('status', $statusFilter);
    }

    $rooms = $query->with('tipeKamar')->get();
    $currentStatus = $statusFilter;

    $roomTypes = TipeKamar::withCount(['rooms' => function ($q) {
        $q->whereNull('deleted_at');
    }])->get();

$statusCounts = [
    'tersedia' => $rooms->where('status', 'tersedia')->count(),
    'maintenance' => $rooms->where('status', 'maintenance')->count(),
    'cleaning' => $rooms->where('status', 'cleaning')->count(),
];

    // === 2. Data needed for the "Add Room" modal ===
    $tipeKamar = TipeKamar::all(); // 👈 REQUIRED for the select dropdown
    $bedTypes = ['Single', 'Queen', 'King', 'Twin', 'Double']; // 👈
    $features = ['Air Conditioning', 'TV', 'Minibar', 'Safe', 'Balcony', 'Sea View', 'WiFi', 'Room Service']; // 👈

    // === 3. Persiapan Data Kalender Pemesanan ===
    $now = Carbon::now();
    $year = $request->input('year', $now->year);
    $month = $request->input('month', $now->month);

    if (!is_numeric($year) || !is_numeric($month) || $month < 1 || $month > 12) {
        $year = $now->year;
        $month = $now->month;
    }

    $startOfMonth = Carbon::create($year, $month, 1)->startOfWeek(Carbon::MONDAY);
    $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth()->endOfWeek(Carbon::SUNDAY);

    $bookings = Booking::with(['guest', 'room.tipeKamar'])
        ->where('check_out', '>=', $startOfMonth->copy()->startOfMonth())
        ->where('check_in', '<=', $endOfMonth->copy()->endOfMonth())
        ->get();

    $bookingsByDate = [];
    foreach ($bookings as $booking) {
        $checkIn = Carbon::parse($booking->check_in)->startOfDay();
        $checkOut = Carbon::parse($booking->check_out)->startOfDay();

        for ($date = $checkIn->copy(); $date->lte($checkOut); $date->addDay()) {
            $dateKey = $date->toDateString();
            $bookingsByDate[$dateKey][] = $booking;
        }
    }

    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;
    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;

    // === 4. Kirim SEMUA data ke view ===
    return view('rooms.index', compact(
        'rooms',
        'currentStatus',
        'roomTypes',
        'statusCounts',
        // 👇 Modal dependencies
        'tipeKamar',
        'bedTypes',
        'features',
        // Kalender
        'bookings',
        'bookingsByDate',
        'year',
        'month',
        'startOfMonth',
        'endOfMonth',
        'prevYear',
        'prevMonth',
        'nextYear',
        'nextMonth'
    ));
}

public function editData($id)
{
    try {
        $room = Room::with('tipeKamar')->findOrFail($id);
        
        // Ensure features is properly formatted as array
        $features = $room->features;
        if (is_string($features)) {
            $features = json_decode($features, true) ?? [];
        }
        
        return response()->json([
                'id' => $room->id,
                'number' => $room->number,
                'price' => (float) $room->price,
                'status' => $room->status,
                'photo' => $room->photo ? asset('image/' . $room->photo) : null,
                'photo_filename' => $room->photo,
                'description' => $room->description,
                'capacity' => $room->capacity,
                'floor' => $room->floor,
                'tipe_kamar_id' => $room->tipe_kamar_id,
                'tipe_kamar' => $room->tipeKamar,
                'room_size' => $room->room_size ? (float) $room->room_size : null,
                'bed_type' => $room->bed_type,
                'max_occupancy' => $room->max_occupancy,
                'features' => $features, // Properly formatted array
            ]);
            
    } catch (\Exception $e) {
        \Log::error('Error fetching room data: ' . $e->getMessage());
        return response()->json([
                'error' => 'Room not found',
                'message' => $e->getMessage()
            ], 404);
    }
}

public function apiIndex(Request $request)
{
    $rooms = Room::with('tipeKamar')->get()->map(function($room) {
        $features = $room->features;
        if (is_string($features)) {
            $features = json_decode($features, true) ?? [];
        }
        
        return [
            'id' => $room->id,
            'number' => $room->number,
            'type' => $room->tipeKamar->tipe_kamar ?? 'N/A',
            'price' => (float) $room->price,
            'status' => $room->status,
            'photo' => $room->photo ? asset('image/' . $room->photo) : null,
            'bed_type' => $room->bed_type ?? 'N/A',
            'max_occupancy' => $room->max_occupancy,
            'features' => $features,
            'room_size' => $room->room_size,
            'floor' => $room->floor,
            'description' => $room->description,
        ];
    });
    
    return response()->json($rooms);
}

    public function create()
    {
        $isEdit = false;
        $room = new Room();
        $tipeKamar = TipeKamar::all();
        $bedTypes = ['Single', 'Queen', 'King', 'Twin', 'Double'];
        $features = ['Air Conditioning', 'TV', 'Minibar', 'Safe', 'Balcony', 'Sea View', 'WiFi', 'Room Service'];
        
        return view('rooms.form', compact('isEdit', 'room', 'tipeKamar', 'bedTypes', 'features'));
    }

public function edit($id)
{
    $room = Room::findOrFail($id);
    $tipeKamar = TipeKamar::all();
    $bedTypes = ['Single', 'Queen', 'King', 'Twin', 'Double'];
    $features = ['Air Conditioning', 'TV', 'Minibar', 'Safe', 'Balcony', 'Sea View', 'WiFi', 'Room Service'];
    $isEdit = true;
    
    return view('rooms.edit', compact('room', 'tipeKamar', 'bedTypes', 'features', 'isEdit'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'number' => 'required|unique:rooms',
        'price' => 'required|numeric',
        'status' => 'required|in:tersedia,maintenance,cleaning',
        'description' => 'nullable|string',
        'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'floor' => 'required|integer|min:1|max:20',
        'room_size' => 'nullable|numeric|min:0',
        'bed_type' => 'nullable|string',
        'max_occupancy' => 'required|integer|min:1',
        'features' => 'nullable|array',
    ]);

    // Process features
    $validated['features'] = $request->features ? json_encode($request->features) : null;
    $validated['capacity'] = $request->max_occupancy; // Set capacity from max_occupancy

    // Create room
    $room = Room::create($validated);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('image'), $filename);
        $room->photo = $filename;
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
    return redirect()->route($routeName)->with('success', 'Room berhasil ditambahkan!');
}

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:rooms,number,' . $room->id,
            'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,maintenance,cleaning',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'floor' => 'required|integer|min:1|max:20',
            'room_size' => 'nullable|numeric|min:0',
            'bed_type' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1',
            'features' => 'nullable|array',
        ]);

        // Process features - encode to JSON
        $validated['features'] = $request->features ? json_encode($request->features) : null;
        $validated['capacity'] = $request->max_occupancy;

        // Simpan tipe_kamar_id lama untuk perbandingan
        $oldTipeKamarId = $room->tipe_kamar_id;

        // Start transaction
        DB::beginTransaction();

        try {
            // Handle photo deletion
            if ($request->has('hapus_gambar') && $room->photo) {
                $oldPhotoPath = public_path('image/' . $room->photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $validated['photo'] = null;
            }

            // Handle new photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($room->photo) {
                    $oldPhotoPath = public_path('image/' . $room->photo);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }

                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('image'), $filename);
                $validated['photo'] = $filename;
            }

            $room->update($validated);

            // Update jumlah kamar jika tipe kamar berubah
            if ($oldTipeKamarId != $request->tipe_kamar_id) {
                // Update tipe kamar lama
                $oldTipeKamar = TipeKamar::find($oldTipeKamarId);
                if ($oldTipeKamar) {
                    $jumlahKamarOld = Room::where('tipe_kamar_id', $oldTipeKamarId)
                        ->whereNull('deleted_at')
                        ->count();
                    
                    $kamarTersediaOld = Room::where('tipe_kamar_id', $oldTipeKamarId)
                        ->where('status', 'tersedia')
                        ->whereNull('deleted_at')
                        ->count();

                    $oldTipeKamar->update([
                        'jumlah_kamar' => $jumlahKamarOld,
                        'kamar_tersedia' => $kamarTersediaOld
                    ]);
                }
                
                // Update tipe kamar baru
                $newTipeKamar = TipeKamar::find($request->tipe_kamar_id);
                if ($newTipeKamar) {
                    $jumlahKamarNew = Room::where('tipe_kamar_id', $request->tipe_kamar_id)
                        ->whereNull('deleted_at')
                        ->count();
                    
                    $kamarTersediaNew = Room::where('tipe_kamar_id', $request->tipe_kamar_id)
                        ->where('status', 'tersedia')
                        ->whereNull('deleted_at')
                        ->count();

                    $newTipeKamar->update([
                        'jumlah_kamar' => $jumlahKamarNew,
                        'kamar_tersedia' => $kamarTersediaNew
                    ]);
                }
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Memperbarui data kamar: ' . $room->number,
                'ip_address' => $request->ip(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($room->getOriginal()),
                'new_values' => json_encode($validated)
            ]);

            DB::commit();

            $routeName = auth()->user()->role . '.rooms.index';
            return redirect()->route($routeName)->with('success', 'Room updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal update room: ' . $e->getMessage());
        }
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