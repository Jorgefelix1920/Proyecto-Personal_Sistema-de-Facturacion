<?php 
/*  Nombre  : Jorge Felix Gonzalez
    Fecha   : 31/07/2020
    Funcion : Sistema de Facturacion Basico PHP
  */
    $alert='';
    session_start();
  if (!empty($_SESSION['active'])){
    // agregar un mensaje para que si alguin intenta entrar le notifique 
    header('location:sistema/index.php');

  }else{

 
  if (!empty($_POST)){

      if (empty($_POST['email']) && empty($_POST['Password'])){
            $alert ='Ingrese un usuario y contraseña';
         }else{
             require_once('connection.php');
             // almacena los input ingresdos
            $user = mysqli_real_escape_string($connection, $_POST['email']) ;
            // la funcion MD5 
            $password = md5(mysqli_real_escape_string($connection, $_POST['password']));

             //consulta los datos en la base de datos
             $query = mysqli_query($connection,"SELECT * FROM usuario WHERE correo ='$user' AND clave = '$password'");

             // almacena el resultado encontrado 
             $resultado = mysqli_num_rows($query);

             // verifica si resultado encontro una coincidencia
             if ($resultado > 0){
               $data = mysqli_fetch_array($query);
                //(imprimer Array) print_r($data);

                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['idusuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['correo'];
                $_SESSION['user'] = $data['usuario'];
                $_SESSION['rol'] = $data['rol'];
                header('location:sistema/index.php');
             }else{
               $alert = 'El usuario o la contraseña son incorrectos';
               //session_destroy();
             }
           
         }
  }
  }// 
  ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
      
        <!-- icono  -->
    <link rel="shortcut icon" href="sistema/img/ico-prueba.png" type="image/x-icon">
        <!-- CSS -->

    <link href="css-login/assets/dist/css/bootstrap.css" rel="stylesheet">
    <link href="css-login/signin.css" rel="stylesheet">
    <title>Signin</title>
    
    
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

  
    <!-- incio del login -->
  </head>
  <body class="text-center">
    <form class="form-signin" method="POST" >
  <img class="mb-4" src="css-login/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name= "email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted"><h5>
      <?php 
    // imrpimer un mensaje en pantalla indicando lo que esta ocurriendo
    // si alert tiene algo lo imprime de lo contrario imprime basio
    if(isset($alert)) {echo $alert;}else {echo $alert='';} ?></p>
  </h5>
  
</form>
</body>
</html>
