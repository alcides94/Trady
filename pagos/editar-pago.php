<?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        //para conectar con la base de datos
        require('../util/conexion.php');

        //averiguamos si está abierta la sesion
        session_start();
        if(!isset($_SESSION["usuario"])){
            $iniciado=false;//usaremos el booleano para indicar si la sesion esta iniciada o no
            header("Location: ../login.php");
            exit();
        }
        else{
            $iniciado=true;

            // Preparar consulta segura con PDO
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $_conexion->prepare($sql);
            $stmt->bindParam(':email', $_SESSION["usuario"]);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql2 = "SELECT * FROM suscripcion_usuarios";
            $stmt = $_conexion->prepare($sql2);
            $stmt->execute();
            $suscripciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $payment_method = $_POST["payment_method"];

     
            $stmt = $_conexion->prepare("
                    UPDATE usuarios SET 
                    metodo_pago = :metodo_pago
                    WHERE email = :email
                 ");
                 
            $stmt->execute([
                    "email" => $resultado["email"],
                    "metodo_pago" => $payment_method
                 ]);
     
            session_start();
                 
            $_SESSION["usuario"] = $resultado["email"];
                     
            $_SESSION["nombre_usuario"] = $resultado["nombre"];
                     
            // Redireccionar
            header("Location: ../usuarios/perfil-usuario.php");
            exit();
            
        }
    ?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Método de Pago - Trady</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --game-primary: #6a11cb;
            --game-secondary: #2575fc;
            --game-dark: #1a1a2e;
            --game-light: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, var(--game-primary), var(--game-secondary));
            color: white;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
        }

        .payment-container {
            max-width: 600px;
            margin: 2rem auto;
        }

        .payment-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
        }

        .btn-save {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
            font-weight: bold;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .nav-back {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .payment-icon {
            font-size: 2rem;
            margin-right: 15px;
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
            border-color: #00b09b;
            background: rgba(0, 176, 155, 0.1);
        }

        .required-field::after {
            content: " *";
            color: #ff6b6b;
        }
    </style>
</head>

<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i></i>TRADY
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3">Puntos: <strong><?php echo $resultado["puntos"]?></strong></span>
                <img src="https://via.placeholder.com/40" alt=": )" class="rounded-circle">
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container payment-container">
        <div class="payment-card">
            <div class="nav-back" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
            </div>
            
            <h2 class="mb-4"><i class="fas fa-credit-card me-2"></i>Editar Método de Pago</h2>
            
            <div class="form-section" id="step3">
                <h4 class="mb-4">Método de pago</h4>
              
                <form id="cambiometdopago" action="" method="POST">
                <div class="mb-4">
                    <div class="payment-method active" onclick="selectPaymentMethod(this, 'card')">
                        <i class="fab fa-cc-visa payment-icon"></i>
                        <div>
                            <h5 class="mb-1">Tarjeta de crédito/débito</h5>
                            <p class="small mb-0">Pago seguro con cifrado SSL</p>
                        </div>
                        <input type="radio" class="d-none" name="payment_method" value="card" checked>
                    </div>
                  
                    <div class="payment-method" onclick="selectPaymentMethod(this, 'paypal')">
                        <i class="fab fa-cc-paypal payment-icon"></i>
                        <div>
                            <h5 class="mb-1">PayPal</h5>
                            <p class="small mb-0">Paga con tu cuenta PayPal</p>
                        </div>
                        <input type="radio" class="d-none" name="payment_method" value="paypal">
                    </div>
                  
                    <div class="payment-method" onclick="selectPaymentMethod(this, 'bank')">
                        <i class="fas fa-university payment-icon"></i>
                        <div>
                            <h5 class="mb-1">Transferencia bancaria</h5>
                            <p class="small mb-0">Pago por transferencia (solo anual)</p>
                        </div>
                        <input type="radio" class="d-none" name="payment_method" value="bank">
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
                    <button type="button" class="btn btn-outline-light" onclick="window.history.back()">Cancelar</button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-check me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para los métodos de pago -->
    <script>
        function selectPaymentMethod(element, method) {
            // Remover clase 'active' de todos los métodos
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
            });
            
            // Añadir clase 'active' al método seleccionado
            element.classList.add('active');
            
            // Marcar el radio button correspondiente
            document.querySelector(`input[name="payment_method"][value="${method}"]`).checked = true;
        }
    </script>
</body>

</html>