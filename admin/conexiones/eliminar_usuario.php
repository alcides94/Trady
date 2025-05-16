<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id_usuario=$_POST["id_usuario"];
        //echo "<h1> $id_anime</h1>";
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);

    }
    header('Location: ../pantallausuarios.php');
    exit;

?>
