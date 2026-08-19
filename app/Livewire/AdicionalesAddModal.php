<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AdicionalesAddModal extends Component
{
    
    public $evento_id = 0;
    public $status = null;

    #[Validate('required|integer|min:0|max:10')]
    public $cantidad = 0;

    #[Validate('required|string|max:45')]
    public $nombre = '';
    #[Validate('required|numeric|min:0')]
    public $precio = 0;

    protected $messages = [
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser mayor o igual a 0.',
        'cantidad.max' => 'La cantidad debe ser menor o igual a 10.',
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'Como máximo 45 caracteres.',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un numero',
        'precio.min' => 'El precio debe ser cero o mayor',
    ];

    public function mount($evento_id)
    {
        $this->evento_id = $evento_id;
    }

    public function render()
    {
        return view('livewire.adicionales-add-modal');
    }

    public function save()
    {
        $this->validate();
        $adicional = new \App\Models\Adicional();
        $adicional->cantidad = $this->cantidad;
        $adicional->nombre = $this->nombre;
        $adicional->precio = $this->precio;
        $adicional->evento_id = $this->evento_id;
        $adicional->creador_id = auth()->user()->id;
        $adicional->save();
        $this ->status['success'][] = 'Adicional: ' . $this->nombre . ' se ha creado correctamente.';
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('cantidad');
        $this->reset('nombre');
        $this->reset('precio');
        $this->resetValidation();
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
