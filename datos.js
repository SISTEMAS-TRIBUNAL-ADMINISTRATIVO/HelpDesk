function init() {
    $(document).on("click", "#btnsoporte", function () {
        if ($('#rol_id').val() == 1) {
            $('#lbltitulo').html("Acceso Soporte");
            $('#btnsoporte').html("Acceso Usuario");
            $('#rol_id').val(0); // Cambio a 0 para el rol de administrador
            $("#imgtipo").attr("src", "public/2.jpg"); // Cambio de imagen para el administrador
        } else if ($('#rol_id').val() == 0) {
            $('#lbltitulo').html("Acceso Usuario");
            $('#btnsoporte').html("Acceso Soporte");
            $('#rol_id').val(1); // Cambio a 1 para el rol de usuario
            $("#imgtipo").attr("src", "public/1.jpg"); // Cambio de imagen para el usuario
        }
    });
}

$(document).ready(function () {
    
});

//TODO: Función para iniciar el proceso de inicio de sesión con Google
function startGoogleSignIn(){
    //TODO: Obtener la instancia de autenticación de Google
    const auth = gapi.auth2.getAuthInstance();
     //TODO: Iniciar sesión con Google
     auth.signIn();
}

function handleCredentialResponse(response){
    if(response && response.credential){
        const credentialToken = response.credential;
        //TODO: Decodificar el token manualmente para obtener datos del usuario
        const decodedToken = JSON.parse(atob(credentialToken.split('.')[1]));
        //TODO: Imprimir en la consola los datos del usuario

        $.ajax({
            url:'controller/usuario.php?op=accesogoogle',
            type:'post',
            data:{usu_correo:decodedToken.email},
            success: function(data){
                console.log(data);
                if(data === "0"){
                    swal("Advertencia!", "Usuario no Registrado", "warning");
                }else if (data==="1"){
                    window.location.href = 'view/Home/'
                }
            }
        });
    }
}

$.ajax({
    url:'../../controller/usuario.php?op=accesogoogle',
    type:'post',
    data:{usu_correo:decodedToken.email},
    success: function(data){
        console.log(data);
        if(data === "0"){
            swal("Advertencia!", "Usuario no Registrado", "warning");
        }else if (data==="1"){
            window.location.href = '../Home/'
        }
    }
});
init();
