<?php

namespace Database\Seeders;

use App\Models\nationality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('nationalities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        nationality::create([
            "name" => "سوريا",
        ]);
        nationality::create([
            "name" => "فلسطين",
        ]);
        nationality::create([
            "name" => "الأردن",
        ]);
        nationality::create([
            "name" => "لبنان",
        ]);
        nationality::create([
            "name" => "العراق",
        ]);
        nationality::create([
            "name" => "مصر",
        ]);
    }
}
