<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Queue\SerializesModels;

class CustomResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct($token)
    {
        parent::__construct($token);
    }
    
    /**
     * Construye el mensaje de correo.
     */
    public function toMail($notifiable)
    {
        // Construye la URL de recuperación usando el token y el email del usuario
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Restablecer contraseña')
            ->line('Recibiste este correo porque solicitaste un restablecimiento de contraseña para tu cuenta.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace para restablecer la contraseña caducará en ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' minutos.')
            ->line('Si no solicitaste un restablecimiento de contraseña, no se requiere ninguna otra acción.');
    }
}
