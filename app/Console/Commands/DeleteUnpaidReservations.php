<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use App\Models\Adicional_Cache;
use App\Mail\ReservaCanceladaMail;
use Illuminate\Support\Facades\Mail;

class DeleteUnpaidReservations extends Command
{
    /**
     * Nombre y firma del comando para la consola.
     */
    protected $signature = 'reservations:delete-unpaid';

    /**
     * Descripción del comando.
     */
    protected $description = 'Elimina las reservas no pagadas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $to_delete = Reserva::whereNull('ruta_comprobante')
            ->where('created_at', '<=', now()->subHours(2))
            ->get();

        foreach ($to_delete as $reserva) {
            // Borrar adicionales en caché vinculados
            Adicional_Cache::where('reserva_id', $reserva->id)->delete();

            // Definir la variable antes de usarla
            $emailDestino = $reserva->creador?->email;

            // Envío de email si es la reserva principal y existe email de contacto/usuario
            if (!$reserva->reserva_main_id && $emailDestino) {
                $reservaData = [
                    'id' => $reserva->id,
                    'creador' => $reserva->creador?->name ?? 'Cliente',
                    'created_at' => $reserva->created_at,
                ];

                Mail::to($emailDestino)->send(new ReservaCanceladaMail($reservaData));
            }

            // Eliminar reserva
            $reserva->delete();
        }

        $this->info("Se eliminaron {$to_delete->count()} reservas no pagadas.");
    }
}
