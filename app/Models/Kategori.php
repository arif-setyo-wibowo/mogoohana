<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'slug',
        'foto'
    ];

    protected $table = 'kategori';

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
