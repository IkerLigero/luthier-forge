<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_compra = $_POST['id_compra'];

// borrar detalles primero
$sql1 = "DELETE FROM historial_detalle WHERE id_compra = $id_compra";
mysqli_query($conn, $sql1);

// borrar compra
$sql2 = "DELETE FROM historial_compra WHERE id_compra = $id_compra";
mysqli_query($conn, $sql2);

echo "ok";
?>