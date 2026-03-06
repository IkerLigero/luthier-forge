<?php
require "../../../backend/php/comprobar_sesion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/examples/jsm/": "https://unpkg.com/three@0.160.0/examples/jsm/"
            }
        }
    </script>
    <script type="module" src="construccion.js"></script>
    <title>Luthier Forge - Configurar</title>
</head>
<body>
    <div class="contenedor">
        <aside id="configuracion-guitarras">
            <div class="menu-seccion">
                <button id="cargar-forma" class="btn">Cuerpos</button>
                <div id="sub-forma" class="submenu hidden"></div>
            </div>

            <div class="menu-seccion">
                <button id="cargar-mastil" class="btn">Mástiles</button>
                <div id="sub-mastil" class="submenu hidden"></div>
            </div>

            <div class="menu-seccion">
                <button id="cargar-pastillas" class="btn">Pastillas</button>
                <div id="sub-pastillas" class="submenu hidden"></div>
            </div>

            <hr class="separator">
            
            <button id="borrar-canvas" class="btn btn-secondary">Resetear</button>
            <button id="guardar-guitarra" class="btn btn-success">Guardar Diseño</button>
        </aside>

        <main id="canvas-three">
            </main>
    </div>
</body>
</html>