<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Evento;
use Livewire\Attributes\On;


class Clientes extends Component
{
    public $evento_id = 0;

    public function mount()
    {
        
    }
    public function render()
    {
        return view('livewire.clientes', ['eventos' => $this->getEventos()]);
    }
    public function getEventos()
    {
        return Evento::whereDate('fecha', '>=', now()->today())
                        ->where('activo', true)
                        ->get();
    }
    public function addReserva(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->dispatch('showAddModal');
    }
    #[On('closeModal')]
    public function closeModal (array $status = null)
    {
        if ($status) {
            session()->flash('status', $status['status']);
        }
        $this->dispatch('cerrarModal');

    }
}
