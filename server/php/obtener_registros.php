<?php

    include("../conection_app/conexion.php");
    include("funciones.php");

    $query = "";
    $salida = array();
    $query = "SELECT * FROM usuarios ";

    if(isset($_POST["search"]["value"])) {
        $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" '; 
        $query .= 'OR apellidos LIKE "%' . $_POST["search"]["value"] . '%" '; 
    }

    if(isset($_POST["order"])) {
        $query .= 'ORDER BY ' . $_POST["order"][0]["column"] . '' . $_POST["order"][0]['dir'] . ' '; 
    }else {
        $query.='ORDER BY id DESC ';
    }

    if($_POST["length"] != -1){
        $query .= 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
    }

    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $datos = array();
    $filtered_rows = $stmt->rowCount();
    foreach($resultado as $fila) {
        $imagen = '';
        if($fila["imagen"] != ''){
            $imagen = '<img src="server/img/' . $fila["imagen"] . '" class="img-thumbnail" width="50" height="35"/>';
        }else {
            $imagen = '';
        }
        $sub_array = array();
        //$sub_array[] = $fila["id"];
        $sub_array[] = '<a type="button" name="registro_th" id="'.$fila["id"]. '" class="btn btn-xs Registro_th"> '.$fila["id"].' </a>';
        $sub_array[] = $fila["nombre"];
        $sub_array[] = $fila["apellidos"];
        $sub_array[] = $fila["telefono"];
        $sub_array[] = $fila["correo"];
        $sub_array[] = $imagen;
        $sub_array[] = $fila["fecha_creacion"];
        $sub_array[] = '<button type="button" name="Editar" id="'.$fila["id"]. '" class="btn btn-warning btn-xs Editar"> Ediar </button>';
        $sub_array[] = '<button type="button" name="Borrar" id="'.$fila["id"]. '" class="btn btn-danger btn-xs Borrar"> Borrar </button>';
        $sub_array[] = '<button type="button" name="Listo" id="'.$fila["id"]. '" class="btn btn-success btn-xs Listo"> Entregado </button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"              => intval($_POST["draw"]),
        "recordsTotal"      => $filtered_rows,
        "recordsFiltered"   => obtener_todos_registros(),
        "data"              => $datos
    );

    echo json_encode($salida);