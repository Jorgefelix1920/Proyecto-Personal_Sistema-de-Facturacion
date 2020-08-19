<?php
require_once('../connection.php');

// elimina Un Usuario 
    if(isset($_REQUEST['id']) ||$_REQUEST['id'] == 1){
        header('Location:lista_Usuarios.php?mensaje=No Puede Eliminar el Administrador');  // regresa aa la lista
        $_SESSION['mensaje'] ="Usuario Borrado Correctamente";
    }else{
         $id = $_REQUEST['id'];
        //$query = "DELETE FROM usuario WHERE idusuario = $id";
        $query = "UPDATE usuario SET estatus = 0 WHERE idusuario = $id";

        $resultato = mysqli_query($connection, $query);
           
        if (!$resultato) {
            die("No se encontro el Usuario");
            }
            
            header('Location:lista_Usuarios.php');  // regresa aa la lista
            $_SESSION['mensaje'] ="Usuario Borrado Correctamente";
            //$_SESSION['mensaje_color'] ="danger";
            
            // elimina demaciado facil, necesita que se coloque una confirmacion de eliminacion
    }
    
?>