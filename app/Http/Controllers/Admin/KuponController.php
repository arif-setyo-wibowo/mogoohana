<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kupon;
use Illuminate\Support\Facades\Validator;

class KuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kupon = Kupon::all();
        $data = [
            'title' => 'Kupon',
            'kupon' => $kupon
        ];

        return view('admin.kupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Kupon'
        ];
        return view('admin.kupon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:kupon,kode|max:255',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimal_belanja' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jumlah_kupon' => 'required|integer|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'deskripsi' => 'nullable|string'
        ], [
            'kode.unique' => 'Kode kupon sudah digunakan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Kupon::create($validator->validated());

            return redirect()->route('kupon.index')
                ->with('msg', 'Kupon berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kupon: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kupon = Kupon::findOrFail($id);
        $data = [
            'title' => 'Edit Kupon',
            'kupon' => $kupon
        ];
        return view('admin.kupon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kupon = Kupon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode' => 'required|max:255|unique:kupon,kode,' . $id,
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimal_belanja' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jumlah_kupon' => 'required|integer|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'deskripsi' => 'nullable|string'
        ], [
            'kode.unique' => 'Kode kupon sudah digunakan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kupon->update($validator->validated());

            return redirect()->route('kupon.index')
                ->with('msg', 'Kupon berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui kupon: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kupon = Kupon::findOrFail($id);
            $kupon->delete();

            return redirect()->route('kupon.index')
                ->with('msg', 'Kupon berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kupon: ' . $e->getMessage());
        }
    }
}
