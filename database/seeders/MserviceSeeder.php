<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\military_service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MserviceSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('military_services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        military_service::create([
            "name" => "معفى من الخدمة",
        ]);
        military_service::create([
            "name" => "مؤجل",
        ]);
        military_service::create([
            "name" => "اخدم حاليا",
        ]);
        military_service::create([
            "name" => "منتهي من الخدمة",
        ]);
    }
}
