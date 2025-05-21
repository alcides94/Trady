<?php
require('../../util/conexion.php');

// Habilitar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_comercios = $_POST['edit_id_comercios'];
    $nombre = $_POST['edit_nombre'] ?? '';
    $tipo = $_POST['edit_tipo'] ?? '';
    $cif = $_POST['edit_cif'] ?? '';
    $direccion = $_POST['edit_direccion'] ?? '';
    $metodoPago = $_POST['edit_metodoPago'] ?? '';
    $ruta = $_POST['edit_ruta'] ?? '';
    $telefono = $_POST['edit_telefono'] ?? '';
    $email = $_POST['edit_email'] ?? '';
    $id_suscripcion = $_POST['edit_id_suscripcion'] ?? '';
    $latitud = $_POST['edit_latitud'] ?? '';
    $longitud = $_POST['edit_longitud'] ?? '';
    $descripcion = $_POST['edit_descripcion'] ?? '';
    $estado = $_POST['edit_estado'];

    // Consulta para actualizar el sitio de interés
    $stmt = $_conexion->prepare("
        UPDATE comercios
        SET nombre = :nombre,
            tipo = :tipo,
            direccion = :direccion,
            ruta = :ruta,
            metodoPago = :metodoPago,
            telefono = :telefono,
            cif = :cif,
            email = :email,
            id_suscripcion = :id_suscripcion,
            latitud = :latitud,
            longitud = :longitud,
            descripcion = :descripcion,
            estado = :estado
        WHERE id_comercios = :id_comercios
    ");

    $stmt->execute([
        'nombre' => $nombre,
        'tipo' => $tipo,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'metodoPago' => $metodoPago,
        'ruta' => $ruta,
        'cif' => $cif,
        'email' => $email,
        'id_suscripcion' => $id_suscripcion,
        'latitud' => $latitud,
        'longitud' => $longitud,
        'descripcion' => $descripcion,
        'estado' => $estado,
        'id_comercios' => $id_comercios
    ]);

    // Redirección (podés cambiar la ruta según necesites)
    header('Location: ../pantallapartners.php');
    exit;
}
?>
