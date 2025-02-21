<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all();

        $data = [
            'title' => 'Produk',
            'produks' => $produks,
            'kategoris' => $kategoris
        ];

        return view('admin.produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        $data = [
            'title' => 'Add New Produk',
            'kategoris' => $kategoris
        ];

        return view('admin.produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'harga' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'harga_diskon' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $produk = new Produk();
        $produk->nama_produk = $validatedData['nama_produk'];
        $produk->id_kategori = $validatedData['id_kategori'];
        $produk->stok = $validatedData['stok'];
        $produk->harga = floatval($validatedData['harga']);
        $produk->harga_diskon = $request->input('harga_diskon') ? floatval($request->input('harga_diskon')) : null;
        $produk->deskripsi = $request->input('deskripsi');

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Generate unique filename
            $filename = uniqid('produk_') . '.' . $file->getClientOriginalExtension();

            // Store file in the public disk
            $path = $file->storeAs('produk', $filename, 'public');

            // Remove 'public/' prefix if present
            $produk->foto = str_replace('public/', '', $path);
        }

        $produk->save();

        return redirect()->route('produk.index')->with('msg', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();

        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'kategoris' => $kategoris
        ];

        return view('admin.produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validatedData = $request->validate([
            'nama_produk' => 'required|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'harga' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'harga_diskon' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $produk->nama_produk = $validatedData['nama_produk'];
        $produk->id_kategori = $validatedData['id_kategori'];
        $produk->stok = $validatedData['stok'];
        $produk->harga = floatval($validatedData['harga']);
        $produk->harga_diskon = $request->input('harga_diskon') ? floatval($request->input('harga_diskon')) : null;
        $produk->deskripsi = $request->input('deskripsi');

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            $file = $request->file('foto');

            // Generate unique filename
            $filename = uniqid('produk_') . '.' . $file->getClientOriginalExtension();

            // Store file in the public disk
            $path = $file->storeAs('produk', $filename, 'public');

            // Remove 'public/' prefix if present
            $produk->foto = str_replace('public/', '', $path);
        }

        $produk->save();

        return redirect()->route('produk.index')->with('msg', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Delete associated image if exists
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('msg', 'Produk berhasil dihapus');
    }
}
