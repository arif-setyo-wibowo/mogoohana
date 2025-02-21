<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pembelian;
use App\Models\Produk;

class PembelianDetail extends Model
{
    protected $table = 'detail_pembelian';

    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'jumlah',
        'harga'
    ];

    // Relationship with Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }

    // Relationship with Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
