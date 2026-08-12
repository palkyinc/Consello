<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Config;

class EventosAddModal extends Component
{
    #[Validate('required|string|max:50')]
    public $nombre = '';

    #[Validate('required|string|max:65535')]
    public $descripcion = '';

    #[Validate('required|date')]
    public $fecha = '';

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'Como máximo 50 caracteres.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.max' => 'Como máximo 65535 caracteres.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha no es válida.',
    ];

    public function render()
    {
        return view('livewire.eventos-add-modal');
    }
    public function save()
    {
        $this->validate();
        $evento = new \App\Models\Evento();
        $evento->nombre = $this->nombre;
        $evento->descripcion = $this->descripcion;
        $evento->fecha = $this->fecha;
        $evento->creador_id = auth()->user()->id;
        $evento->save();
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('nombre');
        $this->reset('descripcion');
        $this->reset('fecha');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
}
