<?php
require('../../util/conexion.php'); // ajustá la ruta si es necesario

// Mostrar errores en desarrollo
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Verificamos si llegan los datos esperados por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipo = $_POST['tipo'];


    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';

    // Validamos que no estén vacíos
    if ($tipo=="user") {
       
            $stmt = $_conexion->prepare(
                "INSERT INTO suscripcion_usuarios (nombre, precio) 
                 VALUES (:nombre, :precio)"
            );
            $stmt->execute([
                'nombre' => $nombre,
                'precio' => $precio
            ]);

            // Redirigir o devolver mensaje JSON si usás AJAX
            header("Location: ../pantallasuscripciones.php");
            exit;
        
    } else {
        $stmt = $_conexion->prepare(
            "INSERT INTO suscripcion_comercios (nombre, precio) 
             VALUES (:nombre, :precio)"
        );
        $stmt->execute([
            'nombre' => $nombre,
            'precio' => $precio
        ]);

        // Redirigir o devolver mensaje JSON si usás AJAX
        header("Location: ../pantallasuscripciones.php");
        exit;
    
    }

}
?>
