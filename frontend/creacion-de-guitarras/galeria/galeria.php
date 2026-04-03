<?php
require_once "../../../backend/php/comprobar_sesion.php";
require_once "../../../backend/php/conexion.php";

$id_user = $_SESSION['id_usuario'];

// Consulta para obtener las guitarras del usuario junto con los datos necesarios para mostrar en la galería
$sql = "SELECT gu.id_guitarra_usuario, 
            fc.referencia_glb AS glb_forma, 
            fc.descripcion AS nombre_forma,
            fc.precio AS precio_forma,
            m.referencia_glb AS glb_mastil, 
            m.nombre AS nombre_mastil,
            m.precio AS precio_mastil,
            pm.referencia_glb AS glb_pastillas,
            pm.tipo AS nombre_pastillas
        FROM guitarra_usuario gu
        JOIN forma_color fc ON gu.id_forma_color = fc.id_forma_color
        JOIN mastil m ON gu.id_mastil = m.id_mastil
        JOIN pastilla_modelo pm ON gu.id_pastilla_modelo = pm.id_pastilla_modelo
        WHERE gu.id_usuario = '$id_user'";

// Ejecutamos la consulta y obtenemos el resultado
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Galería - Luthier Forge</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="galeria.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/examples/jsm/": "https://unpkg.com/three@0.160.0/examples/jsm/"
            }
        }
    </script>
</head>
<body>
    <nav class="pildora-superior">
        <a href="../home/creacionGuitarras.html" class="btn-pildora">Menú</a>
        <a href="#" class="btn-pildora activo">Forja</a>
    </nav>

    <h1 class="titulo-galeria">Tus guitarras, luthier</h1>

    <div id="seccion-ia" style="max-width: 900px; margin: 0 auto 30px; text-align: center;">
        <button type="button" id="btn-comparar-maestro" class="btn-carrito" style="background-color: #1a1a1a; border-color: #1a1a1a;">
            Selecciona 2 guitarras para comparar
        </button>
        
        <div id="contenedor-resultado-ia" style="display:none; margin-top: 20px; text-align: left; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-left: 5px solid #8c2411;">
            <h2 style="font-family: 'Playfair Display'; margin-top:0;">Análisis del Maestro Luthier</h2>
            <div id="texto-ia" style="font-family: 'Montserrat'; line-height: 1.8; color: #333; white-space: pre-line;">
                </div>
            <button type="button" onclick="cerrarIA()" style="margin-top:15px; background:none; border:none; color:#8c2411; cursor:pointer; font-weight:700;">Cerrar análisis</button>
        </div>
    </div>

    <!-- Galería de guitarras del usuario -->
    <div class="galeria-grid">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <?php $precio_total = $row['precio_forma'] + $row['precio_mastil']; ?>
                
                <!-- Cada tarjeta de guitarra con los datos obtenidos de la consulta, por cada guitarra del usuario -->
                <div class="card-guitarra" id="card-<?php echo $row['id_guitarra_usuario']; ?>" onclick="seleccionarParaComparar(this)">
                    <div class="canvas-container" 
                        data-forma="<?php echo $row['glb_forma']; ?>"
                        data-mastil="<?php echo $row['glb_mastil']; ?>" 
                        data-pastillas="<?php echo $row['glb_pastillas']; ?>">
                    </div>
                    
                    <!-- Información de la guitarra y botón de compra -->
                    <div class="info-guitarra">
                        <p><strong>Componentes:</strong></p>
                        <small>
                            Cuerpo: <span class="val-cuerpo"><?php echo $row['nombre_forma']; ?></span><br>
                            Mástil: <span class="val-mastil"><?php echo $row['nombre_mastil']; ?></span><br>
                            Pastillas: <span class="val-pastillas"><?php echo ucfirst($row['nombre_pastillas']); ?></span>
                        </small>
                        <hr>
                        <div class="compra-contenedor">
                            <span class="precio"><span><?php echo number_format($precio_total, 2); ?></span>€</span>
                            <button type="button" class="btn-carrito btn-add-cart" 
                                    data-id="<?php echo $row['id_guitarra_usuario']; ?>"
                                    data-precio="<?php echo $precio_total; ?>">
                                Añadir al carrito
                            </button>
                        </div>
                    </div>
                </div>
                
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; font-family: 'Montserrat'; width: 100%; grid-column: 1 / -1;">No tienes guitarras guardadas todavía.</p>
        <?php endif; ?>
    </div>

    <script type="module" src="galeria.js"></script>
</body>
</html>