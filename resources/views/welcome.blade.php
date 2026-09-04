<!DOCTYPE html>
@php
    $fecha_limite= "2026-08-28T21:59:59";
@endphp
@if (new DateTime() > new DateTime($fecha_limite))
    <html lang="es">
    <head>
        <title>Consello</title>
        <meta charset="UTF-8">
        <!-- En el <head> -->
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- Opcional: Bootstrap 5 para estilos base limpios -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    /* Previene scroll no deseado */

    background-image: url('../img/pattern-02.png');
    background-size: contain;
    background-position: center;
    background-repeat: repeat;
    justify-content: center;
    background-color: #341b1b;
    font-family: 'Sora', sans-serif;
}

/* Header: 15% de la altura de la pantalla */
header {
    height: 15vh;
    display: flex;
    background-color: rgba(0, 0, 0, 0.3);
    align-items: center;
    justify-content: center;
    padding: 0 2rem;
    border-bottom: 1px solid #333;
}

/* Main: Ocupa exactamente el espacio restante (78vh) */
main {
    height: 78vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

/* La imagen se ajusta estrictamente al alto del main */
.img-evento {
    max-height: 100%;
    width: auto;
    aspect-ratio: 1 / 1;
    /* Garantiza proporción cuadrada */
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

/* Footer: 7% de la altura de la pantalla */
footer {
    height: 7vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.3);
    border-top: 1px solid #333;
    font-size: 0.85rem;
    color: #FFF;
}

footer a {
    text-decoration: none;
    color: red;
    font-weight: bold;
}
        </style>

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
            <img src="{{asset('img/1000708572.jpg')}}" alt="Flyer del Evento" class="img-evento">
        </main>

        <!-- Footer (7vh) -->
        <footer>
            <a class="btn btn-link" href="/login" target="_blank">LOGIN</a>
            <a class="btn btn-link" href="/contacto" target="_blank">CONTACTO</a>
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
                            <a href="/login" target="_blank">LOGIN</a>
                            <a href="/contacto" target="_blank">CONTACTO</a>
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
