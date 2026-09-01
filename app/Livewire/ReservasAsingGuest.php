<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Mail\AsignadoEntradaMail;
use Illuminate\Support\Facades\Mail;

class ReservasAsingGuest extends Component
{
    public $status = null;
    public $email;
    public $name;
    public $ant_reserva_id;
    public $estaRegistrado = true;
    #[Reactive] 
    public $reserva_id;

    public function render()
    {
        return view('livewire.reservas-asing-guest');
    }
    public function update ()
    {
        $validated = $this->validate([
            'name' => ['nullable', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255']
        ], [
            'name.required' => __('El nombre es obligatorio'),
            'name.string' => __('El nombre debe ser una cadena de texto'),
            'name.min' => __('El nombre debe tener al menos 5 caracteres'),
            'name.max' => __('El nombre no debe exceder los 255 caracteres'),
            'email.required' => __('El email es obligatorio'),
            'email.string' => __('El email debe ser una cadena de texto'),
            'email.lowercase' => __('El email debe estar en minúsculas'),
            'email.email' => __('El email debe ser una dirección de correo electrónico válida'),
            'email.max' => __('El email no debe exceder los 255 caracteres'),
            'email.unique' => __('El email ya está registrado'),
        ]);
        $userRegister = User::where('email', $this->email)->first();
        $this->estaRegistrado = $userRegister ? true : false;
        if (!$userRegister && !$this->name) {
            $this->addError('email', 'No lo tenemos registrado.');
            $this->addError('name', 'Completá para poder registrarlo.');
            return;
        }
        if ($userRegister && Reserva::where('cliente_id', $userRegister->id)->first()) {
            $this->addError('email', 'Ya tiene una entrada asignada.');
            return;
        }
        $reserva = Reserva::find($this->reserva_id);
        if($userRegister)
        {
            $reserva->cliente_id = $userRegister->id;
        } else {
            # Registrar user
            $cliente = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('l8!=Z1Pm3O!:'),
                'expire_at' => time(),
            ]);
            $cliente->fresh();
            $cliente->assignRole('cliente');
            # Asignar reserva a user
            $reserva->cliente_id = $cliente->id;
            }
        $reserva->save();
        $this->status['success'][] = $this->email . ' fue asignado para asistir con la Reserva: ' . $reserva->id;
        ##email
        Mail::to($this->email)->send(new AsignadoEntradaMail($reserva));
        $this->status['success'][] = 'Se envió email con informacion a:' . $this->email . '. (Verficar Spam o Correos no deseados)';
        ##Status
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('email');
        $this->reset('ant_reserva_id');
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
