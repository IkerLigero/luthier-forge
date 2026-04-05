<?php
// Restringe el acceso a usuarios con sesión activa antes de modificar el carrito.
require "comprobar_sesion.php";
// Carga la conexión a la base de datos para ejecutar el borrado.
require "conexion.php";

// Recibe desde el frontend el identificador del detalle del carrito que se quiere eliminar.
$id_detalle = $_POST['id_detalle'];

// Elimina de carrito_detalle el producto concreto seleccionado por el usuario.
$sql = "DELETE FROM carrito_detalle WHERE id_detalle = $id_detalle";
mysqli_query($conn, $sql);

// Devuelve una respuesta mínima para que el JavaScript sepa que la operación terminó.
echo "ok";
?>