<?php

namespace Database\Seeders;

use App\Models\classs;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('classses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        classs::create([
            "name" => "الصف الاول الاعدادي سابع",
        ]);
        classs::create([
            "name" => "الصف الثاني الاعدادي ثامن",
        ]);
        classs::create([
            "name" => "الصف الثالث الاعدادي تاسع",
        ]);
        classs::create([
            "name" => "الصف الأول الثانوي عاشر",
        ]);
        classs::create([
            "name" => "الصف الثاني الثانوي حادي عشر",
        ]);
        classs::create([
            "name" => "الصف الثالث الثانوي بكالوريا",
        ]);
    }
}
