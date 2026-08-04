<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesEditPermissionsToRoleModal extends Component
{
    public $role, $ant_role_id;
    public $permissions = [];
    public $checkboxes = [];
    
    #[Reactive] 
    public $role_id;

    public function mount(int $role_id)
    {
        $this->role_id = $role_id;
        $this->ant_role_id = $role_id;
    }
    public function boot()
    {
        if ($this->role_id && $this->role_id !== $this->ant_role_id)
        {
            $this->ant_role_id = $this->role_id;
            $this->role = Role::find($this->role_id);
            $permissionsAdded = $this->role->getPermissionNames();
            $this->permissions = Permission::select("id", "name")->get();
            $this->reset('checkboxes');
            foreach ($permissionsAdded as $permissionAdded) {
                    $this->checkboxes[] = $permissionAdded;
            }
        }
    }
   public function render()
    {
        return view('livewire.roles-edit-permissions-to-role-modal');
    }
    public function closeModal()
    {
        $this->reset('permissions');
        $this->reset('role');
        $this->reset('ant_role_id');
        $this->dispatch('closeModal');
    }
    public function update()
    {
        foreach ($this->permissions as $permission) {
            if (in_array($permission->name, $this->checkboxes)) {
                $permission->assignRole($this->role);
            } else {
                $permission->removeRole($this->role);
            }
        }
        $this->closeModal();
    }
}
