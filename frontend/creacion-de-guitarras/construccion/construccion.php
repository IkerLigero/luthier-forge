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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script type="module" src="construccion.js"></script>

    <title>Luthier Forge - Configurar</title>

</head>

<body>

    <!-- NAVEGACIÓN SUPERIOR -->

    <nav class="nav-superior-configurador">
        <a href="../home/creacionGuitarras.html" class="nav-superior-boton">Menú</a>
        <a href="#" class="nav-superior-boton nav-superior-activo">Forja</a>
    </nav>

    <!-- LAYOUT CONFIGURADOR -->

    <div class="layout-configurador">

        <!-- PANEL CONFIGURACIÓN -->

        <aside id="panel-configuracion-guitarra" class="panel-configuracion-guitarra">

            <div class="seccion-componente">
                <button id="btn-cargar-cuerpo" class="boton-configurador">Cuerpos</button>
                <div id="menu-cuerpos" class="grid-componentes oculto"></div>
            </div>

            <div class="seccion-componente">
                <button id="btn-cargar-mastil" class="boton-configurador">Mástiles</button>
                <div id="menu-mastiles" class="grid-componentes oculto"></div>
            </div>

            <div class="seccion-componente">
                <button id="btn-cargar-pastillas" class="boton-configurador">Pastillas</button>
                <div id="menu-pastillas" class="grid-componentes oculto"></div>
            </div>

            <hr class="separador-panel">

            <button id="btn-reset-configuracion" class="boton-configurador boton-reset">
                Resetear
            </button>

            <button id="btn-guardar-configuracion" class="boton-configurador boton-guardar">
                Guardar Diseño
            </button>

        </aside>

        <!-- VISOR 3D -->

        <main id="visor-guitarra-3d" class="area-visor-3d"></main>

    </div>

</body>

</html>