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

Tu reserva / cuenta se encuentra al día y confirmada. Puedes consultar los detalles ingresando a tu panel.

<x-mail::button :url="config('app.url') . '/reservas'">
Mis Reservas
</x-mail::button>

Gracias por tu confianza,<br>
El equipo de **{{ config('app.name') }}**
</x-mail::message>