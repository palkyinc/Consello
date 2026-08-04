<?php

namespace App\Livewire;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\On;
use Livewire\Component;

class Roles extends Component
{
    public $nombre;
    public $role_id = 0;

    public function render()
    {
        return view('livewire.roles', ['roles' => $this->getRoles()]);
    }
    public function getRoles()
    {
        return Role::whereRaw("UPPER(name) LIKE (?)", ["%{$this->upperData($this->nombre)}%"])->paginate(10);
    }
    private function upperData($data)
    {
        return strtoupper($data);
    }
    public function editRole (int $role_id)
    {
        $this->role_id = $role_id;
        $this->dispatch('showEditModal');
    }
    public function editPermissionsToRole(int $role_id)
    {
        $this->role_id = $role_id;
        $this->dispatch('showEditPermissionsToRoleModal');
    }
    
    #[On('closeModal')]
    public function closeModal ()
    {
        $this->dispatch('cerrarModal');
    }
}
