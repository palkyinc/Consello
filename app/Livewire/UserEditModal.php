<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;


class UserEditModal extends Component
{
    public $user;
    public $ant_user_id;

    #[Reactive] 
    public $user_id;
    
    
    #[Validate('required|email:rfc,dns')]
    public $email;

    #[Validate('required|min:2|max:255')]
    public $name;
    
    #[Validate(['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'])]
    public $password;
    public $password_confirmation;

    protected $messages = [
        'password.min' => 'Como mínimo 8 caracteres.',
        'password.regex' => 'Como mínimo 3 de estas 4: 1 Min, 1 Mayus, 1 Número, 1 Símbolo',
        'password.confirmed' => 'La confirmación y la contraseña no coinciden.',
        'name.required' => 'El nombre es obligatorio.',
        'email.required' => 'El email es obligatorio.',
        'email.unique' => 'Este email ya está registrado.',
        'email.email' => 'No es un email válido.',
        'name.min' => 'Como mínimo 2 caracteres.',
        'name.max' => 'Como máximo 255 caracteres.',
    ];
    
    public function mount(int $user_id)
    {
        $this->user_id = $user_id;
        $this->ant_user_id = $user_id;
    }
    public function boot() 
    {
        if ($this->user_id && $this->user_id !== $this->ant_user_id) {
            $this->user = User::
                select("id", "name", "email", "email_verified_at", "expire_at", "view_mode", "user_image_link", "created_at", "updated_at", "disabled")
                ->find($this->user_id);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->ant_user_id = $this->user_id;
        }
    }
    public function render()
    {
        return view('livewire.user-edit-modal');
    }
    public function closeModal()
    {
        $this->reset('name');
        $this->reset('email');
        $this->reset('user');
        $this->reset('ant_user_id');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
    public function update()
    {
        
        $this->validate([
            'email' => 'required|email:rfc,dns|unique:users,email,' . $this->user->id,
            'name' => 'required|min:2|max:255'
        ]);
        $this->user->name = $this->name;
        if ($this->user->email !== $this->email) {
            $this->user->email = $this->email;
            $this->user->email_verified_at = null;
        }
        $this->user->save();
        $this->closeModal();
    }

}
