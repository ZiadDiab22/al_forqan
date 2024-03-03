<?php

namespace Database\Seeders;

use App\Models\sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sectors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        sector::create([
            "name" => "المهاجرين",
        ]);
        sector::create([
            "name" => "دمر ذكور",
        ]);
        sector::create([
            "name" => "دمر إناث",
        ]);
        sector::create([
            "name" => "القزاز",
        ]);
        sector::create([
            "name" => "زيد",
        ]);
        sector::create([
            "name" => "المزة",
        ]);
    }
}
