<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ShopDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $product = Produk::where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Produk::where('id_kategori', $product->id_kategori)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        $categories = Kategori::withCount('produks')->get();
        
        return view('shop-detail', compact('product', 'relatedProducts', 'categories'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
