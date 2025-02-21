<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'kategori' => 'Sticker / Cards',
                'slug' => Str::slug('Sticker / Cards'),
                'foto' => 'kategori/stickers.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori' => 'Accounts',
                'slug' => Str::slug('Accounts'),
                'foto' => 'kategori/accounts.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori' => 'Dice Boost',
                'slug' => Str::slug('Dice Boost'),
                'foto' => 'kategori/dice.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori' => 'Monopoly Go Partners Event',
                'slug' => Str::slug('Monopoly Go Partners Event'),
                'foto' => 'kategori/pe.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('kategori')->insert($kategori);
    }
}
