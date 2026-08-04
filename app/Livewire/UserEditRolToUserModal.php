<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Spatie\Permission\Models\Role;
use app\Models\User;

class UserEditRolToUserModal extends Component
{
    public $ant_user_id;
    public $roles = [];
    public $checkboxes = [];

    #[Reactive] 
    public $user_id;

    public function mount(int $user_id)
    {
        $this->user_id = $user_id;
        $this->ant_user_id = $user_id;
    }
    public function boot()
    {
        if ($this->user_id && $this->user_id !== $this->ant_user_id)
        {
            $this->ant_user_id = $this->user_id;
            $user = User::find($this->user_id);
            $this->roles = Role::all();
            $this->reset('checkboxes');
            foreach ($this->roles as $role) {
                if ($user->hasRole($role->name)) {
                    $this->checkboxes[] = $role->name;
                    }
                }
            }
    }
    public function render()
    {
        return view('livewire.user-edit-rol-to-user-modal');
    }
    public function updateRolToUser()
    {
        $user = User::find($this->user_id);
        foreach ($this->roles as $role) {
                $user->removeRole($role);
            }
        $user->assignRole($this->checkboxes);
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('roles');
        $this->reset('ant_user_id');
        $this->dispatch('closeModal');
    }
}
