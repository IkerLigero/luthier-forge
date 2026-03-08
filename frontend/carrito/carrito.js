window.onload = inicio;

function inicio(){
    cargarCarrito();
    $("#comprar").click(comprar);
}

function cargarCarrito(){
    $.ajax({
        url: "../../backend/php/cargar_carrito.php",
        success: function(res){
            let datos = (typeof res === 'string') ? JSON.parse(res) : res;
            
            $("#productos").html("");
            let total = 0;

            if(datos.length === 0) {
                $("#productos").html("<p style='text-align:center; padding: 20px;'>Tu carrito está vacío.</p>");
            }

            datos.forEach(item => {

                let cuerpo = item.nombre_cuerpo || "Cuerpo estándar";
                let mastil = item.nombre_mastil || "Mástil estándar";
                let pastillas = item.nombre_pastillas || "Pastillas base";

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
                    </div>
                `);

                total += parseFloat(item.precio);
            });

            $("#total").text(total.toFixed(2));
        },
        error: function() {
            console.error("Error al cargar el carrito");
        }
    });
}

function comprar(){
    // Redirige a la página de pago con PayPal
    window.location.href = "../../backend/php/comprar.php";
}