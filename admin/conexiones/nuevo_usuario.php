<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $nombre = $_POST["nombre"];
    $fecha_nac = $_POST["fecha_nac"];
    $contrasena = $_POST["password"];
    $metodoPago = $_POST["metodoPago"];
    $id_suscripcion = $_POST["id_suscripcion"];
    $telefono = $_POST["telefono"];

    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);


    $sql = "INSERT INTO usuarios (email, nombre, fecha_nac, password, metodoPago, id_suscripcion, telefono) 
            VALUES(:email, :nombre, :fecha_nac, :password, :metodoPago, :id_suscripcion, :telefono)";
    
    $stmt = $_conexion->prepare($sql);

    $stmt->execute([
        "email" => $email,
        "nombre" => $nombre,
        "fecha_nac" => $fecha_nac,
        "password" => $contrasena,
        "metodoPago" => $metodoPago,
        "id_suscripcion" => $id_suscripcion,
        "telefono" => $telefono
    ]);

    // Opcional: redirigir o mostrar mensaje
    header('Location: ../pantallausuarios.php');
    
}
?>
