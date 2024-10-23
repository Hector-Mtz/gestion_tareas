<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('status')->insert([
            'name' => "Nueva",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('status')->insert([
            'name' => "En proceso",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('status')->insert([
            'name' => "En revisión",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('status')->insert([
            'name' => "Completada",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
