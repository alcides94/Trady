<?php
require('../../util/conexion.php');
error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $tipo = $_POST['edit_tipo'] ?? null;
    $id = $_POST['edit_id_suscripcion'] ?? null;
    $nombre = $_POST['edit_nombre'] ?? null;
    $precio = $_POST['edit_precio'] ?? null;

    // Determinar la tabla según el tipo
    if ($tipo === 'user') {
        $tabla = 'suscripcion_usuarios';
    } elseif ($tipo === 'partner') {
        $tabla = 'suscripcion_comercios';
    } else {
        die("Tipo de suscripción inválido.");
    }

    
        // Preparar consulta SQL
        $sql = "UPDATE $tabla SET nombre = :nombre, precio = :precio WHERE id_suscripcion = :id";
        $stmt = $_conexion->prepare($sql);

        $stmt->execute(
            [
                'nombre' => $nombre,
                'precio' =>  $precio,
                'id' => $id
            ]
            );

    // Redirección (podés cambiar la ruta según necesites)
    header("Location: ../pantallasuscripciones.php");
            exit;
        

} 

     

?>
