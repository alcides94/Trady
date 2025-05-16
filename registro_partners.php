<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TRADY - Registro de Partner</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (iconos) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
       :root {
           --partner-primary: #2575fc;
           --partner-secondary: #6a11cb;
           --success-color: #00b09b;
       }
     
       body {
           background: linear-gradient(135deg, var(--partner-primary), var(--partner-secondary));
           min-height: 100vh;
           font-family: 'Arial', sans-serif;
           color: white;
       }
     
       .registration-card {
           background: rgba(255, 255, 255, 0.1);
           backdrop-filter: blur(10px);
           border-radius: 15px;
           border: 1px solid rgba(255, 255, 255, 0.2);
           box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
       }
     
       .form-control, .form-select {
           background: rgba(255, 255, 255, 0.1);
           border: 1px solid rgba(255, 255, 255, 0.2);
           color: white;
       }
     
       .form-control:focus, .form-select:focus {
           background: rgba(255, 255, 255, 0.2);
           color: white;
           border-color: rgba(255, 255, 255, 0.4);
           box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
       }
     
       .form-control::placeholder {
           color: rgba(255, 255, 255, 0.6);
       }
     
       .btn-main {
           background: linear-gradient(90deg, var(--success-color), #96c93d);
           border: none;
           border-radius: 50px;
           font-weight: bold;
           padding: 10px 25px;
           box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
           transition: transform 0.3s;
       }
     
       .btn-main:hover {
           transform: translateY(-3px);
       }
     
       .btn-outline-light {
           border-radius: 50px;
       }
     
       .plan-card {
           background: rgba(0, 0, 0, 0.2);
           border-radius: 10px;
           padding: 20px;
           margin-bottom: 15px;
           transition: all 0.3s;
           border: 2px solid transparent;
           cursor: pointer;
       }
     
       .plan-card:hover {
           transform: translateY(-5px);
       }
     
       .plan-card.active {
           border-color: var(--success-color);
           background: rgba(0, 176, 155, 0.1);
       }
     
       .plan-card.featured {
           position: relative;
           border-color: gold;
       }
     
       .featured-badge {
           position: absolute;
           top: -10px;
           right: 20px;
           background: gold;
           color: #1a1a2e;
           padding: 3px 15px;
           border-radius: 20px;
           font-size: 0.8rem;
           font-weight: bold;
       }
     
       .payment-method {
           display: flex;
           align-items: center;
           padding: 15px;
           background: rgba(255, 255, 255, 0.1);
           border-radius: 10px;
           margin-bottom: 15px;
           cursor: pointer;
           transition: all 0.3s;
           border: 2px solid transparent;
       }
     
       .payment-method:hover {
           background: rgba(255, 255, 255, 0.2);
       }
     
       .payment-method.active {
           border-color: var(--success-color);
       }
     
       .payment-icon {
           font-size: 2rem;
           margin-right: 15px;
           color: var(--success-color);
       }
     
       .required-field::after {
           content: " *";
           color: #ff6b6b;
       }
     
       .step-indicator {
           display: flex;
           justify-content: space-between;
           margin-bottom: 30px;
           position: relative;
       }
     
       .step-indicator::before {
           content: '';
           position: absolute;
           top: 15px;
           left: 0;
           right: 0;
           height: 2px;
           background: rgba(255, 255, 255, 0.2);
           z-index: 0;
       }
     
       .step {
           display: flex;
           flex-direction: column;
           align-items: center;
           z-index: 1;
       }
     
       .step-number {
           width: 30px;
           height: 30px;
           border-radius: 50%;
           background: rgba(255, 255, 255, 0.2);
           display: flex;
           align-items: center;
           justify-content: center;
           margin-bottom: 5px;
           font-weight: bold;
       }
     
       .step.active .step-number {
           background: var(--success-color);
       }
     
       .step.completed .step-number {
           background: var(--success-color);
       }
     
       .step.completed .step-number::after {
           content: "\f00c";
           font-family: "Font Awesome 6 Free";
           font-weight: 900;
       }
     
       .step-label {
           font-size: 0.8rem;
           opacity: 0.7;
       }
     
       .step.active .step-label {
           opacity: 1;
           font-weight: bold;
       }
     
       .form-section {
           display: none;
       }
     
       .form-section.active {
           display: block;
           animation: fadeIn 0.5s ease-out;
       }
     
       @keyframes fadeIn {
           from { opacity: 0; transform: translateY(20px); }
           to { opacity: 1; transform: translateY(0); }
       }
     
       .logo-container {
           text-align: center;
           margin-bottom: 30px;
       }
     
       .logo-container img {
           width: 150px;
           height: auto;
       }
     
       .terms-text {
           font-size: 0.8rem;
           opacity: 0.8;
       }
   </style>
</head>
<body>
   <?php
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
   require('./util/conexion.php');

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $nombre = $_POST["name"];
       $correo = $_POST["email"];
       $telefono = $_POST["phone"];
       $contrasena = $_POST["password"];
       $confir_contra = $_POST["confirm_password"];
       $fecha = $_POST["birthdate"];
       $id_suscripcion = $_POST["subscription_plan"];
       $business_name = $_POST["business_name"];
       $business_type = $_POST["business_type"];
       $business_address = $_POST["business_address"];
       $business_cif = $_POST["business_cif"];

       $cont = 0; // Contador de validaciones

       // Validación del nombre
       if (!preg_match("/^[a-zA-Z0-9 ]{3,16}$/", $nombre)) {
           echo "<h4>Nombre inválido. Debe contener solo letras y espacios (3-16 caracteres).</h4>";
       } else {
           $cont++;
       }

       // Validación de la contraseña
       if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,15}$/', $contrasena)) {
           echo "<h4>La contraseña debe tener entre 8 y 15 caracteres con letras y números</h4>";
       } else {
           $cont++;
       }

       // Confirmación de la contraseña
       if ($contrasena !== $confir_contra) {
           echo "<h4>Las contraseñas no coinciden</h4>";
       } else {
           $cont++;
       }

       // Validación del teléfono
       if (!preg_match('/^[0-9]{7,15}$/', $telefono)) {
           echo "<h4>Teléfono inválido. Debe tener entre 7 y 15 dígitos.</h4>";
       } else {
           $cont++;
       }

       // Validación de datos del negocio
       if (empty($business_name) || empty($business_type) || empty($business_address) || empty($business_cif)) {
           echo "<h4>Todos los campos del negocio son obligatorios</h4>";
       } else {
           $cont++;
       }

       // Si todas las validaciones pasaron
       if ($cont == 5) {
           $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

           $stmt = $_conexion->prepare("
               INSERT INTO partners (email, nombre, fecha_nac, password, telefono, id_suscripcion, 
                                    business_name, business_type, business_address, business_cif)
               VALUES (:email, :nombre, :fecha_nac, :password, :telefono, :id_suscripcion,
                       :business_name, :business_type, :business_address, :business_cif)
           ");
           
           $stmt->execute([
               "email" => $correo,
               "nombre" => $nombre,
               "fecha_nac" => $fecha,
               "password" => $contrasena_cifrada,
               "telefono" => $telefono,
               "id_suscripcion" => $id_suscripcion,
               "business_name" => $business_name,
               "business_type" => $business_type,
               "business_address" => $business_address,
               "business_cif" => $business_cif
           ]);
       }
   }
   ?>

   <div class="container py-5">
       <div class="row justify-content-center">
           <div class="col-lg-8">
               <div class="registration-card p-4 p-md-5">
                   <!-- Logo -->
                   <div class="logo-container">
                       <img src="trady_sinFondo.png" alt="TRADY Logo">
                       <h1 class="fw-bold mt-3">Registro de Partner</h1>
                       <p class="mb-4">Completa los datos de tu negocio</p>
                  