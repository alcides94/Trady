<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id_sus=$_POST["id_suscripcion"];
        //echo "<h1> $id_anime</h1>";
        $sql = "DELETE FROM suscripcion_comercios WHERE id_suscripcion = :id_sus";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_sus' => $id_sus]);

    }
    header('Location: ../pantallasuscripciones.php');
    exit;

?>
