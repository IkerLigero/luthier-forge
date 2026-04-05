<?php
// Comprueba que el usuario haya iniciado sesión.
require_once "comprobar_sesion.php";
// Abre la conexión con la base de datos.
require_once "conexion.php";

// Comprueba que hayan llegado los datos necesarios desde el formulario o fetch.
if (!isset($_POST['id_guitarra']) || !isset($_POST['precio'])) {
    http_response_code(400);
    exit("Faltan parámetros");
}

// Guarda los datos que se van a usar para añadir la guitarra al carrito.
$id_usuario = $_SESSION['id_usuario'];
$id_guitarra = $_POST['id_guitarra'];
$precio = $_POST['precio'];

/* Buscar si el usuario ya tiene un carrito.
   Si no lo tiene, se crea uno nuevo. */
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = '$id_usuario'";
$res_carrito = mysqli_query($conn, $sql_carrito);

if (mysqli_num_rows($res_carrito) == 0) {
    // Crear carrito nuevo para este usuario.
    mysqli_query($conn, "INSERT INTO carrito (id_usuario) VALUES ('$id_usuario')");
    $id_carrito = mysqli_insert_id($conn);
} else {
    // Usar el carrito que ya existe.
    $fila = mysqli_fetch_assoc($res_carrito);
    $id_carrito = $fila['id_carrito'];
}

/* Guardar la guitarra dentro del carrito.
   Se inserta una fila en carrito_detalle con el carrito, la guitarra y su precio. */
$sql_detalle = "INSERT INTO carrito_detalle (id_carrito, id_guitarra_usuario, precio) 
                VALUES ('$id_carrito', '$id_guitarra', '$precio')";

if (mysqli_query($conn, $sql_detalle)) {
    // Todo fue bien.
    echo "success";
} else {
    // Devuelve error si la consulta falla.
    http_response_code(500);
    echo "Error SQL: " . mysqli_error($conn);
}
?>