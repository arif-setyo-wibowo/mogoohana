<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PembelianDetail;
use App\Models\User;

class Pembelian extends Model
{
    protected $table = 'pembelian';

    protected $fillable = [
        'user_id',
        'nomer_order',
        'harga_asli',
        'diskon',
        'kode_kupon',
        'tanggal_order',
        'total_harga',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
        'name',
        'email',
        'phone',
        'note',
        'username',
        'facebook',
        'link'
    ];

    protected $casts = [
        'tanggal_order' => 'datetime',
    ];

    // Relationship with PembelianDetail
    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id', 'id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
