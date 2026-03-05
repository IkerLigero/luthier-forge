window.onload = inicio;

function inicio(){

    cargarCarrito();

    $("#comprar").click(comprar);

}

function cargarCarrito(){

    $.ajax({

        url:"../../backend/php/cargar_carrito.php",

        success:function(res){

            let datos = JSON.parse(res);

            $("#productos").html("");

            let total = 0;

            for(let i=0;i<datos.length;i++){

                $("#productos").append(
                    "<p>Guitarra "+datos[i].id_guitarra_usuario+
                    " - "+datos[i].precio+"€</p>"
                );

                total += parseFloat(datos[i].precio);

            }

            $("#total").text(total);

        }

    });

}

function comprar(){

    $.ajax({

        url:"../../backend/php/comprar.php",

        success:function(){

            const notyf = new Notyf();
            notyf.success("Compra realizada");

            cargarCarrito();

        }

    });

}