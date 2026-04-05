// Inicia la lógica del carrito cuando la página ya está cargada en el navegador.
window.onload = inicio;

function inicio(){
    // Al entrar en la vista, recupera el contenido actual del carrito del usuario.
    cargarCarrito();
    // Enlaza el botón de compra con la redirección hacia la pasarela de pago.
    $("#comprar").click(comprar);
}

// Consulta al backend y reconstruye visualmente el estado completo del carrito.
function cargarCarrito(){
    // Pide al backend los productos guardados en el carrito de la sesión activa.
    $.ajax({
        url: "../../backend/php/cargar_carrito.php",
        success: function(res){
            // Normaliza la respuesta por si llega como texto JSON o como objeto ya parseado.
            let datos = (typeof res === 'string') ? JSON.parse(res) : res;
            
            // Limpia el listado antes de volver a pintarlo con los datos actuales.
            $("#productos").html("");
            let total = 0;

            // Si no hay artículos, muestra un mensaje de carrito vacío en la propia vista.
            if(datos.length === 0) {
                $("#productos").html("<p style='text-align:center; padding: 20px;'>Tu carrito está vacío.</p>");
            }

            // Recorre cada guitarra guardada para pintarla y sumar su precio.
            datos.forEach(item => {

                // Usa nombres por defecto para evitar huecos si alguna pieza no viene informada.
                let cuerpo = item.nombre_cuerpo || "Cuerpo estándar";
                let mastil = item.nombre_mastil || "Mástil estándar";
                let pastillas = item.nombre_pastillas || "Pastillas base";

                // Genera una tarjeta visual por cada guitarra personalizada añadida al carrito.
                // Inserta en el DOM una tarjeta resumida con nombre, precio y boton de borrado.
                $("#productos").append(`
                    <div class="producto-card">
                        <div class="producto-info">
                            <strong>Guitarra #${item.id_guitarra_usuario}</strong>
                            <span class="detalles">
                                ${cuerpo} • ${mastil} • ${pastillas}
                            </span>
                        </div>
                        <div class="producto-precio">
                            ${parseFloat(item.precio).toFixed(2)}€
                        </div>
                        <button class="btnEliminar" onclick="eliminarItem(${item.id_detalle})">❌</button>
                    </div>
                `);

                // Acumula el precio de cada item para mostrar el total final al usuario.
                total += parseFloat(item.precio);
            });

            // Actualiza el importe total en la interfaz con dos decimales.
            $("#total").text(total.toFixed(2));
        },
        error: function() {
            // Deja constancia en consola si falla la petición al backend.
            console.error("Error al cargar el carrito");
        }
    });
}

function eliminarItem(id_detalle){
    // Solicita al backend la eliminación de un producto concreto del carrito.
    $.ajax({
        url: "../../backend/php/eliminar_item_carrito.php",
        method: "POST",
        data: { id_detalle: id_detalle },
        success: function(){
            // Vuelve a cargar el carrito para refrescar la lista y el total tras borrar el item.
            cargarCarrito();
        }
    });
}

// Redirige al flujo de compra sin recalcular nada en cliente.
function comprar(){
    // Envía al usuario al flujo PHP que calcula el total y monta el pago con PayPal.
    window.location.href = "../../backend/php/comprar.php";
}
