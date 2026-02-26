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

    // Vaciar formulario
    $("#formulario").html("");

    // Input email
    $("#formulario").append(
        '<input type="email" name="email" placeholder="Email" class="input" required>'
    );

    // Input contraseña
    $("#formulario").append(
        '<input type="password" name="password" placeholder="Contraseña" class="input" required>'
    );

    // Botón enviar
    $("#formulario").append(
        '<button type="submit" class="btnPrincipal">Iniciar sesión</button>'
    );
}


// Función que pinta el formulario de registro
function pintarRegistro(){

    // Vaciar formulario
    $("#formulario").html("");

    $("#formulario").append(
        '<input type="text" name="nombre" placeholder="Nombre" class="input" required>'
    );

    $("#formulario").append(
        '<input type="text" name="apellido" placeholder="Apellido" class="input" required>'
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