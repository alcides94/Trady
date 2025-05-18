
<?php
require('../../util/conexion.php');

if (isset($_GET['id_sitio'])) {
    $id = $_GET['id_sitio'];

    $stmt = $_conexion->prepare("SELECT * FROM sitiosInteres WHERE id_sitio = :id_sitio");
    $stmt->execute(['id_sitio' => $id]);
    $sitio = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($sitio);
}
?>
