$(document).ready(function(){
    var dataTable = $('#datos_usuario').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: "././server/php/obtener_registros.php",
            type:"POST"
        },
        "columnsDefs":[
            {
                "targets":[0, 3, 4],
                "orderable":false,
            },
            
        ]
    })
});

