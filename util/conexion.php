<?php

    $_servidor ="localhost"; 
    $_usuario="estudiante"; 
    $_contrasena ="estudiante";
    $_base_de_datos="trady_bd"; 

    $_conexion=new Mysqli($_servidor,$_usuario,$_contrasena,$_base_de_datos)
        or die ("Error de conexion");

?>