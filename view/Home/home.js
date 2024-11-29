function init()
{
}

$(document).ready(function() {
    // Función para actualizar los totales
    function updateTotals() {
        $.post("../../controller/usuario.php?op=total", function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalabierto", function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=totalcerrado", function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.TOTAL);
        });
    }

        // Llamada inicial a la función para cargar los datos cuando la página se carga
        updateTotals();

        // Actualiza los totales cada 30 segundos
        setInterval(updateTotals, 15000);

    $.post("../../controller/usuario.php?op=grafico", function (data) 
    { 
        data = JSON.parse(data);
        
        new Morris.Bar({
            element: 'divgrafico',
            data: data,
            xkey: 'nom',
            ykeys: ['total'],
            labels: ['Value'],
        });
    }); 

    $('#idcalendar').fullCalendar({
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultView: 'month',
        events: {
            url: '../../controller/ticket.php?op=all_calendar'
        },
        eventRender: function(event, element) {
            // Aplicar estilos personalizados
            element.css({
                'background-color': event.color, // Color del fondo
                'border': 'none', // Sin borde
                'color': 'black', // Letras blancas
                'border-radius': '5px', // Bordes redondeados
                'padding': '5px' // Espacio interno
            });
        },
        dayRender: function(date, cell) {
            // Asegurar fondo blanco para los días
            cell.css('background-color', '#FFFFFF');
        }


        
    });
    
/*     $('#idcalendar').fullCalendar({
        lang:'es',
        header:{
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'  
        },
        defaultView:'month',
        events:{
            url:'../../controller/ticket.php?op=all_calendar'
        }
    }); */
});

init();