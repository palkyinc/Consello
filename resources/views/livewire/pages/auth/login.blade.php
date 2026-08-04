<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    public $flag_expiredPass = false;
    public $email;
    
    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (Auth::user()->disabled)
        {
            $this->closeSession($request);
            $this->addError('form.email', __('Usuario Deshabilitado'));
        }
        elseif (time() > Auth::user()->expire_at)
        {
            $this->email = $this->form->email;
            $status = Password::sendResetLink(
                $this->only('email')
                
            );
            if ($status != Password::RESET_LINK_SENT) {
                $this->addError('form.email', __($status));
            }
            $this->flag_expiredPass = true;
            $this->closeSession($request);
        } 
        elseif (Auth::user()->hasRole('Cliente'))
        {
            $this->redirectIntended(default: route('clientes', absolute: false), navigate: true);
        }else
        {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
    private function closeSession(Request $request)
    {
        $this->reset('form.email');
        $this->reset('form.password');
        $this->reset('email');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            <div>
                @if ($flag_expiredPass)
                    <div style="color:red">Tu password ha expirado. Te enviamos un mail.</div>
                @endif
            </div>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recuerdame') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <!-- Register -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}" wire:navigate>
                {{ __('¿No tienes cuenta? Registrate') }}
            </a>
            @endif
        </div>
    </form>
</div>
