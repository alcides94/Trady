
<?php
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
   require('../util/conexion.php');

   $sql2 = "SELECT * FROM suscripcion_usuarios";
   $stmt = $_conexion->prepare($sql2);
   $stmt->execute();
   $suscripciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $nombre = $_POST["name"];
       $correo = $_POST["email"];
       $telefono = $_POST["phone"];
       $contrasena = $_POST["password"];
       $confir_contra = $_POST["confirm_password"];
       $fecha = $_POST["birthdate"];
       $id_suscripcion = $_POST["subscription_plan"];
       $payment_method=$_POST["payment_method"];

       $cont = 0; // Contador de validaciones

       // Validación del nombre
       if (!preg_match("/^[a-zA-Z0-9 ]{3,16}$/", $nombre)) {
           echo "<h4>Nombre inválido. Debe contener solo letras y/o numeros (3-16 caracteres).</h4>";
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

       // Si todas las validaciones pasaron
       if ($cont == 4) {
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

            $stmt = $_conexion->prepare("
                INSERT INTO usuarios (email, nombre, fecha_nac, password, telefono, id_suscripcion, metodo_pago)
                VALUES (:email, :nombre, :fecha_nac, :password, :telefono, :id_suscripcion, :metodo_pago)
            ");
            
            $stmt->execute([
                "email" => $correo,
                "nombre" => $nombre,
                "fecha_nac" => $fecha,
                "password" => $contrasena_cifrada,
                "telefono" => $telefono, 
                "id_suscripcion" => $id_suscripcion,
                "metodo_pago" => $payment_method
            ]);

            session_start();
            
            $_SESSION["usuario"] = $correo;
                
            $_SESSION["nombre_usuario"] = $nombre;
                
            // Redireccionar
            header("Location: perfil-usuario.php");
            exit();
       }
   }
   ?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TRADY - Registro de Usuario</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (iconos) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
       :root {
           --game-primary: #6a11cb;
           --game-secondary: #2575fc;
           --game-dark: #1a1a2e;
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
</head>
<body>

   <div class="container py-5">
       <div class="row justify-content-center">
           <div class="col-lg-8">
               <div class="registration-card p-4 p-md-5">
                   <!-- Logo -->
                   <div class="logo-container">
                       <img src="../util/img/trady_sinFondo.png" alt="TRADY Logo">
                       <h1 class="fw-bold mt-3">Registro de Usuario</h1>
                       <p class="mb-4">Completa tus datos para comenzar la aventura</p>
                   </div>
                 
                   <!-- Indicador de pasos -->
                   <div class="step-indicator">
                       <div class="step active" data-step="1">
                           <div class="step-number">1</div>
                           <div class="step-label">Datos personales</div>
                       </div>
                       <div class="step" data-step="2">
                           <div class="step-number">2</div>
                           <div class="step-label">Suscripción</div>
                       </div>
                       <div class="step" data-step="3">
                           <div class="step-number">3</div>
                           <div class="step-label">Pago</div>
                       </div>
                   </div>
                 
                   <!-- Formulario de registro -->
                   <form id="registrationForm" action="" method="POST">
                       <!-- Paso 1: Datos personales -->
                       <div class="form-section active" id="step1">
                           <h4 class="mb-4">Tus datos personales</h4>
                         
                           <div class="row">
                               <div class="col-md-6 mb-3">
                                   <label for="name" class="form-label required-field">Nombre</label>
                                   <input type="text" class="form-control" id="name" name="name" required>
                               </div>
                               <div class="col-md-6 mb-3">
                                   <label for="email" class="form-label required-field">Email</label>
                                   <input type="email" class="form-control" id="email" name="email" required>
                               </div>
                           </div>
                         
                           <div class="row">
                               <div class="col-md-6 mb-3">
                                   <label for="password" class="form-label required-field">Contraseña</label>
                                   <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                   <small class="form-text">Mínimo 8 caracteres</small>
                               </div>
                               <div class="col-md-6 mb-3">
                                   <label for="confirm_password" class="form-label required-field">Confirmar contraseña</label>
                                   <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                               </div>
                           </div>
                         
                           <div class="row">
                               <div class="col-md-6 mb-3">
                                   <label for="phone" class="form-label required-field">Teléfono</label>
                                   <input type="tel" class="form-control" id="phone" name="phone" required>
                               </div>
                               <div class="col-md-6 mb-3">
                                   <label for="birthdate" class="form-label required-field">Fecha de nacimiento</label>
                                   <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                               </div>
                           </div>
                         
                           <div class="d-flex justify-content-end mt-4">
                               <button type="button" class="btn btn-main next-step" data-next="2">Siguiente</button>
                           </div>
                       </div>
                     
                       <!-- Paso 2: Suscripción -->
                       <div class="form-section" id="step2">
                           <h4 class="mb-4">Elige tu plan de suscripción</h4>
                         
                           <div class="row">
                               <div class="col-md-4 mb-4">
                                   <div class="plan-card active" data-plan="free">
                                       <h5><?php echo $suscripciones[0]["nombre"]?></h5>
                                       <h3 class="my-3">€<?php echo $suscripciones[0]["precio"]?></h3>
                                       <ul class="list-unstyled">
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Acceso a rutas básicas</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> 5 escaneos diarios</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Recompensas estándar</li>
                                           <li class="mb-2"><i class="fas fa-times me-2 text-muted"></i> Sin estadísticas avanzadas</li>
                                       </ul>
                                       <input type="radio" class="d-none" name="subscription_plan" value="1" checked>
                                   </div>
                               </div>
                               <div class="col-md-4 mb-4">
                                   <div class="plan-card featured" data-plan="premium">
                                       <span class="featured-badge">Recomendado</span>
                                       <h5><?php echo $suscripciones[1]["nombre"]?></h5>
                                       <h3 class="my-3">€<?php echo $suscripciones[1]["precio"]?>/mes</h3>
                                       <ul class="list-unstyled">
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Todas las rutas premium</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Escaneos ilimitados</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Recompensas exclusivas</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Estadísticas avanzadas</li>
                                       </ul>
                                       <input type="radio" class="d-none" name="subscription_plan" value="2">
                                   </div>
                               </div>
                               <div class="col-md-4 mb-4">
                                   <div class="plan-card" data-plan="annual">
                                       <h5><?php echo $suscripciones[2]["nombre"]?></h5>
                                       <h3 class="my-3">€<?php echo $suscripciones[2]["precio"]?>/mes</h3>
                                       <ul class="list-unstyled">
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Todas las ventajas Premium</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Soporte prioritario</li>
                                           <li class="mb-2"><i class="fas fa-check me-2"></i> Descuentos exclusivos</li>
                                       </ul>
                                       <input type="radio" class="d-none" name="subscription_plan" value="3">
                                   </div>
                               </div>
                           </div>
                         
                           <div class="d-flex justify-content-between mt-4">
                               <button type="button" class="btn btn-outline-light prev-step" data-prev="1">Anterior</button>
                               <button type="button" class="btn btn-main next-step" data-next="3">Siguiente</button>
                           </div>
                       </div>
                     
                       <!-- Paso 3: Método de pago -->
                       <div class="form-section" id="step3">
                           <h4 class="mb-4">Método de pago</h4>
                         
                           <div class="mb-4">
                               <div class="payment-method active" id="paymentCard">
                                   <i class="fab fa-cc-visa payment-icon"></i>
                                   <div>
                                       <h5 class="mb-1">Tarjeta de crédito/débito</h5>
                                       <p class="small mb-0">Pago seguro con cifrado SSL</p>
                                   </div>
                                   <input type="radio" class="d-none" name="payment_method" value="card" checked>
                               </div>
                             
                               <div class="payment-method" id="paymentPaypal">
                                   <i class="fab fa-cc-paypal payment-icon"></i>
                                   <div>
                                       <h5 class="mb-1">PayPal</h5>
                                       <p class="small mb-0">Paga con tu cuenta PayPal</p>
                                   </div>
                                   <input type="radio" class="d-none" name="payment_method" value="paypal">
                               </div>
                             
                               <div class="payment-method" id="paymentBank">
                                   <i class="fas fa-university payment-icon"></i>
                                   <div>
                                       <h5 class="mb-1">Transferencia bancaria</h5>
                                       <p class="small mb-0">Pago por transferencia (solo anual)</p>
                                   </div>
                                   <input type="radio" class="d-none" name="payment_method" value="bank">
                               </div>
                           </div>
                         
                           <!-- Formulario de tarjeta -->
                           <div id="cardForm">
                               <div class="row">
                                   <div class="col-md-6 mb-3">
                                       <label for="card_number" class="form-label required-field">Número de tarjeta</label>
                                       <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                   </div>
                                   <div class="col-md-3 mb-3">
                                       <label for="card_expiry" class="form-label required-field">Caducidad</label>
                                       <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/AA">
                                   </div>
                                   <div class="col-md-3 mb-3">
                                       <label for="card_cvv" class="form-label required-field">CVV</label>
                                       <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="123">
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-12 mb-3">
                                       <label for="card_name" class="form-label required-field">Nombre en la tarjeta</label>
                                       <input type="text" class="form-control" id="card_name" name="card_name">
                                   </div>
                               </div>
                           </div>
                         
                           <!-- Términos y condiciones -->
                           <div class="form-check mb-4">
                               <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                               <label class="form-check-label" for="terms">
                                   Acepto los <a href="#" class="text-white">Términos y Condiciones</a> y la <a href="#" class="text-white">Política de Privacidad</a>
                               </label>
                           </div>
                         
                           <div class="d-flex justify-content-between mt-4">
                               <button type="button" class="btn btn-outline-light prev-step" data-prev="2">Anterior</button>
                               
                               <button type="submit" class="btn btn-main">
                                   <i class="fas fa-check me-2"></i>Completar Registro
                               </button>
                                
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>

   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
   <!-- Script para el formulario -->
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Manejar selección de planes
           const planCards = document.querySelectorAll('.plan-card');
           planCards.forEach(card => {
               card.addEventListener('click', function() {
                   planCards.forEach(c => c.classList.remove('active'));
                   this.classList.add('active');
                   const radio = this.querySelector('input[type="radio"]');
                   if (radio) radio.checked = true;
               });
           });
         
           // Manejar selección de método de pago
           const paymentMethods = document.querySelectorAll('.payment-method');
           paymentMethods.forEach(method => {
               method.addEventListener('click', function() {
                   paymentMethods.forEach(m => m.classList.remove('active'));
                   this.classList.add('active');
                   const radio = this.querySelector('input[type="radio"]');
                   if (radio) radio.checked = true;
                 
                   if (this.id === 'paymentCard') {
                       document.getElementById('cardForm').style.display = 'block';
                   } else {
                       document.getElementById('cardForm').style.display = 'none';
                   }
               });
           });
         
           // Navegación entre pasos
           const steps = document.querySelectorAll('.step');
           const formSections = document.querySelectorAll('.form-section');
           const nextButtons = document.querySelectorAll('.next-step');
           const prevButtons = document.querySelectorAll('.prev-step');
         
           nextButtons.forEach(button => {
               button.addEventListener('click', function() {
                   const currentStep = document.querySelector('.form-section.active');
                   const nextStepId = this.getAttribute('data-next');
                 
                   if (nextStepId === '2') {
                       const requiredFields = currentStep.querySelectorAll('[required]');
                       let isValid = true;
                     
                       requiredFields.forEach(field => {
                           if (!field.value) {
                               field.classList.add('is-invalid');
                               isValid = false;
                           } else {
                               field.classList.remove('is-invalid');
                           }
                       });
                     
                       const password = document.getElementById('password');
                       const confirmPassword = document.getElementById('confirm_password');
                     
                       if (password.value !== confirmPassword.value) {
                           confirmPassword.classList.add('is-invalid');
                           isValid = false;
                       } else {
                           confirmPassword.classList.remove('is-invalid');
                       }
                     
                       if (!isValid) return;
                   }
                 
                   currentStep.classList.remove('active');
                   document.getElementById('step' + nextStepId).classList.add('active');
                 
                   steps.forEach(step => {
                       if (parseInt(step.getAttribute('data-step')) < parseInt(nextStepId)) {
                           step.classList.add('completed');
                           step.classList.remove('active');
                       } else if (parseInt(step.getAttribute('data-step')) === parseInt(nextStepId)) {
                           step.classList.add('active');
                           step.classList.remove('completed');
                       } else {
                           step.classList.remove('active', 'completed');
                       }
                   });
               });
           });
         
           prevButtons.forEach(button => {
               button.addEventListener('click', function() {
                   const currentStep = document.querySelector('.form-section.active');
                   const prevStepId = this.getAttribute('data-prev');
                 
                   currentStep.classList.remove('active');
                   document.getElementById('step' + prevStepId).classList.add('active');
                 
                   steps.forEach(step => {
                       if (parseInt(step.getAttribute('data-step')) === parseInt(prevStepId)) {
                           step.classList.add('active');
                           step.classList.remove('completed');
                       } else if (parseInt(step.getAttribute('data-step')) > parseInt(prevStepId)) {
                           step.classList.remove('active', 'completed');
                       }
                   });
               });
           });
         
           document.querySelectorAll('[required]').forEach(field => {
               field.addEventListener('input', function() {
                   if (this.value) {
                       this.classList.remove('is-invalid');
                   }
               });
           });
         
           document.getElementById('confirm_password').addEventListener('input', function() {
               const password = document.getElementById('password');
               if (this.value !== password.value) {
                   this.classList.add('is-invalid');
               } else {
                   this.classList.remove('is-invalid');
               }
           });
       });
   </script>
   <?php 
   
   
   ?>
</body>
</html>