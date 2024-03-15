<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        role::create([
            "name" => "مدير الفروع",
        ]);
        role::create([
            "name" => "مدير مدرسة",
        ]);
        role::create([
            "name" => "معاون مدير",
        ]);
        role::create([
            "name" => "أمين سر",
        ]);
        role::create([
            "name" => "موجه",
        ]);
        role::create([
            "name" => "مدرس",
        ]);
        role::create([
            "name" => "مستخدم عادي",
        ]);
    }
}
