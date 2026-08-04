<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsEditModal extends Component
{
    public $permission, $ant_permission_id;
    public $roles = [];
    public $checkboxes = [];
    
    #[Reactive] 
    public $permission_id;
    
    public function mount(int $permission_id)
    {
        $this->permission_id = $permission_id;
        $this->ant_permission_id = $permission_id;
    }
    public function boot() 
    {
        if ($this->permission_id && $this->permission_id !== $this->ant_permission_id) {
            $this->ant_permission_id = $this->permission_id;
            $this->permission = Permission::find($this->permission_id);
            $rolesAdded = $this->permission->getRoleNames();
            $this->reset('checkboxes');
            $this->roles = Role::select("id", "name")->get();
            foreach ($rolesAdded as $roleAdded) {
                $this->checkboxes[] = $roleAdded;
            }
        }
    }
    public function render()
    {
        return view('livewire.permissions-edit-modal');
    }
    public function closeModal()
    {
        $this->reset('permission');
        $this->reset('roles');
        $this->reset('ant_permission_id');
        $this->dispatch('closeModal');
    }
    public function update()
    {
        foreach ($this->roles as $role) {
            if (in_array($role->name, $this->checkboxes)) {
                $role->givePermissionTo($this->permission);
            } else {
                $role->revokePermissionTo($this->permission);
            }
        }
        $this->closeModal();
    }
}
