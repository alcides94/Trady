<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: application/json'); // <--- importante

require('../../util/conexion.php');

if (isset($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];

    try {
        $stmt = $_conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(["id_usuario" => $id]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(["error" => "Usuario no encontrado"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Falta el parámetro id_usuario"]);
}
?>
