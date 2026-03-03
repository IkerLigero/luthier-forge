<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$tipo = $_POST["tipo"];
$archivo = $_FILES["glb"]["name"];

$ruta = "../ASSETS_GUITARRA_GLB/" . $archivo;

move_uploaded_file($_FILES["glb"]["tmp_name"], $ruta);

echo "Archivo subido correctamente para: " . $tipo;
?>