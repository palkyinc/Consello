<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; padding: 20px; }
        .card { background: #ffffff; border-radius: 12px; padding: 30px; max-width: 500px; margin: auto; border: 1px solid #e9ecef; }
        .btn { background-color: #7c73f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color: #38354a; margin-top: 0;">Hola, {{ $reserva->creador->name ?? 'Cliente' }}</h2>
        <p>Te informamos que tu reserva <strong>#{{ $reserva->id }}</strong> ha sido cancelada automáticamente debido a que transcurrieron 2 horas sin adjuntar el comprobante de pago.</p>
        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 20px 0;">
        <p>Si deseas realizar una nueva reserva, puedes ingresar a nuestro sitio web nuevamente.</p>
        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ url('/') }}" class="btn">Volver al sitio</a>
        </div>
    </div>
</body>
</html>