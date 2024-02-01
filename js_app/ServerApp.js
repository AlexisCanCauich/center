$(document).ready(function(){

    console.log("alexis dddd hokax  ddcanddddddddd cauich");

    $("#botonCrear").click(function(){
        $("#formulario")[0].reset();
        $(".modal-title").text("Crear Usuario");
        $("#action").val("Crear");
        $("#operacion").val("Crear");
        $("#imagen_subida").html("");
    });

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

    $(document).on('submit', '#formulario', function(event){
        event.preventDefault();
        var nombres = $("#nombre").val();
        var apellidos = $("#apellidos").val();
        var telefono = $("#telefono").val();
        var correo = $("#correo").val();
        var extencion = $("#imagen_usuario").val().split('.').pop().toLowerCase();
    
        if(extencion != ''){
            if(jQuery.inArray(extencion, ['gif','png','jpg','jpeg']) == -1){
                alert('formato d eimagen invalido');
                $("imagen_usuario").val('');
                return false;
            }
        } 
    
        if(nombres != '' && apellidos != '' && correo != ''){
            $.ajax({
                url: "././server/php/crear.php",
                method: "POST",
                data: new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    alert(data);
                    $('#formulario')[0].reset();
                    $('#modalUsuario').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }else {
            alert("Algunos campos son obligatorios");
        }
    });

    //FUncionalidad de editar 
    $(document).on('click', '.Editar', function() {
        console.log("boton editar");
        var id_usuario = $(this).attr("id");
        $.ajax({
            url:"././server/php/obtener_registro.php",
            method:"POST",
            data:{id_usuario:id_usuario},
            dataType:"json",
            success:function(data)
            {
                $("#modalUsuario").modal('show');
                $("#nombre").val(data.nombre);
                $("#apellidos").val(data.apellidos);
                $("#telefono").val(data.telefono);
                $("#correo").val(data.correo);
                $(".modal-title").text("Editar usuario");
                $("#id_usuario").val(id_usuario);
                $("#imagen_subida").html(data.imagen_usuario);
                $("#action").val("Editar");
                $("#operacion").val("Editar");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus,errorThrown);
            }
        });
    });

    //Funcionalidad borrar 
    $(document).on('click', '.Borrar', function(){
        console.log("btn borrar");
        var id_usuario = $(this).attr("id");

        if (confirm("Estas seguro de borrar este registro: " + id_usuario)) {
            $.ajax({
                url:"././server/php/borrar.php",
                method:"POST",
                data:{id_usuario:id_usuario},
                success:function(data)
                {
                    alert(data);
                    dataTable.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
    
});

