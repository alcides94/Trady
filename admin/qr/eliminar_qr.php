<?php
require('../../util/conexion.php');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $id_qr=$_POST["id_qr"];
        //echo "<h1> $id_anime</h1>";
        $sql = "DELETE FROM qr_codigos WHERE id_qr = :id_qr";
        $stmt = $_conexion -> prepare($sql);
        $stmt->execute(['id_qr' => $id_qr]);

    }
    header('Location: ../pantallacodigosqr.php');
    exit;

?>
