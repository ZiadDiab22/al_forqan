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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sector_id');
            $table->string('name');
            $table->date('birth_date');
            $table->string('birth_city');
            $table->unsignedInteger('nationality_id');
            $table->string('subject')->nullable()->default(null);
            $table->boolean('contracted');
            $table->boolean('active');
            $table->string('father_name');
            $table->string('mother_name');
            $table->unsignedInteger('social_status_id');
            $table->integer('childs_num');
            $table->string('rest_place'); // مكان قيد النفوس
            $table->integer('comp_num'); //عدد من يتقاضى عنهم تعويضا عائليا 
            $table->string('nat_num'); //الرقم الوطني
            $table->string('address');
            $table->string('tele_num')->nullable()->default(null);
            $table->string('mobile_num')->nullable()->default(null);
            $table->string('autograph_photo')->nullable()->default(null);
            $table->string('work');
            $table->string('from');
            $table->integer('AppBook_num'); //كتاب التعيين 
            $table->date('AppBook_date');
            $table->date('start_date');
            $table->date('leave_date')->nullable()->default(null);
            $table->boolean('military');
            $table->string('military_rank')->nullable()->default(null);
            $table->string('school')->nullable()->default(null);
            $table->foreign('sector_id')->references('id')
                ->on('sectors')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')
                ->on('nationalities')->onDelete('cascade');
            $table->foreign('social_status_id')->references('id')
                ->on('social_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
