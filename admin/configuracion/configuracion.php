<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email']; 
    $password=$_POST['password']; 
    $passwordNuevo = $_POST['contrasenaNueva'] ?? '';

 
    
            // Si se proporciona una nueva contraseña, la hasheamos
            if (!empty($passwordNuevo) || !empty($password)) {
                $passwordHasheado = password_hash($passwordNuevo, PASSWORD_DEFAULT);

                $stmt = $_conexion->prepare(
                    "UPDATE administradores 
                     SET nombre = :nombre, email = :email, contrasena = :contrasena 
                     WHERE id = :id"
                );

                $stmt->execute([
                    'nombre' => $nombre,
                    'email' => $email,
                    'contrasena' => $passwordHasheado,
                    'id' => $id
                ]);
            } else {
                // Solo actualizamos nombre y email
                $stmt = $_conexion->prepare(
                    "UPDATE administradores 
                     SET nombre = :nombre, email = :email
                     WHERE id = :id"
                );

                $stmt->execute([
                    'nombre' => $nombre,
                    'email' => $email,
                    'id' => $id
                ]);
            }

            header('Location: ../panel-admin.php');
            exit;

        } 
   

?>
