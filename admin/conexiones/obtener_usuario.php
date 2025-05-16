<?php
require('../../util/conexion.php');

if (isset($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];

    $stmt = $_conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($usuario);
}
?>
