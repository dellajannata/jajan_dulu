<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index(Request $request)
    {

        $makanan = Makanan::all();
        return view('layouts.index', compact('makanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        //upload image
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/makanan', $gambar->hashName());
        
        $makanan = Makanan::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambar->hashName(),
        ]);

        if ($makanan) {
            return redirect()->route('makanan.index')->with('success', 'Data berhasil ditambahkan.');
        } else {
            return redirect()->route('makanan.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $makanan = Makanan::find($id);
        return view('layouts.index', compact('makanan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'gambar' => 'required',
            'harga' => 'required',
        ]);

        $makanan = Makanan::findOrFail($id);
        $updated = $makanan->update([
            'nama' => $request->nama,
            'gambar' => $request->gambar,
            'harga' => $request->harga,
        ]);

        if ($updated) {
            return redirect()->route('makanan.index')->with('success_edit', 'Data Berhasil Diperbarui!');
        } else {
            return redirect()->route('makanan.index')->with('error', 'Data Gagal Diperbarui!');
        }
    }

    public function destroy($id)
    {
        $makanan = Makanan::findOrFail($id);

        if ($makanan->delete()) {
            return redirect()->route('makanan.index')->with(['success_delete' => 'Data berhasil diahpus']);
        } else {
            return redirect()->route('makanan.index')->with(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }
}