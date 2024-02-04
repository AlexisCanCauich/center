<?php

include("../conection_app/conexion.php");
include("funciones.php");

if(isset($_POST["id_usuario"])){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila) {
        $salida["nombre"] = $fila["nombre"];
        $salida["apellidos"] = $fila["apellidos"];
        $salida["telefono"] = $fila["telefono"];
        $salida["correo"] = $fila["correo"];
        if($fila["imagen"] != "") {
            $salida["imagen_usuario"] = '<img src="server/img/' . $fila["imagen"] . '" class="img-thumbnail" width="50" height="35"/><input type="hidden" name="imagen_usuario_oculta" value="'.$fila["imagen"].'" />';
        }else {
            $salida["imagen_usuario"] = '<input type="hidden" name="imagen_usuario_oculta" value="" />';
        }
    }

    if ($salida != '') {
        
        $nombre = $fila["nombre"];
        $apellidos = $fila["apellidos"];
        $telefono = $fila["telefono"];
        $correo = $fila["correo"];
        $imagen = $fila["imagen"];
    
        $stmt = $conexion->prepare("INSERT INTO entregas(nombre,apellidos,imagen,telefono,correo)VALUES('$nombre','$apellidos','$imagen','$telefono','$correo')");
        $resultado = $stmt->execute();
    
        if(!empty($resultado)) {

            $ID = $_POST["id_usuario"];

            $stmt1 = $conexion->prepare("DELETE FROM usuarios WHERE id = '$ID' ");
            $resultado_delete = $stmt1->execute();
            if(!empty($resultado_delete)) {
            echo 'Registro creado'.$ID;
            }else{
                echo 'Registro NOOOO creado'.$ID;
            }
        }
    } else {
        echo "no hay ni verga ";
    }
    
}