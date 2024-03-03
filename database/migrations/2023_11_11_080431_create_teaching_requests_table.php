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
        Schema::create('teaching_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('request_type_id')->default(1);;
            $table->string('name');
            $table->date('birth_date');
            $table->string('birth_city');
            $table->unsignedInteger('nationality_id');
            $table->string('academic_qualification');
            $table->string('issuing_authority'); //الجهة المانحة
            $table->string('acquisition_year');
            $table->string('study_place');
            $table->unsignedInteger('social_status_id');
            $table->unsignedInteger('military_service_id');
            $table->string('address');
            $table->string('tele_num');
            $table->string('mobile_num');
            $table->float('rating')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('request_type_id')->references('id')
                ->on('request_types')->onDelete('cascade');
            $table->foreign('nationality_id')->references('id')
                ->on('nationalities')->onDelete('cascade');
            $table->foreign('social_status_id')->references('id')
                ->on('social_statuses')->onDelete('cascade');
            $table->foreign('military_service_id')->references('id')
                ->on('military_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_requests');
    }
};
