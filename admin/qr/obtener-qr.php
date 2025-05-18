
<?php
require('../../util/conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id_qr'])) {
    $id = $_GET['id_qr'];

    $stmt = $_conexion->prepare("SELECT * FROM qr_codigos WHERE id_qr = :id_qr");
    $stmt->execute(['id_qr' => $id]);
    $codigo = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($codigo);
}
?>
