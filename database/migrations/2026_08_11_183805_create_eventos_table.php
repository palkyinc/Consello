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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre', 50);
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ruta_archivo')->nullable(); // <--- Usar string (VARCHAR 255)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
