<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class UserAddModal extends Component
{
    #[Validate('required|min:2|max:255')]
    public $name = "";
    
    #[Validate('required|email:rfc,dns|unique:users,email')]
    public $email = "";
    
    #[Validate(['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'])]
    public $password;
    public $password_confirmation;

    protected $messages = [
        'password.min' => 'Como mínimo 8 caracteres.',
        'password.regex' => 'Como mínimo 3 de estas 4: 1 Min, 1 Mayus, 1 Número, 1 Símbolo',
        'password.confirmed' => 'La confirmación y la contraseña no coinciden.',
    ];
    
    public function render()
    {
        return view('livewire.user-add-modal');
    }

    public function save()
    {
        $this->validate();
        User::create([
            'expire_at' => time(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('name');
        $this->reset('email');
        $this->reset('password');
        $this->reset('password_confirmation');
        $this->resetValidation();
        $this->dispatch('closeModal');
    }
}
