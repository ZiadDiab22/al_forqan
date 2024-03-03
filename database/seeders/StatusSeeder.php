<?php

namespace Database\Seeders;

use App\Models\social_status;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('social_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        social_status::create([
            "name" => "متزوج",
        ]);
        social_status::create([
            "name" => "أعزب",
        ]);
        social_status::create([
            "name" => "مطلق",
        ]);
        social_status::create([
            "name" => "أرمل",
        ]);
    }
}
