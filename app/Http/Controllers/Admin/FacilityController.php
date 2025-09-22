<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::with('rooms')->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $facilities = $query->paginate(15);

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        $rooms = Room::with('tipeKamar')->get()->groupBy(fn($r) => $r->tipeKamar->tipe_kamar ?? 'Lainnya');
        return view('admin.facilities.form', [
            'groupedRooms' => $rooms
        ]);
    }

    public function store(FacilityRequest $request)
    {
        $data = $request->only(['name', 'description', 'status', 'capacity', 'price_per_night']); // <--- tambahkan price_per_night

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        $facility = Facility::create($data);

        $facility->rooms()->sync($request->input('rooms', []));

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        $rooms = Room::with('tipeKamar')->get()->groupBy(fn($r) => $r->tipeKamar->tipe_kamar ?? 'Lainnya');
        return view('admin.facilities.form', [
            'facility' => $facility,
            'groupedRooms' => $rooms
        ]);
    }

    public function show(Facility $facility)
    {
        $facility->load('rooms.tipeKamar');

        return view('admin.facilities.show', compact('facility'));
    }

    public function update(FacilityRequest $request, Facility $facility)
    {
        $data = $request->only(['name', 'description', 'status', 'capacity', 'price_per_night']); // <--- tambahkan price_per_night

        if ($request->hasFile('image')) {
            if ($facility->image && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        $facility->update($data);

        $facility->rooms()->sync($request->input('rooms', []));

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->image && Storage::disk('public')->exists($facility->image)) {
            Storage::disk('public')->delete($facility->image);
        }
        $facility->rooms()->detach();
        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
