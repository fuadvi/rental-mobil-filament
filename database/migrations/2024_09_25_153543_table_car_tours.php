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
        Schema::create('car_tours', function (Blueprint $table) {
          $table->id();
          $table->foreignId('car_id')->constrained('cars');
          $table->foreignId('tour_id')->constrained('tours');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_tours', function (Blueprint $table) {
          Schema::dropIfExists('car_tours');
        });
    }
};
