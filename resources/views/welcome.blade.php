<!DOCTYPE html>
@php
    $fecha_limite= "2026-08-28T21:59:59";
@endphp
@if (new DateTime() > new DateTime($fecha_limite))
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consello</title>
        <!-- Opcional: Bootstrap 5 para estilos base limpios -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- En el <head> -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/welcome_style.css">

    </head>
    <body>

        <!-- Header (15vh) -->
        <header>
            <div>
                <h1 class="h4 mb-1 fw-bold text-white px-4">¿ESTÁS ADENTRO O TE LO VAN CONTAR?</h1>
            </div>
            <a href="{{ route('clientes') }}" class="btn btn-secondary btn-lg fw-bold px-4" data-discover="false" rel="external">
                Quiero ir!
            </a>
        </header>

        <!-- Main (78vh) -->
        <main>
            <img src="../img/1000708572.jpg" alt="Flyer del Evento" class="img-evento">
        </main>

        <!-- Footer (7vh) -->
        <footer>
            <p class="mb-0">&copy; {{ date('Y') }} CONSELLO CPM. Todos los derechos reservados. Developed By: </p>
            <a href="http://palkyinc.ar" target="blank">PalkyInc</a>
        </footer>

    </body>
    </html>
@else
    <html>
        <head>
            <title>Consello</title>
            <meta charset="utf-8">
            <meta name="description" content="">
            <meta name="author" content="">
            <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/blue.css" class="colors">
        </head>

        <body id="home">
            
            <div id="header">
                <div class="header-content">
                    <div class="countdown" id="countdown">
                        <div class="container">
                            <div class="row">
                                <div class="countdown-title">
                                    ENTRADAS A LA VENTA EN:
                                </div>
                            </div>
                            <div class="row">
                                <div class="countdown-item col-sm-3 col-xs-3">
                                    <div class="countdown-number" id="countdown-days">440</div>
                                    <div class="countdown-label">days</div>
                                </div>

                                <div class="countdown-item col-sm-3 col-xs-3">
                                    <div class="countdown-number" id="countdown-hours">04</div>
                                    <div class="countdown-label">hours</div>
                                </div>

                                <div class="countdown-item col-sm-3 col-xs-3">
                                    <div class="countdown-number" id="countdown-minutes">51</div>
                                    <div class="countdown-label">minutes</div>
                                </div>

                                <div class="countdown-item col-sm-3 col-xs-3">
                                    <div class="countdown-number" id="countdown-seconds">44</div>
                                    <div class="countdown-label">seconds</div>
                                </div>
                            </div>
                        <div class="row">
                            <!-- <form id="newsletter-form" action="send.php" method="POST" class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 myform" novalidate>
                                <div class="input-group">
                                    <input id="newsletter-mail" name="email" placeholder="Enter your email" class="form-control input-lg requiredField" type="email" data-error-empty="Please enter your email" data-error-invalid="Invalid email address">
                                    <span class="input-group-btn">
                                        <button name="submit" type="submit" class="btn" data-error-message="Error!" data-sending-message="Sending..." data-ok-message="Message Sent">Subscribe!</button>
                                    </span>
                                </div>
                                <input type="hidden" name="submitted" id="submitted2" value="true">
                            </form> -->
                        </div>	
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div>
                                <ul class="social-links text-center">
                                    <!-- <li><a href="#link"><i class="icon-twitter"></i></a></li>
                                    <li><a href="#link"><i class="icon-facebook"></i></a></li>
                                    <li><a href="#link"><i class="icon-googleplus"></i></a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <footer>
                        <div class="copyright">
                            <p class="text-center">&copy; Consello 2026. Designed by <a href="http://www.palky.ar" target="_blank">Palky Inc</a>.<br>
                            </p>
                        </div>
                    </footer>
                </div>
            </div>
                
            <script>
                // Configura la fecha objetivo del contador
                const targetDate = new Date("{{$fecha_limite}}").getTime();

                function updateCountdown() {
                    const now = new Date().getTime();
                    const difference = targetDate - now;

                    if (difference <= 0) {
                        document.getElementById("countdown-days").innerText = "00";
                        document.getElementById("countdown-hours").innerText = "00";
                        document.getElementById("countdown-minutes").innerText = "00";
                        document.getElementById("countdown-seconds").innerText = "00";

                        // Recarga la página automáticamente al llegar a cero
                        location.reload();
                        return;
                    }

                    // Cálculo de días, horas, minutos y segundos
                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                    // Formateo a 2 dígitos
                    document.getElementById("countdown-days").innerText = String(days).padStart(2, '0');
                    document.getElementById("countdown-hours").innerText = String(hours).padStart(2, '0');
                    document.getElementById("countdown-minutes").innerText = String(minutes).padStart(2, '0');
                    document.getElementById("countdown-seconds").innerText = String(seconds).padStart(2, '0');
                }

                // Ejecuta inmediatamente y luego cada segundo
                updateCountdown();
                const interval = setInterval(updateCountdown, 1000);
            </script>
        </body>
    </html>
@endif
