
<?php
require('../../util/conexion.php');

if (isset($_GET['id_suscripcion_usuario'])) {
    $id = $_GET['id_suscripcion_usuario'];

    $stmt = $_conexion->prepare("SELECT * FROM suscripcion_usuarios WHERE id_suscripcion = :id_suscripcion");
    $stmt->execute(['id_suscripcion' => $id]);
    $sus_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($sus_usuario);
}else{
    $id = $_GET['id_sus_comercio'];

    $stmt = $_conexion->prepare("SELECT * FROM suscripcion_comercios WHERE id_suscripcion = :id_suscripcion");
    $stmt->execute(['id_suscripcion' => $id]);
    $sus_comercio = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($sus_comercio); 
}
?>
