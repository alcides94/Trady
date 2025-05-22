<?php
require('../../util/conexion.php');

// Habilitar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_sitio = $_POST['edit_id_sitio'];
    $nombre = $_POST['edit_nombre'] ?? '';
    $tipo = $_POST['edit_tipo'] ?? '';
    $direccion = $_POST['edit_direccion'] ?? '';
    $telefono = $_POST['edit_telefono'] ?? '';
    $imagen = $_POST['edit_imagenUrl'] ?? '';
    $ruta = $_POST['edit_ruta'] ?? '';
    $email = $_POST['edit_email'] ?? '';
    $latitud = $_POST['edit_latitud'] ?? '';
    $longitud = $_POST['edit_longitud'] ?? '';
    $descripcion = $_POST['edit_descripcion'] ?? '';
    $estado = isset($_POST['edit_estado']) ? 1 : 0;

    // Consulta para actualizar el sitio de interés
    $stmt = $_conexion->prepare("
        UPDATE sitiosInteres
        SET nombre = :nombre,
            tipo = :tipo,
            direccion = :direccion,
            telefono = :telefono,
            imagen = :imagen,
            ruta = :ruta,
            email = :email,
            latitud = :latitud,
            longitud = :longitud,
            descripcion = :descripcion,
            estado = :estado
        WHERE id_sitio = :id_sitio
    ");

    $stmt->execute([
        'nombre' => $nombre,
        'tipo' => $tipo,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'imagen' => $imagen,
        'ruta' => $ruta,
        'email' => $email,
        'latitud' => $latitud,
        'longitud' => $longitud,
        'descripcion' => $descripcion,
        'estado' => $estado,
        'id_sitio' => $id_sitio
    ]);

    // Redirección (podés cambiar la ruta según necesites)
    header('Location: ../pantallasitiosinteres.php');
    exit;
}
?>
