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
    $imagen = $_POST["imagenUrl"] ?? '';
    $ruta = $_POST["ruta"] ?? '';
    $estado = isset($_POST["estado"]) ? 1 : 0;
    $latitud = isset($_POST["latitud"]) ? floatval($_POST["latitud"]) : null;
    $longitud = isset($_POST["longitud"]) ? floatval($_POST["longitud"]) : null;

    $sql = "INSERT INTO sitiosInteres (
                nombre, descripcion, tipo, direccion, estado, ruta, imagen, telefono, email, latitud, longitud
            ) VALUES (
                :nombre, :descripcion, :tipo, :direccion, :estado, :ruta, :imagen, :telefono, :email, :latitud, :longitud
            )";

    $stmt = $_conexion->prepare($sql);

    $stmt->execute([
        "nombre" => $nombre,
        "descripcion" => $descripcion,
        "tipo" => $tipo,
        "direccion" => $direccion,
        "imagen" => $imagen,
        "ruta" => $ruta,
        "estado" => $estado,
        "telefono" => $telefono,
        "email" => $email,
        "latitud" => $latitud !== '' ? $latitud : null,
        "longitud" => $longitud !== '' ? $longitud : null
    ]);

    // Opcional: redirigir o mostrar mensaje
    header('Location: ../pantallasitiosinteres.php');
    exit();
}
?>
