<?php
// Carga la conexión para actualizar el estado de la solicitud seleccionada.
require "conexion.php";

// Obtiene el identificador recibido por URL desde la lista de solicitudes.
$id = $_GET["id"];

// Marca la solicitud como rechazada para que deje de aparecer como pendiente.
$sql = "UPDATE solicitudes_distribuidor SET estado='rechazada' WHERE id_solicitud=$id";

mysqli_query($conn,$sql);

// Devuelve al panel de revisión una vez aplicada la actualización.
header("Location: ver_solicitudes.php");
?>
