<?php
require_once "comprobar_sesion.php";
require_once "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

// Consulta avanzada con JOINs para traer los nombres de los componentes
$sql = "SELECT 
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
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }
}

// Devolvemos el JSON limpio
header('Content-Type: application/json');
echo json_encode($productos);
?>