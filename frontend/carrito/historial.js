window.onload = inicio;

function inicio() {

    $.ajax({
        url: "../../backend/php/historial.php",
        method: "GET",
        success: function(res) {

            var datos = JSON.parse(res);
            var contenedor = document.getElementById("historial");

            contenedor.innerHTML = "";

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

                // meter todo
                div.appendChild(texto);
                div.appendChild(precio);
                div.appendChild(boton);

                contenedor.appendChild(div);
            }
        }
    });
}