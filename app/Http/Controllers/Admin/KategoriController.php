<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        $data = [
            'title' => 'Kategori',
            'kategori' => $kategori
        ];

        return view('admin.kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Kategori'
        ];
        return view('admin.kategori.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kategori' => 'required|max:255|unique:kategori,kategori',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $kategori = new Kategori();
            $kategori->kategori = $validatedData['kategori'];
            $kategori->slug = Str::slug($validatedData['kategori']);

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                // Generate unique filename
                $filename = uniqid('kategori_') . '.' . $file->getClientOriginalExtension();

                // Store file in the public disk
                $path = $file->storeAs('kategori', $filename, 'public');

                // Remove 'public/' prefix if present
                $kategori->foto = str_replace('public/', '', $path);
            }

            $kategori->save();

            return redirect()->route('kategori.index')->with('msg', 'Category has been successfully added.');
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Category store error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $data = [
            'title' => 'Detail Kategori',
            'kategori' => $kategori
        ];
        return view('admin.kategori.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori
        ];
        return view('admin.kategori.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $validatedData = $request->validate([
                'kategori' => 'required|max:255|unique:kategori,kategori,' . $id,
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $kategori->kategori = $validatedData['kategori'];
            $kategori->slug = Str::slug($validatedData['kategori']);

            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old file if exists
                if ($kategori->foto) {
                    Storage::disk('public')->delete($kategori->foto);
                }

                $file = $request->file('foto');

                // Generate unique filename
                $filename = uniqid('kategori_') . '.' . $file->getClientOriginalExtension();

                // Store file in the public disk
                $path = $file->storeAs('kategori', $filename, 'public');

                // Remove 'public/' prefix if present
                $kategori->foto = str_replace('public/', '', $path);
            }

            $kategori->save();

            return redirect()->route('kategori.index')->with('msg', 'Category has been successfully updated.');
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Kategori update error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        // Delete associated image if exists
        if ($kategori->foto) {
            Storage::disk('public')->delete($kategori->foto);
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('msg', 'Category has been successfully deleted.');
    }
}
