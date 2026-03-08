<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

/* Buscar el carrito del usuario */
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
$res_carrito = mysqli_query($conn, $sql_carrito);

if (!$res_carrito || mysqli_num_rows($res_carrito) == 0) {
    echo "No existe carrito para este usuario";
    exit;
}

$fila_carrito = mysqli_fetch_assoc($res_carrito);
$id_carrito = $fila_carrito["id_carrito"];

/* Calcular total solo de ese carrito */
$sql_total = "SELECT COALESCE(SUM(precio), 0) as total
              FROM carrito_detalle
              WHERE id_carrito = $id_carrito";

$res_total = mysqli_query($conn, $sql_total);

if (!$res_total) {
    echo "Error al calcular el total";
    exit;
}

$fila_total = mysqli_fetch_assoc($res_total);
$total = $fila_total["total"];

if ($total <= 0) {
    echo "El carrito está vacío";
    exit;
}

/* Guardar compra */
$sql_compra = "INSERT INTO historial_compra(id_usuario, total)
               VALUES($id_usuario, $total)";

if (!mysqli_query($conn, $sql_compra)) {
    echo "Error al guardar la compra";
    exit;
}

$id_compra = mysqli_insert_id($conn);

/* Guardar detalles solo de ese carrito */
$sql_detalles = "INSERT INTO historial_detalle(id_compra, id_guitarra_usuario, precio)
                 SELECT $id_compra, id_guitarra_usuario, precio
                 FROM carrito_detalle
                 WHERE id_carrito = $id_carrito";

if (!mysqli_query($conn, $sql_detalles)) {
    echo "Error al guardar los detalles";
    exit;
}

/* Vaciar solo ese carrito */
$sql_borrar = "DELETE FROM carrito_detalle WHERE id_carrito = $id_carrito";

if (!mysqli_query($conn, $sql_borrar)) {
    echo "Error al vaciar el carrito";
    exit;
}

echo "<h2>Compra realizada correctamente</h2>";
echo "<p><a href='../../frontend/carrito/historial.html'>Ver historial</a></p>";
?>