<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "luthier_forge");

$tipo = $_POST["tipo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];
$calidad = $_POST["calidad"];
$material = $_POST["material"];
$id_forma = $_POST["id_forma"];
$tipo_pastilla = $_POST["tipo_pastilla"];

/* Subir imagen */
$imagen_nombre = $_FILES["imagen"]["name"];
$ruta_imagen = "Modelos/Imagenes/" . $imagen_nombre;
move_uploaded_file($_FILES["imagen"]["tmp_name"], "../" . $ruta_imagen);

/* Subir GLB */
$glb_nombre = $_FILES["glb"]["name"];
$ruta_glb = "Modelos/" . $glb_nombre;
move_uploaded_file($_FILES["glb"]["tmp_name"], "../" . $ruta_glb);

/* INSERT SEGÚN TIPO */
if ($tipo == "forma") {

    $sql = "INSERT INTO forma
    (nombre, descripcion, imagen, referencia_glb, precio_base, stock)
    VALUES
    ('$nombre', '$descripcion', '$ruta_imagen', '$ruta_glb', $precio, $stock)";

}

elseif ($tipo == "mastil") {

    $sql = "INSERT INTO mastil
    (nombre, descripcion, imagen, referencia_glb, precio, calidad, material, stock)
    VALUES
    ('$nombre', '$descripcion', '$ruta_imagen', '$ruta_glb', $precio, '$calidad', '$material', $stock)";

}

elseif ($tipo == "pastilla") {

    $sql = "INSERT INTO pastilla
    (nombre, descripcion, id_forma, tipo, imagen, referencia_glb, precio, calidad, stock)
    VALUES
    ('$nombre', '$descripcion', $id_forma, '$tipo_pastilla', '$ruta_imagen', '$ruta_glb', $precio, '$calidad', $stock)";

}

$conn->query($sql);

echo "Pieza subida correctamente";
?>