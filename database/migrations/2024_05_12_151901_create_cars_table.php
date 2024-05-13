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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('duration');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('price');
            $table->tinyInteger('luggage');
            $table->tinyInteger('passenger');
            $table->string('car_type');
            $table->boolean('isDriver');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
