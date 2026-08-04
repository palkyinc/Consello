<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\User;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\On;

class Users extends Component
{
    use WithPagination, WithoutUrlPagination;
        
    public $user_id = 0;

    public $email;

    public function mount() 
    {
    }
    public function render()
    {
        return view('livewire.users', ['users' => $this->getUsers()]);
    }

    #[On('closeModal')]
    public function closeModal ()
    {
        $this->dispatch('cerrarModal');
    }
    private function getUsers()
    {
        return User::select("id", "name", "email", "email_verified_at", "expire_at", "view_mode", "user_image_link", "created_at", "updated_at", "disabled")
                    ->whereRaw("UPPER(email) LIKE (?)", ["%{$this->upperEmail()}%"])
                    ->paginate(10);
    }
    public function edit(int $user_id)
    {
        $this->user_id = $user_id;
        $this->dispatch('showEditModal');
    }
    public function editRolToUser($user_id)
    {
        $this->user_id = $user_id;
        $this->dispatch('showEditRolToUserModal');
    }
    public function disable(int $user_id)
    {
        $user = User::find($user_id);
        $user->disabled = true;
        $user->save();
    }
    public function enable(int $user_id)
    {
        $user = User::find($user_id);
        $user->disabled = false;
        $user->save();
    }
    public function upperEmail()
    {
        return strtoupper($this->email);
    }
}