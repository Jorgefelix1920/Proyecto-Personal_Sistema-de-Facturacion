<?php 
 session_start();
 if (empty($_SESSION['active'])){
    $_SESSION['erro']="SOLO USUARIOS AUTENTIFICADOS PUEDEN INGRESAR A ESTA ÁREA";
   header('location:../index.php');
 }
 ?>

<header>
		<div class="header">
			
			<h1>Sistema Facturación</h1>
			<div class="optionsBar">
				<p>	República Dominicana, <?php echo fechaCorrecta();?></p>
				<span>|</span>
                <span class="user"> <?php echo  $_SESSION['nombre'];?></p></span>
                <span>|</span>
                <span class="user"> <?php 
                switch ($_SESSION['rol']) {
                    case '1':
                        echo "Administrador";
                        break;

                    case '2':
                        echo "Supervisor";
                        break;

                    case '3':
                        echo "Vendedor";
                        break;
                }
               ;?></p></span>

				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include_once('nav.php'); ?>
	</header>