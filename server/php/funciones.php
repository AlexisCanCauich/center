<?php

    function subir_imagen(){
        if(isset($_FILES["imagen_usuario"])){
            $extencion = explode('.', $_FILES["imagen_usuario"]['name']);
            $nuevo_nombre = rand() . '.' . $extencion[1];
            $ubicacion = '../img/' . $nuevo_nombre;
            move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    function obtener_nombre_imagen($id_usuario){
        include('../././conection_app/conexion.php');
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE id = '$id_usuario'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["imagen"];
        }
    }

    function obtener_todos_registros(){
        
        include('../././conection_app/conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $stmt->rowCount();
    }

    function obtener_todos_registros_entregados(){
        
        include('../././conection_app/conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM entregas");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return $stmt->rowCount();
    }