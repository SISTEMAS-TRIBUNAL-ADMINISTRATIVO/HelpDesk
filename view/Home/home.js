function init(){
   
}

$(document).ready(function(){
    var usu_id = $('#user_idx').val();

        $.post("../../controller/usuario.php?op=total", {usu_id:usu_id}, function (data) {
           data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        }); 
    
        $.post("../../controller/usuario.php?op=totalabierto", {usu_id:usu_id}, function (data) {
           data = JSON.parse(data);
            $('#lbltotalabierto').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.TOTAL);
        });

       /* $.post("../../controller/usuario.php?op=grafico", {usu_id:usu_id},function (data) { //aqui debe de mostrar solo al usuario su total de tickets
            data = JSON.parse(data);
            
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value'],
                barColors: ["#1AB244"], 
            });
        }); */
  
        $.post("../../controller/ticket.php?op=grafico",function (data) {  // le muestra al administrador total de ticket abiertos!
           data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value']
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