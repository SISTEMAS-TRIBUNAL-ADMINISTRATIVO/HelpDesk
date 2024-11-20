$(document).ready(function() {
    mostrar_notificacion();
});

function mostrar_notificacion() {
    var formData = new FormData();
    formData.append('usu_id', $('#user_idx').val());

    $.ajax({
        url: "../../controller/notificacion.php?op=mostrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            try {
                // Intentamos parsear la respuesta JSON
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
                    url: "http://localhost/HelpDesk/view/DetalleTicket/?ID=" + data.tick_id
                });

                // Actualiza el estado de la notificación
                $.post("../../controller/notificacion.php?op=actualizar", {not_id: data.not_id}, function(data) {});
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
