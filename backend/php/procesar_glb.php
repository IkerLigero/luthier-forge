<?php
// Verifica que exista una sesión activa antes de procesar la subida del archivo.
require "comprobar_sesion.php";
// Inicia la sesión para consultar las variables del usuario autenticado.
session_start();

// Este flujo solo admite usuarios marcados como administradores.
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// Identifica el tipo de pieza y el nombre del archivo GLB enviado desde el formulario.
$tipo = $_POST["tipo"];
$archivo = $_FILES["glb"]["name"];

// Construye la ruta final donde se guardará el modelo 3D subido.
$ruta = "../ASSETS_GUITARRA_GLB/" . $archivo;

move_uploaded_file($_FILES["glb"]["tmp_name"], $ruta);

// Devuelve un mensaje simple de confirmación tras completar la subida.
echo "Archivo subido correctamente para: " . $tipo;
?>
