<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use App\Models\Reserva;
use App\Models\Evento;

class LectorPuerta extends Component
{
    
    public $reservaReaded = ''; // Variable para almacenar el código QR leído
    public $evento_id;
    public $eventos;
    
    public function mount()
    {
        $this->eventos = Evento::select("id", "nombre", "fecha")
                                ->whereBetween('fecha', [
                                    now()->subDay()->format('Y-m-d'), 
                                    now()->format('Y-m-d')
                                ])
                                ->where('activo', true)
                                ->orderBy('fecha')
                                ->get();

        // Asignas el ID del primer elemento si la lista no está vacía
        if ($this->eventos->isNotEmpty()) {
            $this->evento_id = $this->eventos->first()->id;
        }
    }
    public function validarTicket($ticketCode)
    {
        $this->reservaReaded = Reserva::where('ticket_code', $ticketCode)->first();
        if ($this->reservaReaded) {
            if ($this->reservaReaded->evento_id != $this->evento_id) {
                $status['warning'][] = 'QR pertenece a otro evento';
                } elseif (!$this->reservaReaded->cliente) {
                    $status['warning'][] = 'QR con Asistente NO Asignado';
                } elseif (!$this->reservaReaded->pagada) {
                    $status['warning'][] = 'Reserva no está pagada';
                }else {
                    $status['success'][] = 'Reserva encontrada';
                    return;
                }
        } else {
        $status['danger'][] = 'Reserva no encontrada';
        }
        $this->reservaReaded = null; // Limpiar la reserva leída si pertenece a otro evento
            session()->flash('status', $status);
    }
    public function render()
    {
        return view('livewire.lector-puerta', [
            'reservas' => $this->getReservas(),
        ]);
    }
    public function getReservas ()
    {
        return Reserva::where('evento_id', $this->evento_id)->where('pagada', true)->get();
    }
    public function checkIn($reservaId)
    {
        $reserva = Reserva::find($reservaId);
        if ($reserva) {
            $reserva->usada = true;
            $reserva->check_by_id = auth()->id();
            $reserva->fecha_pago = now(); // Actualiza la fecha de pago al momento
            $reserva->save();
            $status['success'][] = 'Reserva marcada como usada';
            $this->reservaReaded = ''; // Actualiza la variable con la reserva marcada como usada
        } else {
            $status['error'][] = 'Reserva no encontrada';
        }
        session()->flash('status',$status);
    }
}
