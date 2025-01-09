var tabla;
var usu_id =  $('#user_idx').val();

function init()
{
    $("#ticket_form").on("submit",function(e){
        guardar(e);	
    });
}

$(document).ready(function()
{

    var Success = getUrlParameter('Success');

    if(Success=='OK')
    {
        swal("Correcto!", "Registrado Correctamente", "success");
    }


    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#cat_id').html(data);
    });
    
    $.post("../../controller/usuario.php?op=UserActivoSession", function (data) 
    {
        data = JSON.parse(data);
        
        if (data.id_rol == 4)
        {
            $('#viewuser').hide();
        
            tabla=$('#ticket_data').dataTable({
                "aProcessing": true,
                "aServerSide": true,
                dom: 'Bfrtip',
                "searching": true,
                lengthChange: false,
                colReorder: true,
                buttons: [		          
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                        ],
                "ajax":{
                    url: '../../controller/ticket.php?op=listar_x_usu',
                    type : "post",
                    dataType : "json",	
                    data:{ usu_id : data.Enlace },						
                    error: function(e){
                        console.log(e.responseText);	
                    }
                },
                "ordering": false,
                "bDestroy": true,
                "responsive": true,
                "bInfo":true,
                "iDisplayLength": 10,
                "autoWidth": false,
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }     
            }).DataTable();
        }else {
            tabla=$('#ticket_data').dataTable({
                "aProcessing": true,
                "aServerSide": true,
                dom: 'Bfrtip',
                "searching": true,
                lengthChange: false,
                colReorder: true,
                buttons: [                
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                        ],
                "ajax":{
                    url: '../../controller/ticket.php?op=listar',
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
                "bDestroy": true,
                "responsive": true,
                "bInfo":true,
                "iDisplayLength": 10,
                "autoWidth": false,
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }     
            }).DataTable(); 
        }

    });
});
    
   
function ver(tick_id)
{
    $.post("../../controller/URL.php?op=HelpDesk", function (data) 
    {
        data = JSON.parse(data);
        window.open(data.Url_HelpDesk+'/view/DetalleTicket/?ID='+ tick_id +'');
    });
}


function guardar(e)
{
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos)
        {
            var tick_id = $('#tick_id').val();
            $.post("../../controller/email.php?op=ticket_asignado", {tick_id : tick_id}, function (data) 
            {

            });

            swal("Correcto!", "Asignado Correctamente", "success");

            $("#modalasignar").modal('hide');
            $('#ticket_data').DataTable().ajax.reload();
        }
    });
}

function CambiarEstado(tick_id){
    swal({
        title: "HelpDesk",
        text: "Esta seguro de Reabrir el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) { //boton de reabrir ticket cerrado
        if (isConfirm) {
            $.post("../../controller/ticket.php?op=reabrir", {tick_id : tick_id,usu_id : usu_id}, function (data) {

            });
            
            $('#ticket_data').DataTable().ajax.reload();	

            swal({
                title: "HelpDesk!",
                text: "Ticket Abierto.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click", "#btnfiltrar", function() {
    console.log("Filtro activado");
    limpiar();
    var tick_titulo = $('#tick_titulo').val();
    var cat_id = $('#cat_id').val();

    //console.log("Título: ", tick_titulo, "Categoría ID: ", cat_id);
    listardatatable(tick_titulo, cat_id);
});

$(document).on("click", "#btntodo", function() {
    console.log("Botón para todos los tickets activado");
    limpiar();
    $('#tick_titulo').val('');
    $('#cat_id').val('').trigger('change');
    listardatatableTodos();
});

function listardatatable(tick_titulo,cat_id){
    tabla=$('#ticket_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/ticket.php?op=listar_filtro',
            type : "post",
            dataType : "json",
            data:{ tick_titulo:tick_titulo,cat_id:cat_id},
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable().ajax.reload();
}

function listardatatableTodos(){
    tabla=$('#ticket_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/ticket.php?op=listar',
            type : "post",
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable().ajax.reload();
}


function limpiar(){
    $('#table').html(
        "<table id='ticket_data' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
            "<thead>"+
                "<tr>"+
                    "<th style='width: 5%;'>Nro.Ticket</th>"+
                    "<th style='width: 15%;'>Categoria</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 30%;'>Titulo</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Estado</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Creación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Fecha Asignación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 10%;'>Soporte</th>"+
                    "<th class='text-center' style='width: 5%;'></th>"+
                "</tr>"+
            "</thead>"+
            "<tbody>"+

            "</tbody>"+
        "</table>"
    );
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

init();