<?php
// Comprueba que el usuario haya iniciado sesión.
require_once "comprobar_sesion.php";
// Abre la conexión con la base de datos.
require_once "conexion.php";

// Coge el id del usuario logueado para cargar solo su carrito.
$id_usuario = $_SESSION['id_usuario'];

/* Busca los productos que hay en el carrito del usuario.
    Se usan JOINs para traer también los nombres de las piezas
    y no solo los ids guardados en la base de datos. */
$sql = "SELECT 
            cd.id_detalle,
            gu.id_guitarra_usuario, 
            cd.precio,
            fc.descripcion AS nombre_cuerpo,
            m.nombre AS nombre_mastil,
            pm.tipo AS nombre_pastillas
        FROM carrito_detalle cd
        JOIN carrito c ON cd.id_carrito = c.id_carrito
        JOIN guitarra_usuario gu ON cd.id_guitarra_usuario = gu.id_guitarra_usuario
        JOIN forma_color fc ON gu.id_forma_color = fc.id_forma_color
        JOIN mastil m ON gu.id_mastil = m.id_mastil
        JOIN pastilla_modelo pm ON gu.id_pastilla_modelo = pm.id_pastilla_modelo
        WHERE c.id_usuario = '$id_usuario'";

$resultado = mysqli_query($conn, $sql);
$productos = [];

if ($resultado) {
    // Guarda cada fila en un array para devolverlo al frontend.
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }
}

// Devuelve la respuesta en formato JSON para que la lea JavaScript.
header('Content-Type: application/json');
echo json_encode($productos);
?>