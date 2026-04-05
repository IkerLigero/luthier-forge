<?php

// Abre la conexión principal con la base de datos MySQL del proyecto.
$conn = mysqli_connect("localhost", "root", "", "luthier_forge");

// Si la conexión falla, se detiene el script para evitar consultas inválidas.
if (!$conn) {
    die("Error de conexión");
}
?>
