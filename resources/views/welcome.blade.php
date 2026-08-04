<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página con Logo</title>
    <style>
        body {
            background-color: #77dd77; /* Color verde pastel */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura de la ventana del navegador */
            margin: 0; /* Elimina márgenes por defecto */
        }
        img {
            max-width: 100%; /* Asegura que la imagen no exceda el ancho del contenedor */
            height: auto; /* Mantiene la proporción de la imagen */
        }
        /* <uniquifier>: Use a unique and descriptive class name */
        /* <weight>: Use a value from 300 to 800 */

        .open-sans-fonts {
            font-family: "Open Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            font-variation-settings:
                "wdth" 100;
        }
    </style>
</head>
<body>
    <div>
        <img src="icons/5991785_coronavirus_countries_infected_map_spread_icon.svg" alt="Logo" width="100">
    </div>
    <div>
        <h1 class="open-sans-fonts">PalkyDev</h1>
    </div>
</body>
</html>