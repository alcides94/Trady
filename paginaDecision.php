<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TRADY - Registro Completo</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (iconos) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
       :root {
           --game-primary: #6a11cb;
           --game-secondary: #2575fc;
           --game-dark: #1a1a2e;
           --partner-primary: #2575fc;
           --partner-secondary: #6a11cb;
           --success-color: #00b09b;
       }
     
       body {
           background: linear-gradient(135deg, var(--game-primary), var(--game-secondary));
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
     
       .user-type-card {
           cursor: pointer;
           transition: all 0.3s;
           border: 2px solid transparent;
           border-radius: 10px;
           padding: 20px;
           text-align: center;
       }
     
       .user-type-card:hover {
           transform: translateY(-5px);
       }
     
       .user-type-card.active {
           border-color: white;
           background: rgba(255, 255, 255, 0.2);
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
           color: var(--game-dark);
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


<?php
   error_reporting( E_ALL );
   ini_set( "display_errors", 1 );
   ?>
</head>
<body>
     
<form id="registrationForm" action="" method="POST">
   <!-- Paso 1: Tipo de usuario -->
   <div class="form-section active" id="step1">
       <h4 class="mb-4">¿Qué tipo de cuenta deseas crear?</h4>
       <div class="row">
           <div class="col-md-6 mb-4">
               <div class="user-type-card active" id="userTypeClient" onclick="selectUserType('client')">
                   <i class="fas fa-user fa-3x mb-3"></i>
                   <h5>Usuario Cliente</h5>
                   <p class="small">Perfecto para explorar, escanear QR y ganar recompensas</p>
               </div>
           </div>
           <div class="col-md-6 mb-4">
               <div class="user-type-card" id="userTypePartner" onclick="selectUserType('partner')">
                   <i class="fas fa-store fa-3x mb-3"></i>
                   <h5>Usuario Partner</h5>
                   <p class="small">Para negocios que quieran promocionarse y crear QR</p>
               </div>
           </div>
       </div>


       <!-- Campo oculto para almacenar selección -->
       <input type="hidden" id="selectedUserType" name="user_type" value="client">


       <div class="d-flex justify-content-end">
           <button type="button" class="btn btn-main next-step" onclick="goToNext()">Siguiente</button>
       </div>
   </div>
</form>

<script>
   let selected = "client";


   function selectUserType(type) {
       selected = type;
       document.getElementById('selectedUserType').value = type;


       // Activar visualmente la tarjeta seleccionada
       document.getElementById('userTypeClient').classList.remove('active');
       document.getElementById('userTypePartner').classList.remove('active');


       if (type === "client") {
           document.getElementById('userTypeClient').classList.add('active');
       } else {
           document.getElementById('userTypePartner').classList.add('active');
       }
   }


   function goToNext() {
       if (selected === "client") {
           window.location.href = "./usuarios/registro_usuarios.php";
       } else if (selected === "partner") {
           window.location.href = "registro_parners.php";
       }
   }
</script>
                                   
</body>
</html>