<?php

namespace Database\Seeders;

use App\Models\subject_classs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subject_classses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        subject_classs::create([
            "class_id" => 1,
            "subject_id" => 2,
        ]);
        subject_classs::create([
            "class_id" => 1,
            "subject_id" => 4,
        ]);
        subject_classs::create([
            "class_id" => 1,
            "subject_id" => 10,
        ]);
        subject_classs::create([
            "class_id" => 2,
            "subject_id" => 7,
        ]);
        subject_classs::create([
            "class_id" => 2,
            "subject_id" => 9,
        ]);
        subject_classs::create([
            "class_id" => 3,
            "subject_id" => 3,
        ]);
        subject_classs::create([
            "class_id" => 2,
            "subject_id" => 1,
        ]);
        subject_classs::create([
            "class_id" => 3,
            "subject_id" => 11,
        ]);
        subject_classs::create([
            "class_id" => 4,
            "subject_id" => 12,
        ]);
        subject_classs::create([
            "class_id" => 3,
            "subject_id" => 14,
        ]);
        subject_classs::create([
            "class_id" => 3,
            "subject_id" => 8,
        ]);
        subject_classs::create([
            "class_id" => 6,
            "subject_id" => 8,
        ]);
        subject_classs::create([
            "class_id" => 6,
            "subject_id" => 5,
        ]);
        subject_classs::create([
            "class_id" => 5,
            "subject_id" => 5,
        ]);
        subject_classs::create([
            "class_id" => 4,
            "subject_id" => 5,
        ]);
        subject_classs::create([
            "class_id" => 4,
            "subject_id" => 4,
        ]);
        subject_classs::create([
            "class_id" => 6,
            "subject_id" => 1,
        ]);
        subject_classs::create([
            "class_id" => 6,
            "subject_id" => 3,
        ]);
        subject_classs::create([
            "class_id" => 5,
            "subject_id" => 2,
        ]);
        subject_classs::create([
            "class_id" => 5,
            "subject_id" => 10,
        ]);
    }
}
