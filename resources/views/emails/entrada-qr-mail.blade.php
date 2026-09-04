@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<html>
    <body>
        <h1>Entrada Qr Mail</h1>
        <p>Este es un correo de prueba para enviar entradas QR.</p>
        // Generar como PNG o SVG embebido para el correo
        <!-- En tu vista Blade del Mail -->
        <div style="width: 250px; margin: 0 auto;">
            {!! $qrCode !!}
        </div>
    </body>
</html>
