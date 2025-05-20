<?php
require('../../util/conexion.php');

// Habilitar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $id_recompensa = $_POST['edit_id_recompensa'] ?? '';
    $nombre = $_POST['edit_nombre'] ?? '';
    $puntos = $_POST['edit_puntos'] ?? '';
    $qrs_escanear = $_POST['edit_qrs_escanear'] ?? '';
    $estado = $_POST['edit_estado'] ?? 0;

    // Validar datos básicos
    if (empty($id_recompensa) || empty($nombre) || empty($puntos) || empty($qrs_escanear)) {
        echo json_encode(['error' => 'Faltan campos obligatorios']);
        exit;
    }

    // Validar que puntos y qrs_escanear sean números positivos
    if (!is_numeric($puntos) || $puntos <= 0 || !is_numeric($qrs_escanear) || $qrs_escanear <= 0) {
        echo json_encode(['error' => 'Los puntos y QRs a escanear deben ser números positivos']);
        exit;
    }

    try {
        // Consulta para actualizar la recompensa
        $stmt = $_conexion->prepare("
            UPDATE recompensas
            SET nombre = :nombre,
                puntos = :puntos,
                qrs_escanear = :qrs_escanear,
                estado = :estado
            WHERE id_recompensas = :id_recompensa
        ");

        $stmt->execute([
            'nombre' => $nombre,
            'puntos' => $puntos,
            'qrs_escanear' => $qrs_escanear,
            'estado' => $estado,
            'id_recompensa' => $id_recompensa
        ]);

    
        // Redirección a la pantalla de recompensas
        header('Location: ../pantallarecompensas.php?success=1');
        exit;
        

    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        error_log('Error al actualizar recompensa: ' . $e->getMessage());
        header('Location: ../pantallarecompensas.php?error=Error al actualizar la recompensa');
        exit;
    }
} else {
    // Si no es POST, redireccionar
    header('Location: ../pantallarecompensas.php');
    exit;
}
?>