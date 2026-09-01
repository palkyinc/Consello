<x-mail::message>
# Has sido invitado a un evento!

{{$reserva->creador->name}} te ha invitado a {{ $reserva->evento->nombre }}.
Para ver los detalles de tu entrada ingresa a:

<x-mail::button :url="config('app.url') . '/reservas'">
Mis Reservas
</x-mail::button>

* **Importante**: Si nunca has ingresado a nuestra plataforma, debés renovar tu contraseña usando el link de "Olvidé mi contraseña" en la página de inicio de sesión para poder acceder a tu cuenta y ver los detalles de tu entrada.
* En las horas previas al evento recibirás un código con el que podrás ingresar al evento y disfrutar de los adicionales incluidos o comprados.<br>
# Verificá:
Si este correo ingresó a tu casilla en Spam o Correos no deseados configuralo como "Correo Deseado" para recibir nuestras notificaciones.<br>
# Dudas? Contactanos!
<x-mail::button :url="config('app.url') . '/contacto'">
Contacto
</x-mail::button><hr>
Te esperamos para disfrutar de nuestro evento,<br>
Staff de {{ config('app.name') }}
</x-mail::message>
