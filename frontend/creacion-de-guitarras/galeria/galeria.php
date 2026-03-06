<?php
// 1. Aseguramos las rutas de los archivos del backend (3 niveles hacia atrás)
require_once "../../../backend/php/comprobar_sesion.php";
require_once "../../../backend/php/conexion.php"; 

// 2. Usamos el ID de la sesión
$id_user = $_SESSION['id_usuario'];

// 3. Consulta SQL (Asegúrate de que la variable en conexion.php es $conn)
// Unimos las tablas para sacar las rutas de los archivos 3D (GLB)
$sql = "SELECT gu.id_guitarra_usuario, 
               fc.referencia_glb AS glb_forma, 
               m.referencia_glb AS glb_mastil, 
               pm.referencia_glb AS glb_pastillas
        FROM guitarra_usuario gu
        JOIN forma_color fc ON gu.id_forma_color = fc.id_forma_color
        JOIN mastil m ON gu.id_mastil = m.id_mastil
        JOIN pastilla_modelo pm ON gu.id_pastilla_modelo = pm.id_pastilla_modelo
        WHERE gu.id_usuario = '$id_user'";

// Cambiamos $conexion por $conn (que es la que usas en conexion.php)
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Galería - Luthier Forge</title>
    <link rel="stylesheet" href="galeria.css">
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
    <h1>Mis Guitarras Guardadas</h1>
    
    <div class="galeria-grid">
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($resultado)): ?>
            <div class="card-guitarra">
                <div class="canvas-container" 
                     data-forma="<?php echo $row['glb_forma']; ?>" 
                     data-mastil="<?php echo $row['glb_mastil']; ?>" 
                     data-pastillas="<?php echo $row['glb_pastillas']; ?>">
                </div>
                <div class="info-guitarra">
                    <span>Diseño #<?php echo $row['id_guitarra_usuario']; ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No tienes guitarras guardadas todavía.</p>
    <?php endif; ?>
</div>

    <script type="module" src="galeria.js"></script>
</body>
</html>