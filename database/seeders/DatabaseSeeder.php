<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\KategoriSeeder;
use Database\Seeders\ProdukSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            ProdukSeeder::class,
            ContactSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
