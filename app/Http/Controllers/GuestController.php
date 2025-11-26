<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation; // Pastikan model Reservation ada
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
        
        $query = Guest::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        $guests = $query->latest()->paginate(10);
        
        // Statistics dengan data yang lebih akurat
        $totalGuests = Guest::count();
        $vipGuests = Guest::whereIn('guest_type', ['vip', 'vvip'])->count();
        
        // Data untuk tamu yang sedang menginap (current guests)
        $currentGuests = 0;
        $currentGuestsList = collect();
        
        // Data untuk tamu yang check out hari ini
        $checkedOutToday = 0;
        $checkOutTodayList = collect();
        
        // Jika ada model Reservation, gunakan data yang sebenarnya
        if (class_exists('App\Models\Reservation')) {
            $today = Carbon::today();
            
            // Current guests (sedang menginap)
            $currentReservations = Reservation::where('check_in', '<=', $today)
                ->where('check_out', '>=', $today)
                ->where('status', 'checked_in')
                ->with('guest')
                ->get();
            
            $currentGuests = $currentReservations->count();
            $currentGuestsList = $currentReservations->pluck('guest')->filter();
            
            // Today's check outs
            $checkOutReservations = Reservation::whereDate('check_out', $today)
                ->where('status', 'checked_in')
                ->with('guest')
                ->get();
            
            $checkedOutToday = $checkOutReservations->count();
            $checkOutTodayList = $checkOutReservations->pluck('guest')->filter();
        } else {
            // Fallback: gunakan data dummy untuk demo
            $currentGuests = Guest::limit(8)->count();
            $currentGuestsList = Guest::limit(8)->get();
            
            // Untuk demo, anggap 2 tamu akan check out hari ini
            $checkedOutToday = 2;
            $checkOutTodayList = Guest::limit(2)->get();
        }
        
        // VIP guests
        $vipGuestsList = Guest::whereIn('guest_type', ['vip', 'vvip'])->get();
        
        return view('guests.index', compact(
            'guests', 'totalGuests', 'currentGuests', 'vipGuests', 
            'checkedOutToday', 'currentGuestsList', 'checkOutTodayList', 'vipGuestsList', 'prefix'
        ));
    }
    
    public function show($id)
    {
        $guest = Guest::with(['reservations' => function($query) {
            $query->latest()->limit(5);
        }])->findOrFail($id);
        
        // Format data untuk response JSON
        $guestData = [
            'id' => $guest->id,
            'name' => $guest->name,
            'first_name' => $guest->first_name,
            'last_name' => $guest->last_name,
            'identity_number' => $guest->identity_number,
            'phone' => $guest->phone,
            'email' => $guest->email,
            'gender' => $guest->gender,
            'date_of_birth' => $guest->date_of_birth ? Carbon::parse($guest->date_of_birth)->format('d M Y') : null,
            'nationality' => $guest->nationality,
            'profession' => $guest->profession,
            'guest_type' => $guest->guest_type,
            'marital_status' => $guest->marital_status,
            'address' => $guest->address,
            'notes' => $guest->notes,
            'health_notes' => $guest->health_notes,
            'social_account' => $guest->social_account,
            'photo' => $guest->photo,
            'guest_code' => $guest->guest_code,
            'loyalty_points' => $guest->loyalty_points ?? 0,
            'created_at' => $guest->created_at ? $guest->created_at->format('d M Y, H:i') : null,
            'reservations_count' => $guest->reservations->count(),
            'total_stays' => $guest->reservations->where('status', 'checked_out')->count(),
        ];
        
        return response()->json($guestData);
    }
    
    public function create()
    {
        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
        return view('guests.create', compact('prefix'));
    }
    
public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'identity_number' => 'required|string|max:255|unique:guests',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|unique:guests',
        'gender' => 'nullable|in:male,female,other',
        'date_of_birth' => 'nullable|date',
        'nationality' => 'nullable|string|max:100',
        'profession' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255', // Tambahkan validasi untuk company
        'guest_type' => 'required|in:reguler,vip,vvip,corporate,staff',
        'marital_status' => 'nullable|in:single,married,divorced,widowed',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100', // Tambahkan validasi untuk city
        'country' => 'nullable|string|max:100', // Tambahkan validasi untuk country
        'notes' => 'nullable|string',
        'health_notes' => 'nullable|string',
        'social_account' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048'
    ]);

    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';

    try {
        // Data akan dihandle oleh model boot method
        $guestData = $request->all();
        $guestData['loyalty_points'] = 0; // Default loyalty points

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'guest_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create directory if not exists
            $directory = public_path('storage/guests');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $photo->move($directory, $filename);
            $guestData['photo'] = $filename;
        }

        Guest::create($guestData);

        return redirect()->route($prefix . '.guests.index')
                         ->with('success', 'Guest created successfully');

    } catch (\Exception $e) {
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Failed to create guest: ' . $e->getMessage());
    }
}
    
    public function edit($id)
    {
        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
        $guest = Guest::findOrFail($id);
        
        // Split name into first and last name for form
        $nameParts = explode(' ', $guest->name, 2);
        $guest->first_name = $nameParts[0] ?? '';
        $guest->last_name = $nameParts[1] ?? '';
        
        return view('guests.edit', compact('guest', 'prefix'));
    }
    
    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'identity_number' => 'required|string|max:255|unique:guests,identity_number,' . $id,
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:guests,email,' . $id,
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'profession' => 'nullable|string|max:255',
            'guest_type' => 'required|in:reguler,vip,vvip,corporate,staff',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'health_notes' => 'nullable|string',
            'social_account' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048'
        ]);
        
        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
        
        // Combine first and last name
        $name = trim($request->first_name . ' ' . ($request->last_name ?? ''));
        
        $guestData = $request->all();
        $guestData['name'] = $name;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($guest->photo && file_exists(public_path('storage/guests/' . $guest->photo))) {
                unlink(public_path('storage/guests/' . $guest->photo));
            }
            
            $photo = $request->file('photo');
            $filename = 'guest_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            
            // Create directory if not exists
            $directory = public_path('storage/guests');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $photo->move($directory, $filename);
            $guestData['photo'] = $filename;
        }
        
        $guest->update($guestData);
        
        return redirect()->route($prefix . '.guests.index')
                         ->with('success', 'Guest updated successfully');
    }
    
    public function destroy($id)
    {
        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
        $guest = Guest::findOrFail($id);
        
        // Check if guest has reservations
        if ($guest->reservations()->exists()) {
            return redirect()->route($prefix . '.guests.index')
                             ->with('error', 'Cannot delete guest with existing reservations.');
        }
        
        // Delete photo if exists
        if ($guest->photo && file_exists(public_path('storage/guests/' . $guest->photo))) {
            unlink(public_path('storage/guests/' . $guest->photo));
        }
        
        $guest->delete();
        
        return redirect()->route($prefix . '.guests.index')
                         ->with('success', 'Guest deleted successfully');
    }
    
/**
 * Get guest details for modal (API endpoint)
 */
public function getGuestDetails($id)
{
    try {
        $guest = Guest::findOrFail($id);
        
        $data = [
            'id' => $guest->id,
            'name' => $guest->name,
            'first_name' => $guest->first_name,
            'last_name' => $guest->last_name,
            'identity_number' => $guest->identity_number,
            'phone' => $guest->phone,
            'email' => $guest->email,
            'gender' => $guest->gender,
            'date_of_birth' => $guest->date_of_birth ? \Carbon\Carbon::parse($guest->date_of_birth)->format('d M Y') : null,
            'nationality' => $guest->nationality,
            'profession' => $guest->profession,
            'company' => $guest->company,
            'guest_type' => $guest->guest_type,
            'marital_status' => $guest->marital_status,
            'address' => $guest->address,
            'city' => $guest->city,
            'country' => $guest->country,
            'notes' => $guest->notes,
            'health_notes' => $guest->health_notes,
            'social_account' => $guest->social_account,
            'photo' => $guest->photo,
            'guest_code' => $guest->guest_code,
            'loyalty_points' => $guest->loyalty_points ?? 0,
            'created_at' => $guest->created_at ? $guest->created_at->format('d M Y') : null,
        ];
        
        return response()->json($data);
        
    } catch (\Exception $e) {
        \Log::error('Error fetching guest details: ' . $e->getMessage());
        return response()->json([
            'error' => 'Guest not found',
            'message' => $e->getMessage()
        ], 404);
    }
}

/**
 * Alternative method for guest details
 */
public function showDetails($id)
{
    return $this->getGuestDetails($id);
}
}