<?php 
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 ); 
    
    require('../util/conexion.php');

    session_start();
    $usuario=$_SESSION['usuario'];
    $sql="DELETE FROM usuarios WHERE email = '$usuario'";
    $_conexion -> query($sql);
    session_destroy();
    
    header("location: ../index.html");
    exit;

?>