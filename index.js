$(document).ready(function() {
    $('#login_form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'models/Usuario.php',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.rol_id == 1) {
                    // Usuario normal
                    window.location.href = 'view/Home/';
                } else if (data.rol_id == 0) {
                    // Administrador
                    window.location.href = 'view/Home/';
                } else {
                    alert('Rol desconocido');
                }
            },
            error: function() {
                alert('Error en la petición');
            }
        });
    });
});