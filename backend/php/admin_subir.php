<?php
require "comprobar_admin.php";
require "conexion.php";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subir pieza</title>
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

</body>
</html>