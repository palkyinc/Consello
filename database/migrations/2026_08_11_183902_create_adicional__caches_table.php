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
        Schema::create('adicional__caches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->unsignedBigInteger('adicional_id');
            $table->foreign('adicional_id')->references('id')->on('adicionals')->onDelete('cascade');
            $table->unsignedBigInteger('check_by_id')->nullable();
            $table->foreign('check_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('usada')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adicional__caches');
    }
};
