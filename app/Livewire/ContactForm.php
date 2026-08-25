<?php

namespace App\Livewire;

use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';

    protected function rules(): array
    {
        return [
            'name'    => 'required|string|min:3|max:100',
            'email'   => 'required|email:rfc,dns',
            'phone'   => 'required|string|min:8|max:20',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required'    => 'El nombre es obligatorio.',
            'name.min'         => 'El nombre debe contener al menos 3 caracteres.',
            'email.required'   => 'El email es obligatorio.',
            'email.email'      => 'Ingresa un correo electrónico válido.',
            'phone.required'   => 'El celular es obligatorio.',
            'phone.min'        => 'Ingresa un número de celular válido.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.min'      => 'El mensaje debe tener al menos 10 caracteres.',
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->validate();

        $recipients = Config::get('constants.CONTACT_EMAILS', []);

        if (!empty($recipients)) {
            Mail::to($recipients)->send(new ContactFormMail($validatedData));
        }

        $this->reset(['name', 'email', 'phone', 'message']);

        session()->flash('success', '¡Tu mensaje ha sido enviado con éxito!');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}