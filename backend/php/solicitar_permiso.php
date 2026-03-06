<?php
session_start();
require "conexion.php";

$id_usuario = $_SESSION["id_usuario"];

$sql = "INSERT INTO solicitudes_distribuidor (id_usuario) VALUES ($id_usuario)";

mysqli_query($conn, $sql);

echo "Solicitud enviada al administrador";
?>