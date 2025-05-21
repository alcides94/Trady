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
    $imagen = !empty($_POST["imagen"]) ? $_POST["imagen"] : ''; // Validación que pediste
    $ruta = $_POST["ruta"] ?? '';
    $estado = $_POST["estado"];
    $id_suscripcion = $_POST["id_suscripcion"];
    $metodoPago = $_POST["metodoPago"] ?? '';
    $latitud = isset($_POST["latitud"]) ? floatval($_POST["latitud"]) : null;
    $longitud = isset($_POST["longitud"]) ? floatval($_POST["longitud"]) : null;

    $sql = "INSERT INTO comercios (
                nombre, descripcion, tipo, cif, direccion, telefono, email, imagen, ruta, latitud, estado, longitud, metodoPago, id_suscripcion
            ) VALUES (
                :nombre, :descripcion, :tipo, :cif, :direccion, :telefono, :email, :imagen, :ruta, :latitud, :estado, :longitud, :metodoPago, :id_suscripcion
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
        "ruta" => $ruta,
        "latitud" => $latitud !== '' ? $latitud : null,
        "estado" => $estado,
        "longitud" => $longitud !== '' ? $longitud : null,
        "metodoPago" => $metodoPago,
        "id_suscripcion" => $id_suscripcion
    ]);

    header('Location: ../pantallapartners.php');
    exit();
}
?>
