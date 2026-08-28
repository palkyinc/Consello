<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);
        $user = (User::where('email', $this->email)->first());
        if (!$user) {
            $this->reset('email');
            $this->addError('email', __('Email no registrado'));
        } elseif (!$user->disabled) {
            # code...
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $this->only('email')
            );
            if ($status != Password::RESET_LINK_SENT) {
                $this->addError('email', __($status));
                return;
            }
            $this->reset('email');
            session()->flash('status', __($status));
        } 
        else 
        {
            $this->reset('email');
            $this->addError('email', __('Usuario Deshabilitado'));
        }
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Olvidó su contraseña o tiene que renovarla? Ningún problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña que le permitirá elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>
