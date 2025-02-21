<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'id'         => 1,
                'nama'       => 'admin',
                'username'   => 'admin',
                'password'   => Hash::make('123'),
                'created_at' => '2025-02-05 16:22:21',
                'updated_at' => '2025-02-08 15:51:00',
            ],
        ]);
    }
}
