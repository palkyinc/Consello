<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\Evento;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;

class EventosEditMOdal extends Component
{
    public $evento;
    public $ant_evento_id;

    #[Reactive] 
    public $evento_id;

    #[Validate('required|min:2|max:255')]
    public $nombre;
    #[Validate('required|date')]
    public $fecha;
    #[Validate('required|string|max:65535')]
    public $descripcion = '';
    
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'Como mínimo 2 caracteres.',
        'nombre.max' => 'Como máximo 255 caracteres.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha no es válida.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.max' => 'Como máximo 65535 caracteres.',
    ];

    public function mount(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->ant_evento_id = $evento_id;
    }
    public function boot() 
    {
        if ($this->evento_id && $this->evento_id !== $this->ant_evento_id) {
            $this->evento = Evento::
                select("id", "nombre", "fecha", "descripcion", "creador_id")
                ->find($this->evento_id);
            $this->nombre = $this->evento->nombre;
            $this->fecha = $this->evento->fecha;
            $this->descripcion = $this->evento->descripcion;
            $this->ant_evento_id = $this->evento_id;
        }
    }
    public function render()
    {
        return view('livewire.eventos-edit-m-odal');
    }
    public function update()
    {
        $this->validate();
        $evento = Evento::find($this->evento_id);
        if ($evento) {
            $evento->nombre = $this->nombre;
            $evento->fecha = $this->fecha;
            $evento->descripcion = $this->descripcion;
            $evento->save();
        }
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('nombre');
        $this->reset('fecha');
        $this->reset('descripcion');
        $this->reset('evento');
        $this->reset('ant_evento_id');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
}
