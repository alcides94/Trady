<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $latitud = isset($_POST["latitud"]) ? floatval($_POST["latitud"]) : null;
    $longitud = isset($_POST["longitud"]) ? floatval($_POST["longitud"]) : null;
    $id_qr = $_POST["id_qr"]; 

    $sql = "INSERT INTO sitiosInteres (
                nombre, descripcion, tipo, direccion, telefono, email, latitud, longitud, id_qr
            ) VALUES (
                :nombre, :descripcion, :tipo, :direccion, :telefono, :email, :latitud, :longitud, :id_qr
            )";

    $stmt = $_conexion->prepare($sql);

    $stmt->execute([
        "nombre" => $nombre,
        "descripcion" => $descripcion,
        "tipo" => $tipo,
        "direccion" => $direccion,
        "telefono" => $telefono,
        "email" => $email,
        "latitud" => $latitud !== '' ? $latitud : null,
        "longitud" => $longitud !== '' ? $longitud : null,
        "id_qr" => $id_qr !== '' ? $id_qr : null
    ]);

    // Opcional: redirigir o mostrar mensaje
    header('Location: ../pantallasitiosinteres.php');
    exit();
}
?>
