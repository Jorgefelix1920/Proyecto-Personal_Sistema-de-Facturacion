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

<section id="container">
    <h1>Actualizar Usuario</h1>
    <a href="registro-usuario.php" class="new-btn-user">Nuevo Usuario</a>

    <table>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>CORREO</th>
            <th>USUARIO</th>
            <th>ROL</th>
            <th>ACCIONES</th>

        </tr>

        <?php 
        // carga las tablas desde la base de datos 

        $query = mysqli_query($connection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol 
        FROM usuario u INSERT JOIN rol r ON u.rol = r.idrol");

        $resultado = mysqli_num_rows($query, $connection);

        if ($resultado > 0) {
            while($data=mysqli_fetch_array($query)){?>

 <tr>
            <td><?php echo $data['idusuario'];?></td>
            <td><?php echo $data['nombre'];?></td>
            <td><?php echo $data['correo'];?></td>
            <td><?php echo $data['usuario'];?></td>
            <td><?php echo $data['rol'];?></td>
            <td>
            <a href="edit_user.php?id=<?php echo $data['idusuario'];?>" class="link-edit">Editar</a>
            <a href="delete_user.php?id=<?php echo $data['idusuario'];?>" class="link-delete">Eliminar</a>
            </td>
<?php
            }
        }

        ?>
       
        </tr>
    </table>
<?php if (!empty($_GET['mensaje'])){
    echo $_GET['mensaje'];
}
?>
</section>
    
</body>
</html>