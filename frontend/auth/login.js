// Cuando cargue la página
// Cuando cargue la página, se inicializa toda la interfaz de acceso.
window.onload = inicio;

function inicio() {

    // Comprueba si la URL trae mensajes del backend para enseñarlos al usuario.
    mostrarErrores();

    // Muestra primero el modo login para que sea la accion principal de entrada.
    pintarLogin();

    // Evento botón login
    // Activa visualmente la pestaña de login y dibuja su formulario.
    $("#btnLogin").click(function () {

        $("#btnLogin").addClass("activo");
        $("#btnRegistro").removeClass("activo");

        pintarLogin();
    });

    // Evento botón registro
    // Activa visualmente la pestaña de registro y dibuja su formulario.
    $("#btnRegistro").click(function () {

        $("#btnRegistro").addClass("activo");
        $("#btnLogin").removeClass("activo");
        pintarRegistro();
    });

}


// MOSTRAR ERRORES CON NOTYF
function mostrarErrores() {

    // Obtiene tanto errores de login como estados de registro tras una redirección.
    const params = new URLSearchParams(window.location.search);
    const error = params.get("error");
    const registro = params.get("registro");

    // Si no hay nada que comunicar, se sale sin crear notificaciones.
    if (!error && !registro) return;

    // Configuración común de los mensajes flotantes.
    const notyf = new Notyf({
        duration: 4000,
        position: { x: 'right', y: 'top' }
    });

    // Error de autenticacion cuando el email no existe en base de datos.
    if (error === "usuario") {
        notyf.error("Usuario no encontrado");
    }

    // Error de autenticacion cuando la contrasena no coincide.
    if (error === "password") {
        notyf.error("Contraseña incorrecta");
    }

    // Estados posibles que devuelve el flujo de registro.
    if (registro === "ok") {
        notyf.success("Usuario registrado correctamente");
    }

    if (registro === "existe") {
        notyf.error("Este email ya está registrado");
    }

    if (registro === "error") {
        notyf.error("Error al registrar usuario");
    }

    // Elimina los parámetros de la URL para que el aviso no se repita al recargar.
    window.history.replaceState({}, document.title, window.location.pathname);
}


// Función que pinta el formulario de login
function pintarLogin() {

    // Apunta el envío al script que valida el acceso.
    $("#formulario").attr("action", "../../backend/php/login.php");
    $("#formulario").attr("method", "POST");

    // Limpia el formulario anterior antes de insertar los campos nuevos.
    $("#formulario").html("");

    // Campo donde el usuario introduce su correo.
    $("#formulario").append(
        '<input type="email" name="email" placeholder="Email" class="input" required>'
    );

    $("#formulario").append(
        '<input type="password" name="password" placeholder="Contraseña" class="input" required>'
    );

    $("#formulario").append(
        '<button type="submit" class="btnPrincipal">Iniciar sesión</button>'
    );
}


// Función que pinta el formulario de registro
function pintarRegistro() {

    // Cambia la accion para que el formulario se procese como alta de usuario.
    $("#formulario").attr("action", "../../backend/php/registro.php");
    $("#formulario").attr("method", "POST");

    // Borra los campos del modo anterior antes de reconstruir el formulario.
    $("#formulario").html("");

    // Campos minimos para crear una cuenta nueva.
    $("#formulario").append(
        '<input type="text" name="nombre" placeholder="Nombre" class="input" required>'
    );

    $("#formulario").append(
        '<input type="text" name="apellidos" placeholder="Apellidos" class="input" required>'
    );

    $("#formulario").append(
        '<input type="email" name="email" placeholder="Email" class="input" required>'
    );

    $("#formulario").append(
        '<input type="password" name="password" placeholder="Contraseña" class="input" required>'
    );

    // Boton que envia el formulario de registro al backend.
    $("#formulario").append(
        '<button type="submit" class="btnPrincipal">Registrarse</button>'
    );
}
