<?php 
  require_once('../connection.php'); 
  $msg_alert='';
  $msg_error='';
  $nombre = $email = $usuario = $rol = NULL;
 
if (!empty($_POST)){
  
    if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['usuario']) || empty($_POST['rol'])){

        // envia una alerta de error al encontrar un campo vacio
        $msg_alert='alert';
        $msg_error='<p class ="msg_error"> Todos los Campos son Obligatorios</p>';
    }else{ 
        $idusuario  =  $_POST['idusuario'];
        $nombre     =  $_POST['nombre'];
        $email      =  $_POST['email'];
        // COdificamos la Clave antes de entrar en la base de datos
        $password   =  md5($_POST['password']);
        $usuario    =  $_POST['usuario'];
        $rol        =  $_POST['rol'];

        // esta consulta verifica si el usuario o el correo existen
        $query = mysqli_query($connection, "SELECT  *   FROM usuario   
                                                        WHERE (usuario = '$usuario' AND idusuario !=$idusuario) 
                                                        OR (correo = '$email' AND idusuario != $idusuario)");

         // valida si el usuario o el correo existen // TODO Validar solo el correo
        
         // convierte el resultado en un array 
        $resultado = mysqli_fetch_array($query);
        if($resultado > 0) {
                $msg_alert='alert';
                $msg_error='<p class ="msg_error">El Correo o el Usuario ya existe</p>';

        }else{
                
                    if (empty($password=$_POST['password'])){
                        //Actualiza el Usuario sin Camiar la Clave
                        $sql_update = mysqli_query($connection, " UPDATE usuario
                                                                  SET nombre ='$nombre', correo = '$email', usuario = '$usuario', rol = '$rol'
                                                                  WHERE idusuario = $idusuario ");
                    }else {
                        // Actualiza el Usuario con clave 
                        $sql_update = mysqli_query($connection, " UPDATE usuario
                                                                  SET nombre ='$nombre', correo = '$email', clave = '$password', usuario = '$usuario', rol = '$rol'
                                                                  WHERE idusuario = $idusuario ");
                    }
                if ($sql_update){
                    $msg_alert='alert';
                    $msg_error='<p class ="msg_save">El Usuario se Actualizo Correctamente</p>';
                    header('location:lista_Usuarios.php?mensaje= El Usuario '.$nombre.' se Actualizo Correctamente');
                    // aregrar alerta y redirecionar a lista de usuario
    
                }else{
                    $msg_alert='alert';
                    $msg_error='<p class ="msg_error">Erro al Actualizar el usuario</p>';
                }
        }
    }
}



        // Recupera los datos de la base de datos a traves del Id Proporcionado  

        if (empty($_GET['id'])){
            header('location:lista_Usuarios.php?mensaje="Tiene que Proporsionar un ID"');
        }else {
            $iduser= $_GET['id'];
            $sql = mysqli_query($connection, "SELECT  u.idusuario, u.nombre, u.correo, u.clave, u.usuario, (u.rol) as idrol, (r.rol) as rol 
            FROM usuario u 
            INNER JOIN rol r 
            ON u.rol = r.idrol
            WHERE idusuario = $iduser");

            $resultado_sql = mysqli_num_rows($sql);
            if ($resultado_sql==0 ){
               header('location:lista_Usuarios.php?mensaje="Usuario no Encontrado"');
            }else{
                $option= '';
                while ($data = mysqli_fetch_array($sql)) {
                    $idusuario = $data['idusuario'];
                    $nombre = $data['nombre'];
                    $email = $data['correo'];
                    $usuario = $data['usuario']; 
                    $password = $data['clave']; 
                    $idrol = $data['idrol'];
                    $rol = $data['rol'];

                    if ($idrol == 1)
                    {
                        $option = '<option value="'.$idrol.'" select>'. $rol .'</option>';
                    } else  if ($idrol == 2)
                    {
                        $option = '<option value="'.$idrol.'" select>'. $rol .'</option>';
                    } else  if ($idrol == 3)
                    {
                        $option = '<option value="'.$idrol.'"select>'. $rol .'</option>';
                    }
                }
            }
        
        }
?>
       
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include_once('includes/scripts.php');?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>

<body>
	<?php include_once('includes/header.php');?>
	<section id="container">
		<div class="form_register">
            <h1>Registro Usuario</h1>
            <hr>

            <div class="<?php echo $msg_alert?>"><?php echo $msg_error?></div>

            <form action="" method="POST">
                <input type="hidden" name="idusuario" value="<?php echo $iduser;?>">
                <label type = "nombre">Nombre</label>
                <input type="text" name="nombre" value="<?php echo $nombre;?>" placeholder="Introduzca el nombre" autofocus >
                
                <label type = "email">Correo Electronico</label>
                <input type="email" name="email" value="<?php echo $email;?>" placeholder="Introduzca el Correo" >

                  
                <label type = "password">Password</label>
                <input type="password" name="password" placeholder="Introduzca la contraseña">

                <label type = "Usuario">Nombre de Usuario</label>
                <input type="text" name="usuario" value="<?php echo $usuario;?>" placeholder="Introduzca el Usuario" >
               
               
                <label type = "rol">Rol</label>
                <?php 
                // Carga los roles de desde la base de datos 
                $query_rol = mysqli_query($connection, "SELECT * FROM rol"); 
                $resul_rol = mysqli_num_rows($query_rol);
                ?>
                <select name="rol" id="idrol" class="noItem">
               <!--<option>Elija un Rol</option>-->
                <?php 
                echo $option;
                if ($resul_rol > 0){
                    while($rol = mysqli_fetch_array($query_rol)){ ?>
                    <option value="<?php echo $rol['idrol']?>"><?php echo $rol['rol']?>
                </option>
                    <?php
                }// fin del while
        
                }// fin del IF
                ?>    
                </select>

            <input type="submit" class="btn-Registrar" value="Actualizar Usuario">
            </form>

        </div>
	</section>
	<?php include_once('includes/footer.php'); ?>
</body>
</html>