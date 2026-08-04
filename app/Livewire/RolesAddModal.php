<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAddModal extends Component
{
    #[Validate('required|min:2|max:255')]
    public $name = "";
    
    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.min' => 'Como mínimo 2 caracteres.',
        'name.confirmed' => 'Como máximo 255 caracteres.',
    ];
    
    public function render()
    {
        return view('livewire.roles-add-modal');
    }
    public function save()
    {
        $this->validate();
        Role::create([
            'name' => $this->name,
        ]);
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('name');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
}
