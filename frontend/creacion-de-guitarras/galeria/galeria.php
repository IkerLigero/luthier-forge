<?php
require_once "../../../backend/php/comprobar_sesion.php";
require_once "../../../backend/php/conexion.php";

$id_user = $_SESSION['id_usuario'];

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

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Galería - Luthier Forge</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
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

    <div class="galeria-grid">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <?php $precio_total = $row['precio_forma'] + $row['precio_mastil']; ?>
                <div class="card-guitarra">
                    <div class="canvas-container" data-forma="<?php echo $row['glb_forma']; ?>"
                        data-mastil="<?php echo $row['glb_mastil']; ?>" data-pastillas="<?php echo $row['glb_pastillas']; ?>">
                    </div>
                    <div class="info-guitarra">
                        <p><strong>Componentes:</strong></p>
                        <small>
                            Cuerpo: <?php echo $row['nombre_forma']; ?><br>
                            Mástil: <?php echo $row['nombre_mastil']; ?><br>
                            Pastillas: <?php echo ucfirst($row['nombre_pastillas']); ?>
                        </small>
                        <hr>
                        <div class="compra-contenedor">
                            <span class="precio"><?php echo number_format($precio_total, 2); ?>€</span>
                            <button class="btn-carrito" data-id="<?php echo $row['id_guitarra_usuario']; ?>"
                                data-precio="<?php echo $precio_total; ?>">
                                Añadir al carrito
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; font-family: 'Montserrat'; width: 100%; grid-column: 1 / -1;">No tienes guitarras
                guardadas todavía.</p>
        <?php endif; ?>
    </div>

    <script type="module" src="galeria.js"></script>
</body>

</html>