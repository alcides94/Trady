<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id=$_POST["id_recompensa"];
        
        $sql = "DELETE FROM recompensas WHERE id_recompensas = :id_recompensas";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_recompensas' => $id]);

    }
    header('Location: ../pantallarecompensas.php');
    exit;

?>
