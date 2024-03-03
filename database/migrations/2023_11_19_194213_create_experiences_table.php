<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('class_id');
            $table->string('year');
            $table->integer('hours_num');
            $table->foreign('emp_id')->references('id')
                ->on('employees')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')
                ->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('id')
                ->on('classses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
