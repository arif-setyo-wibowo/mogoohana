<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::with('details.produk')
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'title' => 'Pembelian',
            'pembelians' => $pembelians
        ];

        return view('admin.pembelian.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian->load('details.produk');
        return view('admin.laporan.detail_pembelian', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, Pembelian $pembelian)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,diterima,ditolak'
        ]);

        try {
            DB::beginTransaction();

            $pembelian->update([
                'status' => $validatedData['status']
            ]);

            DB::commit();

            return redirect()->route('admin.pembelian.index')
                ->with('success', "Status pembelian berhasil diubah menjadi {$validatedData['status']}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengubah status pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }

    /**
     * Handle purchase confirmation
     */
    public function konfirmasi($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->status = 'diterima';
        $pembelian->save();

        $user = $pembelian->email;
        Mail::to($user)->send(new OrderConfirmationMail($pembelian));

        return redirect()->route('pembelian.index')
            ->with('msg', 'Pembelian berhasil dikonfirmasi dan email notifikasi telah dikirim.');
    }
}
