<?php
require "comprobar_sesion.php";
require "conexion.php";

$tipo = $_POST["tipo"];

if($tipo == "forma_base"){

    $nombre = $_POST["nombre"];
    $imagen = $_FILES["imagen"]["name"];

    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../frontend/img/".$imagen);

    $sql = "INSERT INTO forma_base (nombre, imagen)
            VALUES ('$nombre', '$imagen')";
}

elseif($tipo == "forma_color"){

    $id_forma_base = $_POST["id_forma_base"];
    $color = $_POST["color"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $unidades = $_POST["unidades"];
    $glb = $_FILES["glb"]["name"];

    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    $sql = "INSERT INTO forma_color
            (id_forma_base, color, descripcion, referencia_glb, precio, unidades)
            VALUES
            ('$id_forma_base', '$color', '$descripcion', '$glb', '$precio', '$unidades')";
}

elseif($tipo == "pastilla_modelo"){

    $id_forma_base = $_POST["id_forma_base"];
    $tipo_pastilla = $_POST["tipo_pastilla"];
    $glb = $_FILES["glb"]["name"];

    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    $sql = "INSERT INTO pastilla_modelo
            (id_forma_base, tipo, referencia_glb)
            VALUES
            ('$id_forma_base', '$tipo_pastilla', '$glb')";
}

elseif($tipo == "mastil"){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $forma_clavijero = $_POST["forma_clavijero"];
    $stock = $_POST["stock"];
    $imagen = $_FILES["imagen"]["name"];
    $glb = $_FILES["glb"]["name"];

    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../../frontend/img/".$imagen);
    move_uploaded_file($_FILES["glb"]["tmp_name"], "../../Modelos/".$glb);

    $sql = "INSERT INTO mastil
            (nombre, descripcion, imagen, referencia_glb, precio, forma_clavijero, stock)
            VALUES
            ('$nombre', '$descripcion', '$imagen', '$glb', '$precio', '$forma_clavijero', '$stock')";
}

$correcto = mysqli_query($conn, $sql);

if($correcto){
    header("Location: admin_subir.php?pieza=ok");
}else{
    header("Location: admin_subir.php?pieza=error");
}

exit;
?>