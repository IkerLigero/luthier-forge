<?php
// Verifica que el usuario logueado sea administrador; si no, redirige o detiene la ejecución
require "comprobar_admin.php";
// Carga la conexión a la base de datos (variable $conn disponible)
require "conexion.php";

/* BORRAR USUARIO
   Se activa cuando la URL incluye el parámetro GET "borrar" con el id del usuario a eliminar.
   Se usa prepared statement con tipo "i" (integer) para evitar inyecciones SQL. */
if (isset($_GET["borrar"])) {

    $id = $_GET["borrar"];
    $sql = mysqli_prepare($conn, "DELETE FROM usuario WHERE id_usuario = ?");
    mysqli_stmt_bind_param($sql, "i", $id);  // "i" = tipo entero
    mysqli_stmt_execute($sql);

}

/* CAMBIAR ROL
   Se activa al enviar el formulario con el botón "guardar".
   Actualiza el rol del usuario seleccionado en la BD usando prepared statement
   con tipos "ii" (dos enteros: id_rol e id_usuario). */
if (isset($_POST["guardar"])) {

    $id_usuario = $_POST["id_usuario"];
    $rol        = $_POST["rol"];

    $sql = mysqli_prepare($conn, "UPDATE usuario SET id_rol = ? WHERE id_usuario = ?");
    mysqli_stmt_bind_param($sql, "ii", $rol, $id_usuario);  // "ii" = dos enteros
    mysqli_stmt_execute($sql);

}

/* LISTAR USUARIOS
   Obtiene todos los usuarios con su nombre de rol (JOIN con la tabla rol)
   para mostrarlos en la tabla de gestión. */
$sql = "SELECT usuario.id_usuario, usuario.nombre, usuario.email, usuario.id_rol, rol.nombre_rol
        FROM usuario
        INNER JOIN rol ON usuario.id_rol = rol.id_rol";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
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

<?php
// Itera sobre cada usuario devuelto por la consulta y genera una fila de la tabla
while($fila = mysqli_fetch_assoc($resultado)){
?>

<tr>

<td><?php echo $fila["id_usuario"]; ?></td>

<td><?php echo $fila["nombre"]; ?></td>

<td><?php echo $fila["email"]; ?></td>

<td>

<!-- Formulario individual por fila para cambiar el rol de este usuario.
     El campo oculto id_usuario identifica al usuario que se va a actualizar. -->
<form method="POST">

<input type="hidden" name="id_usuario" value="<?php echo $fila["id_usuario"]; ?>">

<!-- Desplegable con los tres roles disponibles; marca como "selected" el rol actual -->
<select name="rol">

<option value="1" <?php if($fila["id_rol"]==1) echo "selected"; ?>>cliente</option>

<option value="2" <?php if($fila["id_rol"]==2) echo "selected"; ?>>admin</option>

<option value="3" <?php if($fila["id_rol"]==3) echo "selected"; ?>>distribuidor</option>

</select>

<button type="submit" name="guardar">Guardar</button>

</form>

</td>

<td>

<!-- Enlace que pasa el id del usuario como parámetro GET "borrar" para eliminarlo -->
<a href="gestionar_usuarios.php?borrar=<?php echo $fila["id_usuario"]; ?>">
<button class="btnEliminar">Eliminar</button>
</a>

</td>

</tr>

<?php
}
?>

</table>

<br>

<a href="admin_inicio.php">
<button class="btnVolver">Volver</button>
</a>

</div>

</body>
</html>