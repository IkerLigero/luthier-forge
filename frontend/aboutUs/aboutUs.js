'use strict'

window.onload = inicio;

function inicio() {
    //dle darkmode

    const options = {
        bottom: '32px',
        right: '32px',
        time: '0.5s',
        saveInCookies: true,
        ignoreElements: ['.hero'],
        label: '🌙'
    };
    const darkmode = new Darkmode(options);
    darkmode.showWidget();//para mostrar el boton

    // Textos guardados en variables
    let textoMision = "En Luthier Forge, nuestra misión trasciende la simple fabricación de instrumentos...";
    let textoOfrecemos = "Ponemos a tu disposición una plataforma de configuración intuitiva...";
    let textoTrabajamos = "Nuestro proceso es una danza entre la herencia de los antiguos maestros luthieres...";

    // Crear los p dinamicamente y ocultarlos
    $("#mision").append("<p class='texto'>" + textoMision + "</p>");
    $("#ofrecemos").append("<p class='texto'>" + textoOfrecemos + "</p>");
    $("#trabajamos").append("<p class='texto'>" + textoTrabajamos + "</p>");

    $(".texto").hide(); //esto pa todos

    // Fade de las tarjetas
    $(".card").hide().each(function (i) {
        $(this).fadeIn(600);
    });

    // Evento botones
    $(".btnLeer").click(function () {
        // Guardamos en la variable card la tarjeta (.card) mas cercana al boton pulsado q seria el this 
        let card = $(this).closest(".card");//closest para q suba lo necesario (sujeto a cambios), con parent solo subiria un nuvel closest es mas seguro
        card.find(".texto").toggle(); //buscamos texto y mostramos o ocultamos

        if ($(this).text() == "Ver texto") {//si el texto es que se pueda ver pues se oculta y viceversa
            $(this).text("Ocultar texto");
        } else {
            $(this).text("Ver texto");
        }

    });
}