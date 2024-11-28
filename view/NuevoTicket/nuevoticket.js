function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });

    $('#tick_descrip').summernote({
        height: 150,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air: [],
        },
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $.post("../../controller/categoria.php?op=combo",function(data, status)
    {
        $('#cat_id').html(data);
        cat_id =  $('#cat_id').val();

        $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
            $('#cats_id').html(data);
            //console.log(data);
        });

    });


    $("#cat_id").change(function(){
        cat_id = $(this).val();
        //console.log(cat_id);

        $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
            $('#cats_id').html(data);
            console.log(data);
        });

    });

   /* $.post("../../controller/prioridad.php?op=combo",function(data, status){ //No esta funcional
        $('#prio_id').html(data);
    });*/

}

function guardaryeditar(e){
    e.preventDefault();

    $('#btnguardar').prop("disable", true);
    $('#btnguardar').html('<i class="fa fa-spinner fa-spin"></i>');//


    var formData = new FormData($("#ticket_form")[0]);
    if($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()=='' || $('#cats_id').val()=='' || $('#prio_id').val()==''){
        swal({
            title: "Advertencia!",
            text: "Campos Vacios",
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Aceptar",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            },
            closeOnClickOutside: false
        }).then((value) => {
            if (value) {
                swal.close();
            }
        });
    }else{
        var totalfiles = $('#fileElem')[0].files.length;
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }
        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData, 
            contentType: false,
            processData: false,
            success: function(datos)
            {
                console.log(datos)
                datos = JSON.parse(datos);
                //console.log(datos[0].tick_id);

                /*$.post("../../controller/email.php?op=ticket_abierto", {tick_id : datos[0].tick_id}, function (data) {

                });*/

                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');

                $('#btnguardar').html('Guardar');
                $('#btnguardar').prop("enable", true);

                swal("Correcto!", " Ticket Registrado Correctamente", "success");

            }
        });
    }
}

$(document).ready(function() {
    init();
});
