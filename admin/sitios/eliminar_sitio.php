<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id_sitio=$_POST["id_sitio"];
        //echo "<h1> $id_anime</h1>";
        $sql = "DELETE FROM sitiosInteres WHERE id_sitio = :id_sitio";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_sitio' => $id_sitio]);

    }
    header('Location: ../pantallasitiosinteres.php');
    exit;

?>
