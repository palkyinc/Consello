<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesEditModal extends Component
{
    public $role;
    public $ant_role_id;
    
    #[Reactive] 
    public $role_id;
    
    #[Validate('required|min:2|max:255')]
    public $name;

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.min' => 'Como mínimo 2 caracteres.',
        'name.confirmed' => 'Como máximo 255 caracteres.',
    ];

    public function mount(int $role_id)
    {
        $this->role_id = $role_id;
        $this->ant_role_id = $role_id;
    }
    public function boot() 
    {
        if ($this->role_id && $this->role_id !== $this->ant_role_id) {
            $this->role = Role::find($this->role_id);
            $this->name = $this->role->name;
            $this->ant_role_id = $this->role_id;
        }
    }
    public function render()
    {
        return view('livewire.roles-edit-modal');
    }
     public function closeModal()
    {
        $this->reset('name');
        $this->reset('ant_role_id');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
    public function update()
    {
        
        $this->validate();
        $this->role->name = $this->name;
        $this->role->save();
        $this->closeModal();
    }
}
