<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use App\Models\Evento;



class ReservasCbuAliasModal extends Component
{
    
    public $status = null;
    public $descripcion_transf = '';
    public $ant_evento_id;
    #[Reactive] 
    public $evento_id;

    public function render()
    {
        return view('livewire.reservas-cbu-alias-modal');
    }

    public function mount(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->ant_evento_id = $evento_id;
    
    }
    public function boot() 
    {
        if ($this->evento_id && $this->evento_id !== $this->ant_evento_id) {
            $this->evento = Evento::
                select('descripcion_transferencia')
                ->find($this->evento_id);
            $this->descripcion_transf = $this->evento->descripcion_transferencia;
            $this->ant_evento_id = $this->evento_id;
        }
    }
    public function closeModal()
    {
        $this->reset('descripcion_transf');
        $this->reset('ant_evento_id');
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
