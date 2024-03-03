<?php

namespace Database\Seeders;

use App\Models\request_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequesttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('request_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        request_type::create([
            "name" => "teaching",
        ]);
        request_type::create([
            "name" => "employment",
        ]);
    }
}
