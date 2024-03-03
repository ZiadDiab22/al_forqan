<?php

namespace Database\Seeders;

use App\Models\subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subjects')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        subject::create([
            "name" => "اللغة العربية",
        ]);
        subject::create([
            "name" => "اللغة الانكليزية",
        ]);
        subject::create([
            "name" => "اللغة الفرنسية",
        ]);
        subject::create([
            "name" => "الرياضيات",
        ]);
        subject::create([
            "name" => "الفيزياء",
        ]);
        subject::create([
            "name" => "الكيمياء",
        ]);
        subject::create([
            "name" => "العلوم",
        ]);
        subject::create([
            "name" => "التاريخ",
        ]);
        subject::create([
            "name" => "الجغرافية",
        ]);
        subject::create([
            "name" => "التفسير",
        ]);
        subject::create([
            "name" => "العقيدة",
        ]);
        subject::create([
            "name" => "الفقه",
        ]);
        subject::create([
            "name" => "الحديث الشريف",
        ]);
        subject::create([
            "name" => "التاريخ الإسلامي",
        ]);
    }
}
