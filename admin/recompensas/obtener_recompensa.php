
<?php
require('../../util/conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id_recompensa'])) {
    $id = $_GET['id_recompensa'];

    $stmt = $_conexion->prepare("SELECT * FROM recompensas WHERE id_recompensas = :id_recompensas");
    $stmt->execute(['id_recompensas' => $id]);
    $recompensa = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($recompensa);
}
?>
