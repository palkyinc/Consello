<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .header { background-color: #0d6efd; color: #fff; padding: 15px; text-align: center; border-radius: 6px 6px 0 0; }
        .detalle { margin: 20px 0; }
        .total { font-size: 18px; font-weight: bold; color: #0d6efd; }
    </style>
</head>
    <body>
        <div class="container">
            <div class="header">
                <h2>¡Reserva Confirmada!</h2>
            </div>
            <div class="detalle">
                <p>Hola <strong>{{ $reserva->creador->name }}</strong>,</p>
                <p>Tu reserva para el evento <strong>{{ $reserva->evento->nombre }}</strong> se ha registrado correctamente.</p>
                
                <hr>
                
                <p><strong>Cantidad reservadas: {{$reserva->cantidadReservadas()}}</strong></p>
                <p><strong>Detalle:</strong></p>
                <ul>
                    <li>ID Reserva: {{ $reserva->id }}</li>
                    @foreach($reserva->adicionales_cache as $adicional)
                        <li>{{ $adicional->adicional->nombre }} (x 1)</li>
                    @endforeach
                </ul>
                @foreach ($reserva->reservas as $reserva_adicional)
                <hr>
                    <ul>
                    <li>ID Reserva: {{ $reserva_adicional->id }}</li>
                    @foreach($reserva_adicional->adicionales_cache as $adicional)
                        <li>{{ $adicional->adicional->nombre }} (x 1)</li>
                    @endforeach
                </ul>
                @endforeach

                <p class="total">Total a Transferir: ${{ number_format($reserva->tot_pagado, 2, ',', '.') }}</p>
                <p>La reserva se mantendrá por las <strong>proximas 2hs</strong>.</p>
                <p>Para <strong>Confirmar</strong> tu <strong>Entrada</strong>, debes realizar la transferencia y cargar el comprobante en:</p>
                <a  href="{{ route('reservas') }}" 
                    style="background-color: #0d6efd; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                    Mis Reservas
                </a>
                <p class="card-text border p-2">{!! nl2br(e($reserva->evento->descripcion_transferencia)) !!}</p>
            <p>¡Muchas Gracias!</p>
        </div>
    </body>
</html>