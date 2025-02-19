$(document).ready(function() {
    /* TODO: Obtener ID del usuario que inició sesión */
    var usu_id = $('#user_idx').val();

    /* TODO: Listado de registros */
    var tabla = $('#notificacion_data').DataTable({
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
        "ajax": {
            url: '../../controller/notificacion.php?op=listar',
            type: "post",
            dataType: "json",
            data: { usu_id: usu_id },
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    // Actualizar la tabla cada 30 segundos
    setInterval(function() {
        tabla.ajax.reload(); // Recargar los datos de la tabla
    }, 15000); // 30 segundos
});

function ver(tick_id, IdNoti) {
    $.post("../../controller/URL.php?op=HelpDesk", function (data) 
    {
        data = JSON.parse(data);
        window.open(data.Url_HelpDesk + 'view/DetalleTicket/?ID=' + tick_id + '&IdNoti=' + IdNoti);
    });
}
