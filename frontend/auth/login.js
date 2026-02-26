// Cuando cargue la página
window.onload = inicio;

function inicio(){

    // Pintar login por defecto
    pintarLogin();

    // Evento botón login
    $("#btnLogin").click(function(){

        // Activar botón login
        $("#btnLogin").addClass("activo");
        $("#btnRegistro").removeClass("activo");

        pintarLogin();
    });

    // Evento botón registro
    $("#btnRegistro").click(function(){

        // Activar botón registro
        $("#btnRegistro").addClass("activo");
        $("#btnLogin").removeClass("activo");

        pintarRegistro();
    });

}


// Función que pinta el formulario de login
function pintarLogin(){

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
function pintarRegistro(){

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