$(document).ready(function() {
    mostrar_notificacion();
});

function mostrar_notificacion() 
{
    $.ajax({
        url: "../../controller/notificacion.php?op=MostrarNotificacionCampana",
        type: "POST",
        contentType: false,
        processData: false,
        success: function(data) 
        {
            try {
                
                data = JSON.parse(data);

                // Si no se encontraron notificaciones (error), no hacer nada
                if (data.error) {
                    console.log(data.error);  // Puedes hacer algo con el mensaje de error
                    return;  // Salimos de la función sin hacer nada
                }

                // Si se encontró una notificación válida
                $.notify({
                    icon: 'fa fa-bell',
                    message: data.not_mensaje,
                    url: "http://192.168.1.121/HelpDesk/view/DetalleTicket/?ID=" + data.tick_id +'&IdNoti='+data.not_id
                });

            } catch (e) {
                // Si ocurre un error al parsear la respuesta, muestra el error
                console.error("Error al parsear la respuesta JSON: ", e);
            }
        }
    });
}

// Llamar a la función cada 5 segundos
setInterval(function() {
    mostrar_notificacion();
}, 10000);
