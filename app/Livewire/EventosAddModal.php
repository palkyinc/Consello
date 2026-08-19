<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Config;

class EventosAddModal extends Component
{
    public $status = null;    

    #[Validate('required|string|max:50')]
    public $nombre = '';

    #[Validate('required|string|max:65535')]
    public $descripcion = '';
    
    #[Validate('required|date')]
    public $fecha = '';

    #[Validate('required|numeric|min:0')]
    public $precio = 0;

    #[Validate('required|numeric|min:0|max:999')]
    public $aforo = 0;
    
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'Como máximo 50 caracteres.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.max' => 'Como máximo 65535 caracteres.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha no es válida.',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un numero',
        'precio.min' => 'El precio debe ser cero o mayor',
        'aforo.required' => 'El aforo es obligatorio',
        'aforo.numeric' => 'El aforo debe ser un numero',
        'aforo.min' => 'El aforo debe ser cero o mayor',
        'aforo.max' => 'El aforo debe ser menor a 1000',
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
        $evento->precio = $this->precio;
        $evento->aforo = $this->aforo;
        $evento->creador_id = auth()->user()->id;
        $evento->save();
        $this ->status['success'][] = 'Evento: ' . $this->nombre . ' se ha creado correctamente.';
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('nombre');
        $this->reset('descripcion');
        $this->reset('fecha');
        $this->reset('precio');
        $this->reset('aforo');
        $this->resetValidation();
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
