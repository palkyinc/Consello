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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('evento_id');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('pagada')->default(false);
            $table->boolean('usada')->default(false);
            $table->boolean('invitado')->default(false);
            $table->unsignedBigInteger('check_by_id');
            $table->foreign('check_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('creador_id');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('fecha_pago')->nullable();
            $table->string('ticket_code', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
