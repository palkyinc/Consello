<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Evento;
use App\Models\Reserva;
use App\Models\Adicional;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public $evento_id;
    public $eventos;
    public $reserva_id = 0;

    public function mount()
    {
        $this->eventos = Evento::select("id", "nombre", "fecha")
                                ->where('activo', true)
                                ->orderBy('fecha')
                                ->get();

        // Asignas el ID del primer elemento si la lista no está vacía
        if ($this->eventos->isNotEmpty()) {
            $this->evento_id = $this->eventos->first()->id;
        }
    }
    
    public function render()
    {
        return view('livewire.dashboard', [
            'evento' => $this->getEvento(),
            'reservas' => $this->getReservas(),
            'sinComprobante' => $this->getReservasSinComprobante(),
            'pagadas' => $this->getReservasPagadas(),
            'asignadas' => $this->getReservasAsignadas(),
            'adicionales' => $this->getAdicionales(),
            'recaudado' => $this->getRecaudacion(),
            ]);
    }
    #[On('closeModal')]
    public function closeModal (array $status = null)
    {
        if ($status) {
            session()->flash('status', $status['status']);
        }
        $this->dispatch('cerrarModal');

    }public function reservaParaConfirmar(int $reserva_id)
    {
        $this->reserva_id = $reserva_id;
        $this->dispatch('showEditModal');
    }
    public function getReservas ()
    {
        return Reserva::where('evento_id', $this->evento_id)->get();
    }
    public function getReservasSinComprobante ()
    {
        return Reserva::where('evento_id', $this->evento_id)
                        ->where('ruta_comprobante', null)
                        ->count();
    }
    public function getReservasPagadas ()
    {
        return Reserva::where('evento_id', $this->evento_id)
                        ->where('pagada', true)
                        ->count();
    }
    public function getReservasAsignadas ()
    {
        return Reserva::where('evento_id', $this->evento_id)
                        ->where('cliente_id', null)
                        ->count();
    }
    public function getEvento()
    {
        return Evento::select('*')
                        ->find($this->evento_id);
    }
    public function getAdicionales()
    {
        return Evento::select('*')->find($this->evento_id)->adicionales;
        
    }
    public function getRecaudacion()
    {
        $pagadas = Reserva::where('evento_id', $this->evento_id)
                            ->where('pagada', true)
                            ->get();
        $total = 0;
        foreach ($pagadas as $pagada) {
            if (!$pagada->reserva_main_id) {
                $total += $pagada->tot_pagado;
            }
        }
        return number_format($total ?? 0, 2);
    }
}
