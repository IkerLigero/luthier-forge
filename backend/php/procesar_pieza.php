<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "luthier_forge");
if ($conn->connect_error) {
    die("Error conexión BD");
}

$tipo = $_POST["tipo"] ?? "";

$nombre = $_POST["nombre"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";
$precio = $_POST["precio"] ?? 0;
$stock = $_POST["stock"] ?? 0;

$calidad = $_POST["calidad"] ?? "";
$forma_clavijero = $_POST["forma_clavijero"] ?? "";

$id_forma = $_POST["id_forma"] ?? null;
$tipo_pastilla = $_POST["tipo_pastilla"] ?? null;

$color_nombre = $_POST["color_nombre"] ?? null;
$codigo_hex = $_POST["codigo_hex"] ?? null;

/* ---------- SUBIR IMAGEN ---------- */
$imagen_nombre = $_FILES["imagen"]["name"] ?? "";
$ruta_imagen = null;

if ($imagen_nombre != "") {
    $ruta_imagen = "imagenes_asociadas/" . $imagen_nombre;
    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../" . $ruta_imagen);
}

/* ---------- SUBIR GLB ---------- */
$glb_nombre = $_FILES["glb"]["name"] ?? "";
$ruta_glb = null;

if ($glb_nombre != "") {
    $ruta_glb = "Modelos/" . $glb_nombre;
    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../" . $ruta_glb);
}

/* ---------- INSERT SEGÚN TIPO ---------- */

if ($tipo == "forma") {

    $sql = "INSERT INTO forma
    (nombre, descripcion, color_nombre, codigo_hex, imagen, referencia_glb, precio_base, stock)
    VALUES
    ('$nombre', '$descripcion', '$color_nombre', '$codigo_hex', '$ruta_imagen', '$ruta_glb', $precio, $stock)";

}

elseif ($tipo == "mastil") {

    $sql = "INSERT INTO mastil
    (nombre, descripcion, imagen, referencia_glb, precio, calidad, forma_clavijero, stock)
    VALUES
    ('$nombre', '$descripcion', '$ruta_imagen', '$ruta_glb', $precio, '$calidad', '$forma_clavijero', $stock)";

}

elseif ($tipo == "pastilla") {

    $sql = "INSERT INTO pastilla
    (nombre, descripcion, id_forma, tipo, imagen, referencia_glb, precio, calidad, stock)
    VALUES
    ('$nombre', '$descripcion', $id_forma, '$tipo_pastilla', '$ruta_imagen', '$ruta_glb', $precio, '$calidad', $stock)";

}

elseif ($tipo == "guitarra_forma") {

    $id_mastil = $_POST["id_mastil"] ?? null;
    $id_pastilla2 = $_POST["id_pastilla"] ?? null;

    $sql = "INSERT INTO guitarra_forma
    (id_forma, id_mastil, id_pastilla, precio_total, stock)
    VALUES
    ($id_forma, $id_mastil, $id_pastilla2, $precio, $stock)";

}

else {
    die("Tipo inválido");
}

$conn->query($sql);

echo "Pieza subida correctamente";
?>