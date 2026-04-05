<?php
// Protege el endpoint y carga la conexión para consultar compras del usuario actual.
require "comprobar_sesion.php";
require "conexion.php";

// Toma el id del usuario autenticado para filtrar su historial.
$id_usuario = $_SESSION['id_usuario'];

// Obtiene las compras ordenadas de la más reciente a la más antigua.
$sql = "SELECT id_compra, total, fecha
        FROM historial_compra
        WHERE id_usuario = $id_usuario
        ORDER BY fecha DESC";

$res = mysqli_query($conn, $sql);

// Acumula los resultados para devolverlos como JSON al frontend.
$datos = [];

while($fila = mysqli_fetch_assoc($res)){
    $datos[] = $fila;
}

// Envía el historial completo en formato JSON.
echo json_encode($datos);
?>
