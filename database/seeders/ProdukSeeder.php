<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, get kategori IDs
        $stickerId = DB::table('kategori')->where('kategori', 'Sticker / Cards')->value('id');
        $accountsId = DB::table('kategori')->where('kategori', 'Accounts')->value('id');
        $diceBoostId = DB::table('kategori')->where('kategori', 'Dice Boost')->value('id');
        $monopolyGoId = DB::table('kategori')->where('kategori', 'Monopoly Go Partners Event')->value('id');

        $produks = [];
        for ($i=0; $i<5; $i++) {
            $harga = rand(10, 500) + rand(0, 9) / 10;
            $harga_diskon = rand(510, 1000) + rand(0, 9) / 10;
            $gambar = 'produk/b' . rand(3,5) . '.png';

            $produks[] = [
                'nama_produk' => 'Sticker Lucu ' . $i,
                'slug' => Str::slug('Sticker Lucu ' . $i),
                'deskripsi' => 'Sticker lucu yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 50,
                'foto' => $gambar,
                'id_kategori' => $stickerId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Sticker Keren ' . $i,
                'slug' => Str::slug('Sticker Keren ' . $i),
                'deskripsi' => 'Sticker keren yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 30,
                'foto' => $gambar,
                'id_kategori' => $stickerId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Akun Facebook ' . $i,
                'slug' => Str::slug('Akun Facebook ' . $i),
                'deskripsi' => 'Akun Facebook yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 20,
                'foto' => $gambar,
                'id_kategori' => $accountsId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Akun Instagram ' . $i,
                'slug' => Str::slug('Akun Instagram ' . $i),
                'deskripsi' => 'Akun Instagram yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 40,
                'foto' => $gambar,
                'id_kategori' => $accountsId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Dice Boost 10% ' . $i,
                'slug' => Str::slug('Dice Boost 10% ' . $i),
                'deskripsi' => 'Dice boost yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 50,
                'foto' => $gambar,
                'id_kategori' => $diceBoostId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Dice Boost 20% ' . $i,
                'slug' => Str::slug('Dice Boost 20% ' . $i),
                'deskripsi' => 'Dice boost yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 30,
                'foto' => $gambar,
                'id_kategori' => $diceBoostId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Partners Event ' . $i,
                'slug' => Str::slug('Partners Event ' . $i),
                'deskripsi' => 'Partners event yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 20,
                'foto' => $gambar,
                'id_kategori' => $monopolyGoId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $produks[] = [
                'nama_produk' => 'Premium Partners Event ' . $i,
                'slug' => Str::slug('Premium Partners Event ' . $i),
                'deskripsi' => 'Premium partners event yang dapat digunakan untuk berbagai keperluan',
                'harga' => $harga,
                'harga_diskon' => $harga_diskon,
                'stok' => 40,
                'foto' => $gambar,
                'id_kategori' => $monopolyGoId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('produk')->insert($produks);
    }
}
