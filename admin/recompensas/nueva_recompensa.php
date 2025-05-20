<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener datos del formulario (asegúrate que se envíen)
        $nombre = $_POST['nombre'] ?? '';
        $puntos = isset($_POST['puntos']) ? (int)$_POST['puntos'] : 0;
        $qrs_escanear = isset($_POST['qrs_escanear']) ? (int)$_POST['qrs_escanear'] : 0;
        $estado = $_POST['estado'];
        // Validación básica
        if (empty($nombre) || $puntos <= 0 || $qrs_escanear <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios y deben ser válidos.']);
            exit();
        }

        // Preparar y ejecutar inserción en la tabla recompensas
        $stmt = $_conexion->prepare("
            INSERT INTO recompensas (nombre, puntos, qrs_escanear, estado)
            VALUES (:nombre, :puntos, :qrs_escanear, :estado)
        ");

        $stmt->execute([
            "nombre" => $nombre,
            "puntos" => $puntos,
            "qrs_escanear" => $qrs_escanear,
            "estado" => $estado
        ]);

        echo json_encode(['status' => 'ok']);
        header('Location: ../pantallarecompensas.php');
        exit();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
