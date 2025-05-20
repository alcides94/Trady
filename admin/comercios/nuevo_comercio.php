<?php 

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $cif = $_POST["cif"];
    $tipo = $_POST["tipo"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $imagen = $_POST["imagen"] ?? '';
    $estado = $_POST["estado"] ;
    $id_suscripcion = $_POST["id_suscripcion"];
    $metodoPago = $_POST["metodoPago"] ?? '';
    $latitud = isset($_POST["latitud"]) ? floatval($_POST["latitud"]) : null;
    $longitud = isset($_POST["longitud"]) ? floatval($_POST["longitud"]) : null;

    $sql = "INSERT INTO comercios (
                nombre, descripcion, tipo, cif, direccion, telefono, email,imagen, latitud, estado, longitud, metodoPago,  id_suscripcion
            ) VALUES (
                :nombre, :descripcion, :tipo, :cif, :direccion, :telefono, :email, :imagen, :latitud, :estado, :longitud, :metodoPago, :id_suscripcion
            )";

    $stmt = $_conexion->prepare($sql);

    $stmt->execute([
        "nombre" => $nombre,
        "descripcion" => $descripcion,
        "tipo" => $tipo,
        "cif" => $cif,
        "direccion" => $direccion,
        "telefono" => $telefono,
        "email" => $email,
        "imagen" => $imagen,
        "estado" => $estado,
        "id_suscripcion" => $id_suscripcion,
        "metodoPago" => $metodoPago,
        "latitud" => $latitud !== '' ? $latitud : null,
        "longitud" => $longitud !== '' ? $longitud : null
    ]);

    // Opcional: redirigir o mostrar mensaje
    header('Location: ../pantallapartners.php');
    exit();
}
?>
