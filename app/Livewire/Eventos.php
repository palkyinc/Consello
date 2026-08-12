<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Form;
use App\Models\Evento;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Eventos extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $evento_id = 0;

    public $nombre;

    public $mensajes = [];

    public function mount() 
    {
    }
    public function render()
    {
        return view('livewire.eventos',  ['eventos' => $this->getEventos()]);
    }

    #[On('closeModal')]
    public function closeModal ()
    {
        $this->dispatch('cerrarModal');
    }
    private function getEventos()
    {
        return Evento::select("id", "nombre", "fecha", "creador_id")
                    ->whereRaw("UPPER(nombre) LIKE (?)", ["%{$this->upperNombre()}%"])
                    ->paginate(10);
    }
    public function edit(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->dispatch('showEditModal');
    }
    public function upperNombre()
    {
        return strtoupper($this->nombre);
    }
    public function delete(int $evento_id)
    {
        $evento = Evento::find($evento_id);
        if ($evento) {
            $status['success'][] = 'Evento "' . $evento->nombre . '" eliminado correctamente.';
            $evento->delete();
        }
        else {
            $status['errors'][] = 'Evento no encontrado.';
        }
        session()->flash('status', $status);
    }
}
