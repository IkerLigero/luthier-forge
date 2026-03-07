window.onload = inicio;

function inicio() {

    $.ajax({

        url: "../../backend/php/historial.php",

        success: function (res) {

            let datos = JSON.parse(res);

            for (let i = 0; i < datos.length; i++) {

                $("#historial").append(
                    "<p>Compra " + datos[i].id_compra +
                    " - " + datos[i].total + "€</p>"
                );

            }

        }

    });

}