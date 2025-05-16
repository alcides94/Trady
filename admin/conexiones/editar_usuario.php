<?php
require('../../util/conexion.php');

// Habilitar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_usuario = $_POST['e_id_usuario'];
    $nombre = $_POST['e_nombre'] ?? '';
    $email = $_POST['e_email'] ?? '';
    $telefono = $_POST['e_telefono'] ?? '';
    $fecha_nac = $_POST['e_fecha_nac'] ?? null;
    $id_suscripcion = $_POST['e_id_suscripcion'] ?? 1;
    $password = $_POST['e_password'] ?? '';
    $confirm_password = $_POST['e_confirm_password'] ?? '';
    $estado = isset($_POST['e_estado']) ? 1 : 0;

    // Si el usuario quiere cambiar la contraseña
    if (!empty($password) && !empty($confirm_password)) {

        if ($password !== $confirm_password) {
            echo json_encode(["error" => "Las contraseñas no coinciden"]);
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $_conexion->prepare("
            UPDATE usuarios 
            SET nombre = :nombre,
                email = :email,
                telefono = :telefono,
                fecha_nac = :fecha_nac,
                id_suscripcion = :id_suscripcion,
                password = :password,
                estado = :estado
            WHERE id_usuario = :id_usuario
        ");

        $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'fecha_nac' => $fecha_nac,
            'id_suscripcion' => $id_suscripcion,
            'password' => $passwordHash,
            'estado' => $estado,
            'id_usuario' => $id_usuario
        ]);

    } else {
        // No se cambia la contraseña
        $stmt = $_conexion->prepare("
            UPDATE usuarios 
            SET nombre = :nombre,
                email = :email,
                telefono = :telefono,
                fecha_nac = :fecha_nac,
                id_suscripcion = :id_suscripcion,
                estado = :estado
            WHERE id_usuario = :id_usuario
        ");

        $stmt->execute([
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'fecha_nac' => $fecha_nac,
            'id_suscripcion' => $id_suscripcion,
            'estado' => $estado,
            'id_usuario' => $id_usuario
        ]);
    }

    // Si querés hacer redirección:
    header('Location: ../pantallausuarios.php');
    exit;

}
?>
