<?php
require('../../util/conexion.php');

// Habilitar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_qr = $_POST['edit_id_qr'] ?? '';
    $nombre = $_POST['edit_nombre'] ?? '';
    $tipo = $_POST['edit_tipo'] ?? '';
    $identificador_qr = $_POST['edit_identificador_qr'] ?? '';
    $puntos = $_POST['edit_puntos'] ?? '';
    $id_comercio = $_POST["id_comercio"] ?? null;
    $id_sitio = $_POST['edit_id_sitio'] ?? null;

    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="."TRADY-" . $identificador_qr;
    // Consulta para actualizar el sitio de interés
    $stmt = $_conexion->prepare("
        UPDATE qr_codigos
        SET nombre = :nombre,
            tipo = :tipo,
            qr = :qr,
            puntos = :puntos,
            identificador_qr = :identificador_qr,
            id_sitio = :id_sitio,
            id_comercio = :id_comercio
        WHERE id_qr = :id_qr
    ");

    $stmt->execute([
        'nombre' => $nombre,
        'tipo' => $tipo,
        'puntos' => $puntos,
        'qr' => $qr_url,
        'identificador_qr' => $identificador_qr,
        'id_comercio' => $id_comercio,
        'id_sitio' => $id_sitio,
        'id_qr' => $id_qr
    ]);

    // Redirección (podés cambiar la ruta según necesites)
    header('Location: ../pantallacodigosqr.php');
    exit;
}
?>
