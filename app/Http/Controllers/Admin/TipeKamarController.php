<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipeKamar;

class TipeKamarController extends Controller
{
    // Halaman daftar tipe kamar
    public function index(Request $request)
    {
        $query = TipeKamar::query();
        
        // Menambahkan fitur pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('tipe_kamar', 'like', "%{$search}%");
        }

        // Mengambil data tipe kamar
        $tipeKamar = $query->get(); // Bisa diganti ->paginate(10) jika ingin paging

        return view('admin.tipe_kamar.index', compact('tipeKamar'));
    }

    // FORM - tambah atau edit tipe kamar
    public function form($id = null)
    {
        // Jika ada id, berarti edit, jika tidak tambah baru
        $tipe = null;
        if($id) {
            $tipe = TipeKamar::findOrFail($id);
        }
        return view('admin.tipe_kamar.form', compact('tipe'));
    }


public function save(Request $request)
{
    $request->validate([
        'tipe_kamar' => 'required|string|max:50',
        'jumlah_kamar' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'kapasitas' => 'required|integer|min:1|max:10', 
        'deskripsi' => 'nullable|string',
        'fitur' => 'nullable|array',
        'fitur.*' => 'string',
    ]);

    $data = [
        'tipe_kamar' => $request->tipe_kamar,
        'jumlah_kamar' => $request->jumlah_kamar,
        'kamar_tersedia' => $request->jumlah_kamar, 
        'price' => $request->price,
        'kapasitas' => $request->kapasitas,
        'deskripsi' => $request->deskripsi,
        'fitur' => $request->fitur ? json_encode($request->fitur) : null,
    ];

    if ($request->has('id')) {
        // Update
        \App\Models\TipeKamar::findOrFail($request->id)->update($data);
    } else {
        // Create
        \App\Models\TipeKamar::create($data);
    }

    return redirect()->route('admin.rooms.index')->with('success', 'Tipe kamar berhasil disimpan.');
}

    // SHOW - detail tipe kamar
    public function show($id)
    {
        // Menampilkan detail tipe kamar
        $tipe = TipeKamar::findOrFail($id);
        return view('admin.tipe_kamar.show', compact('tipe'));
    }
}
