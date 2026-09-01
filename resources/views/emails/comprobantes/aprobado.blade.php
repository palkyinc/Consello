<x-mail::message>
# ¡Comprobante Aprobado!

Hola, **{{ $reserva->creador->name ?? 'Cliente' }}**.

Te informamos que la revisión de tu comprobante de depósito por el pago registrado ha sido **aprobada exitosamente**.

<x-mail::panel>
**Detalles de la transacción:**
* **Monto:** ${{ number_format($reserva->tot_pagado ?? 0, 2) }}
* **Fecha:** {{ \Carbon\Carbon::parse($reserva->created_at)->format('d/m/Y') }}
* **Referencia:** Reserva N: {{ $reserva->id ?? '' }}
* **Evento:** {{$reserva->evento->nombre ?? ''}}
</x-mail::panel>

Tu reserva es entrada confirmada. Puedes consultar los detalles ingresando a:

<x-mail::button :url="config('app.url') . '/reservas'">
Mis Reservas
</x-mail::button>

# Que Sigue?
* Si reservaste más de una entrada, debés asignar a los asistentes que las usarán en "Mis Reservas".
* Si no podés asistir, podrás cambiar la asignación de la entrada en "Mis Reservas".
* En las horas previas al evento recibirás un código con el que podrás ingresar al evento y disfrutar de los adicionales incluidos o comprados.<br>
# Verificá:
Si este correo ingresó a tu casilla en Spam o Correos no deseados configuralo como "Correo Deseado" para recibir nuestras notificaciones.<br>
# Dudas? Contactanos!
<x-mail::button :url="config('app.url') . '/contacto'">
Contacto
</x-mail::button>
<hr>

Gracias por tu confianza,<br>
Staff de **{{ config('app.name') }}**
</x-mail::message>