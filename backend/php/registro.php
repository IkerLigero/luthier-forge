<?php
// Carga el archivo de conexión a la base de datos (variable $conn disponible)
require "conexion.php";

// Recoger los datos enviados por el formulario de registro vía POST
$nombre    = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$email     = $_POST["email"];

// Hashear la contraseña con el algoritmo por defecto de PHP (bcrypt).
// Nunca se almacena la contraseña en texto plano.
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

/* Comprobar si el email ya está registrado en la BD.
   Se usa prepared statement para evitar inyecciones SQL. */
$sql = mysqli_prepare($conn, "SELECT * FROM usuario WHERE email = ?");
mysqli_stmt_bind_param($sql, "s", $email);  // "s" = tipo string
mysqli_stmt_execute($sql);
$resultado = mysqli_stmt_get_result($sql);

// Si ya existe al menos un usuario con ese email, redirige con aviso
if (mysqli_num_rows($resultado) > 0) {

    header("Location: ../../frontend/auth/login.html?registro=existe");
    exit();

}

/* Insertar el nuevo usuario en la tabla usuario.
   id_rol = 1 → rol de cliente por defecto.
   Se usan 4 marcadores de posición (ssss) para los campos de tipo string. */
$sql2 = mysqli_prepare($conn, "INSERT INTO usuario (nombre, apellidos, email, contrasenia_hash, id_rol) VALUES (?, ?, ?, ?, 1)");
mysqli_stmt_bind_param($sql2, "ssss", $nombre, $apellidos, $email, $password);
$correcto = mysqli_stmt_execute($sql2);

// Redirige según el resultado de la inserción
if ($correcto) {

    // Registro exitoso: lleva al login con mensaje de confirmación
    header("Location: ../../frontend/auth/login.html?registro=ok");
    exit();

} else {

    // Error inesperado en la BD: lleva al login con mensaje de error genérico
    header("Location: ../../frontend/auth/login.html?registro=error");
    exit();

}
?>