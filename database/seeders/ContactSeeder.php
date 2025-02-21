<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_admin')->insert([
            [
                'link_discord'   => 'https://discord.gg/example',
                'link_wa'        => 'https://wa.me/1234567890',
                'link_instagram' => 'https://instagram.com/example',
                'link_facebook'  => 'https://facebook.com/example',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
