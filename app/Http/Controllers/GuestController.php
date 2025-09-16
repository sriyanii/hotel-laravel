<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $query = Guest::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $guests = $query->orderBy('name')->paginate(10);

        return view('guests.index', compact('guests'));
    }

    public function generateGuestCode()
    {
        $year = date('y');
        $lastGuest = Guest::where('guest_code', 'like', 'TM' . $year . '%')
                        ->orderBy('guest_code', 'desc')
                        ->first();

        $newNumber = $lastGuest ? intval(substr($lastGuest->guest_code, -4)) + 1 : 1;
        return 'TM' . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $isEdit = false;
        $guest = new Guest();
        $guest->guest_code = $this->generateGuestCode();

        $guestTypes = ['reguler','vip','vvip','corporate','staff'];
        $maritalStatuses = ['single','married','divorced','widowed'];
        $genders = ['male','female','other'];

        return view('guests.form', compact('isEdit','guest','guestTypes','maritalStatuses','genders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests',
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'guest_type' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['guest_code'] = $this->generateGuestCode();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('guests'), $filename);
            $validated['photo'] = $filename;
        }

        $guest = Guest::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'create',
            'description' => 'Menambahkan tamu baru: ' . $guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'new_values' => json_encode($guest->toArray())
        ]);

        return redirect()->route(auth()->user()->role.'.guests.index')
            ->with('success','Tamu berhasil ditambahkan.');
    }

    public function show(Guest $guest)
    {
        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        $isEdit = true;
        $guestTypes = ['reguler','vip','vvip','corporate','staff'];
        $maritalStatuses = ['single','married','divorced','widowed'];
        $genders = ['male','female','other'];

        return view('guests.form', compact('guest','isEdit','guestTypes','maritalStatuses','genders'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests,identity_number,' . $guest->id,
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'guest_type' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $oldData = $guest->toArray();

        if ($request->has('delete_photo') && $guest->photo && file_exists(public_path('guests/'.$guest->photo))) {
            unlink(public_path('guests/'.$guest->photo));
            $validated['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($guest->photo && file_exists(public_path('guests/'.$guest->photo))) {
                unlink(public_path('guests/'.$guest->photo));
            }
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('guests'), $filename);
            $validated['photo'] = $filename;
        }

        $guest->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'update',
            'description' => 'Memperbarui data tamu: '.$guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData),
            'new_values' => json_encode($validated)
        ]);

        return redirect()->route(auth()->user()->role.'.guests.index')
            ->with('success','Data tamu berhasil diperbarui.');
    }

    public function destroy(Guest $guest, Request $request)
    {
        $oldData = $guest->toArray();

        if ($guest->photo && file_exists(public_path('guests/'.$guest->photo))) {
            unlink(public_path('guests/'.$guest->photo));
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'delete',
            'description' => 'Menghapus tamu: '.$guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData)
        ]);

        $guest->delete();

        return redirect()->route(auth()->user()->role.'.guests.index')
            ->with('success','Tamu berhasil dihapus.');
    }

    public function calendar()
    {
        $totalRooms = 45;

        $bookings = Booking::where('status', '!=', 'canceled')->get(['check_in','check_out']);

        $bookingsArray = [];
        foreach ($bookings as $b) {
            $period = new \DatePeriod(
                new \DateTime($b->check_in),
                new \DateInterval('P1D'),
                (new \DateTime($b->check_out))->modify('+1 day')
            );

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $bookingsArray[$dateStr] = ($bookingsArray[$dateStr] ?? 0) + 1;
            }
        }

        return view('guests.calendar', [
            'bookings' => $bookingsArray,
            'totalRooms' => $totalRooms,
        ]);
    }

    /**
     * Menampilkan timeline booking tamu — SUDAH DIPERBAIKI
     */
    public function timeline()
    {
        $bookings = Booking::with(['guest', 'room.tipeKamar']) 
            ->whereIn('status', ['booked', 'confirmed', 'checked_in', 'checked_out'])
            ->orderBy('check_in', 'asc')
            ->get(); // ← Ambil SEMUA, bukan paginate(4)

        return view('guests.timeline', compact('bookings'));
    }
}