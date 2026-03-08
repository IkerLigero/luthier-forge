// Cuando cargue la página
window.onload = inicio;

function inicio() {

    mostrarErrores();

    // Pintar login por defecto
    pintarLogin();

    // Evento botón login
    $("#btnLogin").click(function () {

        $("#btnLogin").addClass("activo");
        $("#btnRegistro").removeClass("activo");

        pintarLogin();
    });

    // Evento botón registro
    $("#btnRegistro").click(function () {

        $("#btnRegistro").addClass("activo");
        $("#btnLogin").removeClass("activo");
        pintarRegistro();
    });

}


// MOSTRAR ERRORES CON NOTYF
function mostrarErrores() {

    const params = new URLSearchParams(window.location.search);
    const error = params.get("error");
    const registro = params.get("registro");

    if (!error && !registro) return;

    const notyf = new Notyf({
        duration: 4000,
        position: { x: 'right', y: 'top' }
    });

    if (error === "usuario") {
        notyf.error("Usuario no encontrado");
    }

    if (error === "password") {
        notyf.error("Contraseña incorrecta");
    }

    if (registro === "ok") {
        notyf.success("Usuario registrado correctamente");
    }

    if (registro === "existe") {
        notyf.error("Este email ya está registrado");
    }

    if (registro === "error") {
        notyf.error("Error al registrar usuario");
    }

    window.history.replaceState({}, document.title, window.location.pathname);
}


// Función que pinta el formulario de login
function pintarLogin() {

    $("#formulario").attr("action", "../../backend/php/login.php");
    $("#formulario").attr("method", "POST");

    $("#formulario").html("");

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

    $("#formulario").attr("action", "../../backend/php/registro.php");
    $("#formulario").attr("method", "POST");

    $("#formulario").html("");

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

    $("#formulario").append(
        '<button type="submit" class="btnPrincipal">Registrarse</button>'
    );
}