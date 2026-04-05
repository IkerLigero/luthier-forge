// Arranca la carga del historial cuando la página termina de renderizar.
window.onload = inicio;

function inicio() {

    // Pide al backend todas las compras guardadas del usuario autenticado.
    $.ajax({
        url: "../../backend/php/historial.php",
        method: "GET",
        success: function(res) {

            // Convierte la respuesta JSON en un array de compras utilizable en cliente.
            var datos = JSON.parse(res);
            var contenedor = document.getElementById("historial");

            // Limpia el contenedor antes de repintar el historial completo.
            contenedor.innerHTML = "";

            // Recorre cada compra para construir su tarjeta visual en el DOM.
            for (let i = 0; i < datos.length; i++) {

                var compra = datos[i];

                // contenedor principal
                var div = document.createElement("div");
                div.className = "item";

                // texto izquierda
                var texto = document.createElement("div");
                texto.className = "texto";
                texto.innerHTML = "Compra #" + compra.id_compra + "<br>" + compra.fecha;

                // precio derecha
                var precio = document.createElement("div");
                precio.className = "precio";
                precio.innerHTML = compra.total + "€";

                // botón eliminar
                var boton = document.createElement("button");
                boton.innerHTML = "❌";
                boton.className = "btnEliminar";

                // Permite eliminar una compra concreta y refrescar la vista al terminar.
                boton.onclick = function() {

                    $.ajax({
                        url: "../../backend/php/eliminar_compra.php",
                        method: "POST",
                        data: { id_compra: compra.id_compra },
                        success: function() {
                            location.reload(); // recarga fácil
                        }
                    });

                };

                // Monta la tarjeta final añadiendo texto, precio y botón de borrado.
                div.appendChild(texto);
                div.appendChild(precio);
                div.appendChild(boton);

                contenedor.appendChild(div);
            }
        }
    });
}
