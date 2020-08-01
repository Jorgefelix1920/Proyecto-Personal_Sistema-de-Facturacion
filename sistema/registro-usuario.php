<?php 
  require_once('../connection.php'); 
  $msg_alert='';
  $msg_error='';
  $nombre = $email = $usuario = $rol = NULL;

 
if (!empty($_POST)){
  
    if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['usuario']) || empty($_POST['rol'])){

        // envia una alerta de error al encontrar un campo vacio
        $msg_alert='alert';
        $msg_error='<p class ="msg_error"> Todos los Campos son Obligatorios</p>';
    }else{ 

        $nombre   =  $_POST['nombre'];
        $email    =  $_POST['email'];
        // COdificamos la Clave antes de entrar en la base de datos
        $password =  md5($_POST['password']);
        $usuario  =  $_POST['usuario'];
        $rol      =  $_POST['rol'];

        // esta consulta verifica si el usuario o el correo existen
        $query = mysqli_query($connection, "SELECT * FROM usuario WHERE usuario = '$usuario' OR correo = '$email'");

         // valida si el usuario o el correo existen
        // TODO Validar solo el correo

        $resultado = mysqli_fetch_array($query);
        if($resultado > 0) {
                mysqli_close($connection);
                $msg_alert='alert';
                $msg_error='<p class ="msg_error">El Correo o el Usuario ya existe</p>';

        }else{
                // inserta los datos en la tabla usuario 
                $query_insert = mysqli_query($connection, "INSERT INTO usuario (nombre, correo, usuario, clave, rol) 
                VALUE ('$nombre', '$email', '$usuario', '$password', '$rol')");
                    mysqli_close($connection);

                if ($query_insert){
                    $msg_alert='alert';
                    $msg_error='<p class ="msg_save">El Usuario se Registro Correctamente</p>';
    
                }else{
                    $msg_alert='alert';
                    $msg_error='<p class ="msg_error">Erro al crear el usuario</p>';
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
                <label type = "nombre">Nombre</label>
                <input type="text" name="nombre" value="<?php echo $nombre;?>" placeholder="Introduzca el nombre" autofocus >
                
                <label type = "email">Correo Electronico</label>
                <input type="email" name="email" value="<?php echo $email;?>" placeholder="Introduzca el Correo" >

                <label type = "password">Password</label>
                <input type="password" name="password" placeholder="Introduzca la contraseña" >

                <label type = "Usuario">Nombre de Usuario</label>
                <input type="text" name="usuario" value="<?php echo $usuario;?>" placeholder="Introduzca el Usuario" >
                <label type = "rol">Rol</label>
                
                <?php 
                // Carga los roles de desde la base de datos 
                $query_rol = mysqli_query($connection, "SELECT * FROM rol"); 
                $resul_rol = mysqli_num_rows($query_rol);
                ?>
                <select name="rol" id="idrol" >
                <option value="0">Elija un Rol</option>
                <?php 
                if ($resul_rol > 0){
                    while($rol = mysqli_fetch_array($query_rol)){ ?>
                    <option value="<?php echo $rol['idrol']?>"><?php echo $rol['rol']?></option>
                    <?php
                }// fin del while
        
                }// fin del IF
                ?>    
                    <option <?php if (isset($rol) && $rol=="3") echo "selected";?> value="3">Vendedor</option>
                </select>

            <input type="submit" class="btn-Registrar" value="Registrar  ">
            </form>



        </div>
	</section>
	<?php include_once('includes/footer.php');?>
</body>
</html>