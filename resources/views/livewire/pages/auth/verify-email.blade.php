<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Http\Request;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            if (Auth::user()->hasRole('Cliente'))
            {
                $this->redirectIntended(default: route('clientes', absolute: false), navigate: true);
            }else
            {
                $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            }
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Request $request): void
    {
        //$logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Gracias por registrarte! Antes de comenzar, debe verificar su casilla, haciendo click en el email que acabamos de enviar (Revise Spam/Correo No Deseado). Si no recibió el correo electrónico, con gusto le enviaremos otro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            {{ __('Reenviar email de verificación') }}
        </x-primary-button>

        <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
