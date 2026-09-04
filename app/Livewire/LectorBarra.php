<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Evento;
use App\Models\Adicional_Cache;


class LectorBarra extends Component
{
    public $adicionalesReserva = []; // Variable para almacenar el código QR leído
    public $evento_id;
    public $eventos;
    public $reserva; // Variable para almacenar la reserva encontrada
    
    public function mount()
    {
        $this->eventos = Evento::select("id", "nombre", "fecha")
                                ->where('fecha', now()->format('Y-m-d'))
                                ->orderBy('fecha')
                                ->get();

        // Asignas el ID del primer elemento si la lista no está vacía
        if ($this->eventos->isNotEmpty()) {
            $this->evento_id = $this->eventos->first()->id;
        }
    }
    public function validarTicket($ticketCode)
    {
        $this->adicionalesReserva = []; // Limpiar la lista de adicionales antes de buscar una nueva reserva
        $this->reserva = Reserva::where('ticket_code', $ticketCode)->first();
        if ($this->reserva) {
            if ($this->reserva->evento_id != $this->evento_id) {
                $status['danger'][] = 'QR pertenece a otro evento';
            }elseif (!$this->reserva->usada) {
                $status['warning'][] = 'QR no pasó por la Entrada';
            } else {
                $this->adicionalesReserva = Adicional_Cache::where('reserva_id', $this->reserva->id)->get();
                $status = [];
            }
        } else {
            $this->adicionalesReserva = [];
            $status['danger'][] = 'Ticket no encontrado';
        }
        session()->flash('status', $status);
    }
    public function render()
    {
        return view('livewire.lector-barra');
    }
    public function checkInAdicional($adicionalId)
    {
        $adicional = Adicional_Cache::find($adicionalId);
        if ($adicional) {
            $adicional->usada = true;
            $adicional->check_by_id = auth()->id();
            $adicional->save();
            $this->adicionalesReserva = Adicional_Cache::where('reserva_id', $this->reserva->id)->get();
            session()->flash('status', ['success' => ['Adicional Usado']]);
        } else {
            session()->flash('status', ['danger' => ['Adicional no encontrado']]);
        }
    }
}
