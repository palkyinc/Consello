<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Form;
use App\Models\Evento;
use App\Models\Adicional;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Eventos extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $evento_id = 0;

    public $nombre;

    public function mount() 
    {
    }
    public function render()
    {
        return view('livewire.eventos',  ['eventos' => $this->getEventos()]);
    }

    #[On('closeModal')]
    public function closeModal (array $status = null)
    {
        if ($status) {
            session()->flash('status', $status['status']);
        }
        $this->dispatch('cerrarModal');

    }
    private function getEventos()
    {
        return Evento::select("id", "nombre", "fecha", "precio", "creador_id")
                    ->whereRaw("UPPER(nombre) LIKE (?)", ["%{$this->upperNombre()}%"])
                    ->paginate(10);
    }
    public function edit(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->dispatch('showEditModal');
    }
    public function editFile(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->dispatch('showEditFileModal');
    }
    public function upperNombre()
    {
        return strtoupper($this->nombre);
    }
    public function delete(int $evento_id)
    {
        $evento = Evento::find($evento_id);
        if ($evento) {
            if($evento->ruta_archivo) {
                 \Storage::disk('public')->delete($evento->ruta_archivo);
            }
            ##Borrar Adicionales
            if ($adicionales = Adicional::where('evento_id', $evento->id)->get()) {
                foreach ($adicionales as $adicional) {
                    $adicional->delete();
                }
                $status['warning'][] = 'Adicionales relacionados con el Evento "' . $evento->nombre . '" eliminados correctamente.';
            }
            #Borrar Adiocionales_Cache
            #Borrar Reservas
            $status['warning'][] = 'Evento "' . $evento->nombre . '" eliminado correctamente.';
            $evento->delete();
        }
        else {
            $status['errors'][] = 'Evento no encontrado.';
        }
        $status['warning'][] = 'Verificar dependencias antes de eliminar.';
        session()->flash('status', $status);
    }
}
