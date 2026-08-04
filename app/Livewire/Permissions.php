<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $nombre;
    public $permission_id = 0;

    public function render()
    {
        return view('livewire.permissions', ['permissions' => $this->getPermissions()]);
    }
    #[On('closeModal')]
    public function closeModal ()
    {
        $this->dispatch('cerrarModal');
    }
    public function getPermissions()
    {
        return Permission::whereRaw("UPPER(name) LIKE (?)", ["%{$this->upperData($this->nombre)}%"])->paginate(10);
    }
    private function upperData($data)
    {
        return strtoupper($data);
    }
    public function factoryPermissions()
    {
        $User = User::find(1);
        $listRols = Config::get('constants.ROLES_LIST_FACTORY');
        $roles = Role::get();
        foreach ($roles as $key => $rol) {
            if(false !== ($listRols_key = array_search($rol->name, $listRols)))
            {
                unset($listRols[$listRols_key]);
            }
        }
        if (!empty($listRols)) {
            foreach ($listRols as $key => $listRol) {
                Role::create(['name' => $listRol]);
                $User->assignRole($listRol);
            }
            $status['success'][] = 'Roles Factory actualizados.';
        } else {
            $status['warning'][] = 'Sin Roles para actualizar.';
        }
        $listPermissions = Config::get('constants.PERMISSIONS_LIST_FACTORY');
        $permissions = Permission::get();
        foreach ($permissions as $key => $permission) {
            if(false !== ($listPermissions_key = array_search($permission->name, $listPermissions)))
            {
                unset($listPermissions[$listPermissions_key]);
            }
        }
        $rolAdmin = Role::find(1);
        if (!empty($listPermissions)) {
            foreach ($listPermissions as $key => $listPermission) {
                $permission = Permission::create(['name' => $listPermission]);
                $permission->assignRole($rolAdmin);
            }
            $status['success'][] = 'Permisos Factory actualizados.';
        } else {
            $status['warning'][] = 'Sin Permisos para actualizar.';
        }
        session()->flash('status', $status);
    }
    public function editPermissionsToRole(int $permission_id)
    {
        $this->permission_id = $permission_id;
        $this->dispatch('showEditModal');
    }    
}
