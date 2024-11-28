function init()
{
}

$(document).ready(function()
{
    $.post("../../controller/usuario.php?op=total", function (data) 
    {
        data = JSON.parse(data);
        $('#lbltotal').html(data.TOTAL);
    }); 

    $.post("../../controller/usuario.php?op=totalabierto", function (data) 
    {
        data = JSON.parse(data);
        $('#lbltotalabierto').html(data.TOTAL);
    });

    $.post("../../controller/usuario.php?op=totalcerrado", function (data) 
    {
        data = JSON.parse(data);
        $('#lbltotalcerrado').html(data.TOTAL);
    });

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
    });
});

init();