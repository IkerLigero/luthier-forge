<?php
// Verifica que hay una sesión activa (usuario logueado); si no, redirige o detiene
require "comprobar_sesion.php";
// Carga la conexión a la base de datos (variable $conn disponible)
require "conexion.php";

// Determina qué tipo de pieza se está subiendo para bifurcar la lógica correspondiente
$tipo = $_POST["tipo"];

/* ── FORMA BASE ──────────────────────────────────────────────────────────────
   Registra la silueta/cuerpo base de la guitarra.
   Solo requiere nombre e imagen representativa (JPG/PNG). */
if($tipo == "forma_base"){

    $nombre = $_POST["nombre"];
    $imagen = $_FILES["imagen"]["name"];  // Nombre original del archivo de imagen

    // Mueve la imagen subida desde el directorio temporal al destino definitivo
    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../frontend/img/".$imagen);

    // Inserta la nueva forma base; "ss" = dos strings (nombre, imagen)
    $sql = mysqli_prepare($conn, "INSERT INTO forma_base (nombre, imagen) VALUES (?, ?)");
    mysqli_stmt_bind_param($sql, "ss", $nombre, $imagen);
    $correcto = mysqli_stmt_execute($sql);

}

/* ── FORMA COLOR ─────────────────────────────────────────────────────────────
   Variante de color de una forma base existente.
   Incluye archivo GLB (modelo 3D), precio y stock de unidades. */
elseif($tipo == "forma_color"){

    $id_forma_base = $_POST["id_forma_base"];  // FK hacia forma_base
    $color         = $_POST["color"];
    $descripcion   = $_POST["descripcion"];
    $precio        = $_POST["precio"];
    $unidades      = $_POST["unidades"];
    $glb           = $_FILES["glb"]["name"];   // Nombre del modelo 3D

    // Mueve el modelo GLB al directorio de assets 3D
    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    // "isssii" = int, string, string, string, int, int
    $sql = mysqli_prepare($conn, "INSERT INTO forma_color (id_forma_base, color, descripcion, referencia_glb, precio, unidades) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($sql, "isssii", $id_forma_base, $color, $descripcion, $glb, $precio, $unidades);
    $correcto = mysqli_stmt_execute($sql);

}

/* ── PASTILLA MODELO ─────────────────────────────────────────────────────────
   Modelo de pastilla (humbucker / single-coil) asociado a una forma base.
   Solo necesita el tipo de pastilla y su modelo 3D GLB. */
elseif($tipo == "pastilla_modelo"){

    $id_forma_base  = $_POST["id_forma_base"];   // FK hacia forma_base
    $tipo_pastilla  = $_POST["tipo_pastilla"];    // Ej: "humbucker", "single-coil"
    $glb            = $_FILES["glb"]["name"];

    // Mueve el modelo GLB al directorio de assets 3D
    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    // "iss" = int, string, string
    $sql = mysqli_prepare($conn, "INSERT INTO pastilla_modelo (id_forma_base, tipo, referencia_glb) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($sql, "iss", $id_forma_base, $tipo_pastilla, $glb);
    $correcto = mysqli_stmt_execute($sql);

}

/* ── MÁSTIL ──────────────────────────────────────────────────────────────────
   Pieza de mástil con imagen de vista previa, modelo 3D GLB,
   descripción, precio, forma del clavijero y stock. */
elseif($tipo == "mastil"){

    $nombre          = $_POST["nombre"];
    $descripcion     = $_POST["descripcion"];
    $precio          = $_POST["precio"];
    $forma_clavijero = $_POST["forma_clavijero"];  // Ej: "Fender", "Gibson"
    $stock           = $_POST["stock"];
    $imagen          = $_FILES["imagen"]["name"];   // Imagen de previsualización
    $glb             = $_FILES["glb"]["name"];       // Modelo 3D

    // Mueve imagen al directorio de assets del frontend y el GLB al de modelos 3D
    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../frontend/img/".$imagen);
    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    // "ssssssi" = string×6 + int (stock al final)
    $sql = mysqli_prepare($conn, "INSERT INTO mastil (nombre, descripcion, imagen, referencia_glb, precio, forma_clavijero, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($sql, "ssssssi", $nombre, $descripcion, $imagen, $glb, $precio, $forma_clavijero, $stock);
    $correcto = mysqli_stmt_execute($sql);

}

// Redirige al panel de subida indicando si la operación fue exitosa o no
if($correcto){
    header("Location: admin_subir.php?pieza=ok");
}else{
    header("Location: admin_subir.php?pieza=error");
}

exit;
?>