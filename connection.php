<?php 
$serverhost ='localhost';
$user ='root';
$password ='';
$database ='facturacion';

$connection = mysqli_connect($serverhost, $user, $password, $database);

if (!$connection){
    //echo "Error en la conexión ".mysqli_error($connection);
}else{
    //echo "conexión exitosa";
}