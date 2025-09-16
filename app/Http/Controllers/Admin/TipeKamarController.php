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

    // SAVE - simpan data baru atau update
    public function save(Request $request)
    {
        // Validasi inputan
        $data = $request->validate([
            'tipe_kamar' => 'required|string|max:50',
            'jumlah_kamar' => 'required|integer|min:1',
        ]);

        // Menyimpan atau memperbarui data tipe kamar
        if($request->id) {
            $tipe = TipeKamar::findOrFail($request->id);
            $tipe->update($data);
        } else {
            TipeKamar::create($data);
        }

        // Redirect setelah berhasil disimpan
        return redirect()->route('admin.tipe_kamar.index')->with('success', 'Data berhasil disimpan.');
    }

    // SHOW - detail tipe kamar
    public function show($id)
    {
        // Menampilkan detail tipe kamar
        $tipe = TipeKamar::findOrFail($id);
        return view('admin.tipe_kamar.show', compact('tipe'));
    }
}
