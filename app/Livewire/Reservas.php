<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Reservas extends Component
{
    public $evento_id = 0;
    public $reserva_id = 0;

    public function render()
    {
        return view('livewire.reservas', ['reservas' => $this->getReservas()]);
    }
    private function getReservas()
    {
        return Auth()->User()->reservas;
    }
    #[On('closeModal')]
    public function closeModal (array $status = null)
    {
        if ($status) {
            session()->flash('status', $status['status']);
        }
        $this->dispatch('cerrarModal');

    }
    public function cbuAlias(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->dispatch('showcbuAliasModal');
    }    
    public function upFileDeposito(int $reserva_id)
    {
        $this->reserva_id = $reserva_id;
        $this->dispatch('showEditModal');
    }    
}
