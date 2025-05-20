
<?php
require('../../util/conexion.php');

if (isset($_GET['id_comercios'])) {
    $id = $_GET['id_comercios'];

    $stmt = $_conexion->prepare("SELECT * FROM comercios WHERE id_comercios = :id_comercios");
    $stmt->execute(['id_comercios' => $id]);
    $comercio = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($comercio);
}
?>
