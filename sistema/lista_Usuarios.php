<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <?php include_once('includes/scripts.php') ?>
    
</head>
<body>
<?php include_once('includes/header.php');?>
<?php require_once('../connection.php') ?>

        <script>
                    // Confirmar Eliminacion de Datos 
                    function confirmarDelete() {
                        var repuesta = confirm("Estas Seguro que desea eliminar el campo");
                        if (repuesta == true) {
                            return true;
                        }
                        if (repuesta == false) {
                            return false;
                        }
                    }
        </script>
<section id="container">
    <h1>Lista de Usuario</h1>
    <a href="registro-usuario.php" class="new-btn-user">Nuevo Usuario</a>

    <table>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>CORREO</th>
            <th>USUARIO</th>
            <th>FECHA DE INGRESO</th>
            <th>ROL</th>
            <th>ACCIONES</th>

        </tr>

        <?php 
        // carga las tablas desde la base de datos 

        $query = mysqli_query($connection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, u.fecha_de_creacion, r.rol 
        FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1");

        $resultado = mysqli_num_rows($query);

        if ($resultado > 0) {
            while($data=mysqli_fetch_array($query)){?>

 <tr>
            <td><?php echo $data['idusuario'];?></td>
            <td><?php echo $data['nombre'];?></td>
            <td><?php echo $data['correo'];?></td>
            <td><?php echo $data['usuario'];?></td>
            <td><?php echo $data['fecha_de_creacion'];?></td>
            <td><?php echo $data['rol'];?></td>
            <td>
          
            <a href="edit_user.php?id=<?php echo $data['idusuario'];?>" class="link-edit">Editar</a>

              <?php if ($data['rol'] !='Administrador' &&  $_SESSION['nombre'] !=$data['nombre'] && $data['idusuario'] !=1){?>
            <a href="delete_user.php?id=<?php echo $data['idusuario'];?>" onclick="return confirmarDelete()" class="link-delete">Eliminar</a>
            </td>
<?php v 
            }}
        }

        ?>
       
        </tr>
    </table>
<?php if (!empty($_GET['mensaje'])){
    echo $_GET['mensaje'];
}elseif(!empty($_SESSION['mensaje'])){
    echo $_SESSION['mensaje'];
}
?>
</section>
    
</body>
</html>