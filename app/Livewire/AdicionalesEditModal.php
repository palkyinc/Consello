<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\Adicional;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

class AdicionalesEditModal extends Component
{
    use WithFileUploads;
    
    public $adicional;
    public $ant_adicional_id;
    public $status = null;

    #[Reactive] 
    public $adicional_id;

    #[Validate('required|min:2|max:45')]
    public $nombre;
    #[Validate('required|integer|min:1|max:10')]
    public $cantidad;
    #[Validate('required|numeric|min:0')]
    public $precio = 0;

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'Como mínimo 2 caracteres.',
        'nombre.max' => 'Como máximo 45 caracteres.',
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser al menos 1.',
        'cantidad.max' => 'La cantidad no debe superar los 10.',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un numero',
        'precio.min' => 'El precio debe ser cero o mayor',
    ];

    public function mount(int $adicional_id)
    {
        $this->adicional_id = $adicional_id;
        $this->ant_adicional_id = $adicional_id;
    }
    public function boot() 
    {
        if ($this->adicional_id && $this->adicional_id !== $this->ant_adicional_id) {
            $this->adicional = Adicional::
                select("id", "nombre", "cantidad", "precio")
                ->find($this->adicional_id);
            $this->nombre = $this->adicional->nombre;
            $this->cantidad = $this->adicional->cantidad;
            $this->precio = $this->adicional->precio;
            $this->ant_adicional_id = $this->adicional_id;

        }
    }
    public function render()
    {
        return view('livewire.adicionales-edit-modal');
    }
    public function update()
    {
        $this->validate();
        $this->adicional->nombre = $this->nombre;
        $this->adicional->cantidad = $this->cantidad;
        $this->adicional->precio = $this->precio;
        $this->adicional->save();
        $this->status['success'][] = 'Adicional "' . $this->adicional->nombre . '" actualizado correctamente.';
        $this->dispatch('closeModal', ['status' => $this->status]);
    }
    public function closeModal (array $status = null)
    {
        $this->reset(['nombre', 'cantidad', 'precio']);
        $this->resetValidation();
        $this->dispatch('cerrarModal');
        $this->reset('status');
    }

}
