<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../util/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tipo = $_POST['tipo'];
        $identificador = $_POST['identificador_qr'];
        $nombre = $_POST['nombre']; // Asegúrate de enviarlo desde JS
        $puntos = $_POST['puntos'];
        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="."TRADY-" . $identificador;
        $id_comercio = $_POST["id_comercio"] ?? null;
        $id_sitio =$_POST["id_sitio"] ?? null;

        $stmt = $_conexion->prepare("INSERT INTO qr_codigos (tipo, qr, nombre, identificador_qr, puntos, id_comercio, id_sitio) VALUES (:tipo, :qr, :nombre, :identificador_qr, :puntos, :id_comercio, :id_sitio)");
        
        $stmt->execute([
            "tipo" => $tipo,
            "qr" => $qr_url,
            "nombre" => $nombre,
            "identificador_qr" => "TRADY". $identificador,
            "puntos" => $puntos,
            "id_comercio" => $id_comercio,
            "id_sitio" => $id_sitio
        ]);

        echo json_encode(['status' => 'ok']);
        header('Location: ../pantallacodigosqr.php');
        exit();
    
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>


