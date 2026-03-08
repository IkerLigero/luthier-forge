<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT id_compra, total, fecha
        FROM historial_compra
        WHERE id_usuario = $id_usuario
        ORDER BY fecha DESC";

$res = mysqli_query($conn, $sql);

$datos = [];

while($fila = mysqli_fetch_assoc($res)){
    $datos[] = $fila;
}

echo json_encode($datos);
?>