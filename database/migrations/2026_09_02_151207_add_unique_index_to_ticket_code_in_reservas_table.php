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
        // 1. Rellenar registros existentes que tengan ticket_code nulo o vacío
        $reservasSinCodigo = DB::table('reservas')
            ->whereNull('ticket_code')
            ->orWhere('ticket_code', '')
            ->get();

        foreach ($reservasSinCodigo as $reserva) {
            $fecha = $reserva->created_at ? \Carbon\Carbon::parse($reserva->created_at)->format('Ymd') : date('Ymd');
            $paddedId = str_pad($reserva->id, 5, '0', STR_PAD_LEFT);
            $randomHash = strtoupper(Str::random(6));

            DB::table('reservas')
                ->where('id', $reserva->id)
                ->update([
                    'ticket_code' => "{$fecha}-{$paddedId}-{$randomHash}"
                ]);
        }

        // 2. Agregar el índice único a la columna existente
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('ticket_code')->nullable()->unique()->change();
            $table->boolean('mail_sent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropUnique(['ticket_code']);
            $table->dropColumn('mail_sent');
        });
    }
};
