<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Form;
use App\Models\Evento;
use App\Models\Adicional;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Adicionales extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $evento;
    public $evento_id = 0;
    public $nombre;
    public $adicional_id = 0;

    public function mount($evento_id)
    {
        $this->evento = Evento::find($evento_id);
        $this->evento_id = $evento_id;
    }
    public function render()
    {
        return view('livewire.adicionales', ['adicionales' => $this->getAdicionales()]);
    }
    public function getAdicionales()
    {
        return Adicional::select("id", "nombre", "precio", "cantidad", "creador_id")
                    ->whereRaw("UPPER(nombre) LIKE (?)", ["%{$this->upperNombre()}%"])
                    ->where("evento_id", $this->evento->id)
                    ->paginate(10);
    }
    public function upperNombre()
    {
        return strtoupper($this->nombre);
    }
    #[On('closeModal')]
    public function closeModal (array $status = null)
    {
        if ($status) {
            session()->flash('status', $status['status']);
        }
        $this->dispatch('cerrarModal');

    }
    public function create()
    {
        $this->dispatch('showAddModal');
    }
    public function edit(int $adicional_id)
    {
        $this->adicional_id = $adicional_id;
        $this->dispatch('showEditModal');
    }
    public function delete(int $adicional_id)
    {
        $adicional = Adicional::find($adicional_id);
        if ($adicional) {
            $adicional->delete();
            $status['warning'][] = 'Adicional ' . $adicional->nombre . ' eliminado.';
            session()->flash('status', $status);
        }
    }
}
