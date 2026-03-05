<?php
require "comprobar_admin.php";
require "conexion.php";

/* Seguridad básica */
if (!isset($_SESSION["id_usuario"]) || $_SESSION["id_rol"] != 2) {
    header("Location: ../../frontend/index.html");
    exit;
}

/* BORRAR USUARIO */
if (isset($_GET["borrar"])) {
    $id = $_GET["borrar"];
    mysqli_query($conn, "DELETE FROM usuario WHERE id_usuario = $id");
}

/* SACAR USUARIOS */
$sql = "SELECT usuario.id_usuario, usuario.nombre, usuario.email, rol.nombre_rol 
        FROM usuario
        INNER JOIN rol ON usuario.id_rol = rol.id_rol";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="php_css/gestionar_usuarios.css">
</head>
<body>

<div class="main">

    <h2>Gestionar Usuarios</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>

        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $fila["id_usuario"]; ?></td>
                <td><?php echo $fila["nombre"]; ?></td>
                <td><?php echo $fila["email"]; ?></td>
                <td><?php echo $fila["nombre_rol"]; ?></td>
                <td>
                    <a href="gestionar_usuarios.php?borrar=<?php echo $fila["id_usuario"]; ?>">
                        <button class="btnEliminar">Eliminar</button>
                    </a>
                </td>
            </tr>
        <?php } ?>

    </table>

    <br>

    <a href="admin_inicio.php">
        <button class="btnVolver">Volver</button>
    </a>

</div>

</body>
</html>