<?php
session_start();
require "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];
$id_rol = $_SESSION["rol"];

if ($id_rol == 2) {
    // admin entra siempre
}

elseif ($id_rol == 3) {

    $sql = "SELECT estado 
            FROM solicitudes_distribuidor 
            WHERE id_usuario = $id_usuario 
            AND estado = 'aceptada'";

    $resultado = mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) == 0){
        echo "No tienes permiso para subir modelos.";
        exit;
    }

}

else {
    echo "No tienes acceso a esta página";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Subir pieza</title>
<link rel="stylesheet" href="php_css/admins_subir.css">

<!-- NOTYF -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body>

<h2>Subir pieza</h2>

<form action="procesar_pieza.php" method="POST" enctype="multipart/form-data">

Tipo:
<select name="tipo" id="tipo" onchange="cambiarFormulario()">
<option value="forma_base">Forma Base</option>
<option value="forma_color">Forma + Color</option>
<option value="pastilla_modelo">Pastilla Modelo</option>
<option value="mastil">Mástil</option>
</select>

<br><br>

<div id="campos"></div>

<button type="submit">Guardar</button>

<a href="eleccion_admin.php">
    <button type="button">Volver</button>
</a>
</form>

<script>
function cambiarFormulario() {
    
    let tipo = document.getElementById("tipo").value;
    let cont = document.getElementById("campos");

    cont.innerHTML = "";

    if(tipo === "forma_base"){

        cont.innerHTML += 'Nombre: <input type="text" name="nombre"><br><br>';
        cont.innerHTML += 'Imagen: <input type="file" name="imagen"><br><br>';

    }

    if(tipo === "forma_color"){

        cont.innerHTML += 'ID Forma Base: <input type="number" name="id_forma_base"><br><br>';
        cont.innerHTML += 'Color: <input type="text" name="color"><br><br>';
        cont.innerHTML += 'Descripcion: <input type="text" name="descripcion"><br><br>';
        cont.innerHTML += 'Precio: <input type="number" step="0.01" name="precio"><br><br>';
        cont.innerHTML += 'Unidades: <input type="number" name="unidades"><br><br>';
        cont.innerHTML += 'GLB Base: <input type="file" name="glb"><br><br>';

    }

    if(tipo === "pastilla_modelo"){

        cont.innerHTML += 'ID Forma Base: <input type="number" name="id_forma_base"><br><br>';
        cont.innerHTML += 'Tipo: <select name="tipo_pastilla"><option value="humbucker">Humbucker</option><option value="singlecoil">Singlecoil</option></select><br><br>';
        cont.innerHTML += 'GLB Pastilla: <input type="file" name="glb"><br><br>';

    }

    if(tipo === "mastil"){

        cont.innerHTML += 'Nombre: <input type="text" name="nombre"><br><br>';
        cont.innerHTML += 'Descripcion: <input type="text" name="descripcion"><br><br>';
        cont.innerHTML += 'Precio: <input type="number" step="0.01" name="precio"><br><br>';
        cont.innerHTML += 'Forma clavijero: <input type="text" name="forma_clavijero"><br><br>';
        cont.innerHTML += 'Stock: <input type="number" name="stock"><br><br>';
        cont.innerHTML += 'Imagen: <input type="file" name="imagen"><br><br>';
        cont.innerHTML += 'GLB: <input type="file" name="glb"><br><br>';

    }

}

cambiarFormulario();
</script>


<!-- NOTYF JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>

const params = new URLSearchParams(window.location.search);
const pieza = params.get("pieza");

if(pieza){

    const notyf = new Notyf({
        duration:4000,
        position:{x:'right',y:'top'}
    });

    if(pieza === "ok"){
        notyf.success("Pieza subida correctamente");
    }

    if(pieza === "error"){
        notyf.error("Error al subir la pieza");
    }

    window.history.replaceState({}, document.title, window.location.pathname);
}

</script>

</body>
</html>