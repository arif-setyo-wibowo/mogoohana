<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        $perPage = $request->input('show', 25);
        if ($perPage == 'all') {
            $perPage = Produk::count();
        }

        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $actualMinPrice = Produk::min('harga') ?? 0;
        $actualMaxPrice = Produk::max('harga') ?? 10000;

        $minPrice = 0;
        $maxPrice = 10000;

        if ($actualMinPrice > 0 || $actualMaxPrice < 10000) {
            $minPrice = max(0, $actualMinPrice);
            $maxPrice = min(10000, $actualMaxPrice);
        }

        $filterMinPrice = $request->input('min_price', $minPrice);
        $filterMaxPrice = $request->input('max_price', $maxPrice);

        $filterMinPrice = max(0, min($filterMinPrice, 10000));
        $filterMaxPrice = max(0, min($filterMaxPrice, 10000));

        $query->whereBetween('harga', [$filterMinPrice, $filterMaxPrice]);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_produk', 'like', "%{$searchTerm}%");
            });
        }

        $sortBy = $request->input('sort', 'latest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_produk', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate($perPage);

        $categories = Kategori::withCount('produks')->get();

        $products->withPath($request->path());

        return view('shop', compact(
            'products',
            'categories',
            'minPrice',
            'maxPrice',
            'actualMinPrice',
            'actualMaxPrice',
            'filterMinPrice',
            'filterMaxPrice'
        ));
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
