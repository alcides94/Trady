<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id_comercios=$_POST["id_comercios"];
        //echo "<h1> $id_anime</h1>";
        $sql = "DELETE FROM comercios WHERE id_comercios = :id_comercios";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_comercios' => $id_comercios]);

    }
    header('Location: ../pantallapartners.php');
    exit;

?>
