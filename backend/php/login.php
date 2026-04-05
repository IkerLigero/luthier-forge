<?php
// Inicia la sesión PHP para poder almacenar variables de sesión del usuario
session_start();
// Carga el archivo de conexión a la base de datos (variable $conn disponible)
require "conexion.php";

/* Evita acceso directo a login.php sin enviar el formulario:
   si no llegan los campos email y password por POST, redirige al login */
if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    header("Location: ../../frontend/auth/login.html");
    exit();
}

/* Recoger y sanear los datos enviados por el formulario de login */
$email    = $_POST["email"];
$password = $_POST["password"];

/* Buscar el usuario en la BD usando prepared statement para evitar inyecciones SQL.
   Solo se filtra por email; la contraseña se valida después con password_verify(). */
$sql = mysqli_prepare($conn, "SELECT * FROM usuario WHERE email = ?");
mysqli_stmt_bind_param($sql, "s", $email);   // "s" = tipo string
mysqli_stmt_execute($sql);
$resultado = mysqli_stmt_get_result($sql);

// Comprueba que exactamente un usuario coincide con ese email
if (mysqli_num_rows($resultado) == 1) {

    $fila = mysqli_fetch_assoc($resultado);

    /* Verificar la contraseña comparando el texto plano recibido con el hash
       almacenado en BD (generado originalmente con password_hash()) */
    if (password_verify($password, $fila["contrasenia_hash"])) {

        // Credenciales correctas: guardar datos del usuario en la sesión
        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["nombre"]     = $fila["nombre"];
        $_SESSION["rol"]        = $fila["id_rol"];

        /* ADMIN (id_rol = 2): redirige al panel de elección de área de administración */
        if ($fila["id_rol"] == 2) {

            header("Location: eleccion_admin.php");
            exit();

        }

        /* DISTRIBUIDOR (id_rol = 3): redirige al panel propio del distribuidor */
        elseif ($fila["id_rol"] == 3) {

            header("Location: distribuidor_inicio.php");
            exit();

        }

        /* CLIENTE (cualquier otro rol): redirige a la página principal de la tienda */
        else {

            header("Location: ../../frontend/index.html");
            exit();

        }

    } else {

        // Contraseña incorrecta: vuelve al login con parámetro de error para mostrar mensaje
        header("Location: ../../frontend/auth/login.html?error=password");
        exit();

    }

} else {

    // Email no encontrado en BD: vuelve al login indicando que el usuario no existe
    header("Location: ../../frontend/auth/login.html?error=usuario");
    exit();

}
?>