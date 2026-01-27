<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('cv_file')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('job_openings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
