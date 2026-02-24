<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}
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

Tipo de pieza:
<select name="tipo" id="tipo" onchange="cambiarFormulario()">
    <option value="forma">Forma</option>
    <option value="mastil">Mastil</option>
    <option value="pastilla">Pastilla</option>
    <option value="guitarra_forma">Guitarra Forma</option>
</select>

<br><br>

Nombre: <input type="text" name="nombre"><br><br>
Descripcion: <input type="text" name="descripcion"><br><br>
Precio: <input type="number" step="0.01" name="precio"><br><br>
Stock: <input type="number" name="stock"><br><br>

<!-- CAMPOS FORMA -->
<div id="campos_forma">
    Material/Color: <input type="text" name="color_nombre"><br><br>
    Código HEX: <input type="text" name="codigo_hex" placeholder="#FFFFFF"><br><br>
</div>

<!-- CAMPOS MASTIL -->
<div id="campos_mastil">
    Calidad: <input type="text" name="calidad"><br><br>
    Forma clavijero: <input type="text" name="forma_clavijero"><br><br>
</div>

<!-- CAMPOS PASTILLA -->
<div id="campos_pastilla">
    ID Forma: <input type="number" name="id_forma"><br><br>
    Tipo:
    <select name="tipo_pastilla">
        <option value="humbucker">Humbucker</option>
        <option value="singlecoil">Singlecoil</option>
    </select>
    <br><br>
</div>

<!-- CAMPOS GUITARRA FORMA -->
<div id="campos_guitarra">
    ID Forma: <input type="number" name="id_forma"><br><br>
    ID Mastil: <input type="number" name="id_mastil"><br><br>
    ID Pastilla: <input type="number" name="id_pastilla"><br><br>
</div>

Imagen: <input type="file" name="imagen"><br><br>
Archivo GLB: <input type="file" name="glb"><br><br>

<button type="submit">Subir</button>

</form>

<script>
function cambiarFormulario() {
    var tipo = document.getElementById("tipo").value;

    document.getElementById("campos_forma").style.display = "none";
    document.getElementById("campos_mastil").style.display = "none";
    document.getElementById("campos_pastilla").style.display = "none";
    document.getElementById("campos_guitarra").style.display = "none";

    if (tipo === "forma") {
        document.getElementById("campos_forma").style.display = "block";
    }
    else if (tipo === "mastil") {
        document.getElementById("campos_mastil").style.display = "block";
    }
    else if (tipo === "pastilla") {
        document.getElementById("campos_pastilla").style.display = "block";
    }
    else if (tipo === "guitarra_forma") {
        document.getElementById("campos_guitarra").style.display = "block";
    }
}

cambiarFormulario();
</script>

</body>
</html>