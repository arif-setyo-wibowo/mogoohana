<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'slug',
        'id_kategori',
        'stok',
        'harga',
        'harga_diskon',
        'foto',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::generateUniqueSlug($model->nama_produk);
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_produk')) {
                $model->slug = self::generateUniqueSlug($model->nama_produk, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $existingId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Query to check slug existence, excluding the current model if updating
        $query = self::where('slug', $slug);
        if ($existingId) {
            $query->where('id', '!=', $existingId);
        }

        // Check if the slug exists
        while ($query->exists()) {
            // If it exists, append a number
            $slug = $originalSlug . '-' . $count;
            $count++;

            // Update the query with the new slug
            $query = self::where('slug', $slug);
            if ($existingId) {
                $query->where('id', '!=', $existingId);
            }
        }

        return $slug;
    }

    // Relationship with Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
