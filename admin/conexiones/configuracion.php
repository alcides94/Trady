<?php
session_start();
error_reporting( E_ALL );
ini_set( "display_errors", 1 );
require('../../util/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['adminNombre'] ?? '';
    $email = $_SESSION['usuario']; // Ya que el campo email está deshabilitado

    if (!empty($nombre) && !empty($email)) {
        try {
            $stmt = $_conexion->prepare("UPDATE administradores SET nombre = :nombre WHERE email = :email");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header('Location: ../panel-admin.php');
            exit;
        } catch (PDOException $e) {
            echo "Error al actualizar: " . $e->getMessage();
        }
    } else {
        echo "Faltan datos obligatorios.";
    }
} else {
    echo "Acceso inválido.";
}
?>