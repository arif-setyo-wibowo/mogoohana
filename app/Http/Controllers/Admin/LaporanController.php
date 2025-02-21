<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pembelian(Request $request)
    {
        $query = Pembelian::where('status', 'diterima');

        // Apply date filtering if dates are provided
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_order', [
                $request->input('tanggal_awal'), 
                $request->input('tanggal_akhir')
            ]);
        }

        // Get filtered pembelians
        $pembelians = $query->with('details.produk')->latest()->get();

        // Calculate total pendapatan
        $totalPendapatan = $pembelians->sum('total_harga');

        $data = [
            'title' => 'Laporan Pembelian',
            'pembelians' => $pembelians,
            'totalPendapatan' => $totalPendapatan
        ];

        return view('admin.laporan.pembelian', $data);
    }
}
