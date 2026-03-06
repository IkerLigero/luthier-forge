<?php
session_start();
require "conexion.php";

$id = $_GET["id"];

$sql = "UPDATE solicitudes_distribuidor 
        SET estado='aceptada' 
        WHERE id_solicitud=$id";

mysqli_query($conn, $sql);

header("Location: ver_solicitudes.php");
exit();
?>