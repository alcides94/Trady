<?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 ); 
        
        //para conectar con la base de datos
        require('../util/conexion.php');

        //averiguamos si está abierta la sesion
        session_start();
        if(!isset($_SESSION["usuario"])){
            $iniciado=false;//usaremos el booleano para indicar si la sesion esta iniciada o no
            header("Location: login.php");
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
            
            $id_suscripcion = $_POST["subscription_plan"];

     
            $stmt = $_conexion->prepare("
                    UPDATE usuarios SET 
                    id_suscripcion = :id_suscripcion
                    WHERE email = :email
                 ");
                 
            $stmt->execute([
                    "email" => $resultado["email"],
                    "id_suscripcion" => $id_suscripcion
                 ]);
     
            session_start();
                 
            $_SESSION["usuario"] = $resultado["email"];
                     
            $_SESSION["nombre_usuario"] = $resultado["nombre"];
                     
            // Redireccionar
            header("Location: perfil-usuario.php");
            exit();
            
        }
    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady - Cambiar Suscripción</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Mismo estilo que el archivo original -->
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

        .game-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s;
        }

        .game-card:hover {
            transform: scale(1.03);
        }

        .btn-custom {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
            border-radius: 50px;
            font-weight: bold;
            padding: 10px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-custom-secondary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 50px;
            font-weight: bold;
            padding: 10px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .plan-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .plan-card.featured {
            border-color: gold;
            position: relative;
        }

        .featured-badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background: gold;
            color: #1a1a2e;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .plan-price {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 15px 0;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .plan-features li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features li i {
            margin-right: 10px;
            color: var(--game-primary);
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .comparison-table th, .comparison-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comparison-table th {
            font-weight: normal;
            color: rgba(255, 255, 255, 0.7);
        }

        .comparison-table td {
            font-weight: bold;
        }

        .comparison-table tr:last-child td {
            border-bottom: none;
        }

        .feature-available {
            color: #00c853;
        }

        .feature-unavailable {
            color: #ff3d00;
        }
        .plan-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .plan-card.active {
            border: 2px solid #00b09b !important;
            background: rgba(0, 176, 155, 0.1) !important;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .plan-card.featured {
            border: 2px solid gold;
        }

        .plan-card:hover:not(.active) {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- Barra de Navegación (igual que en el original) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i>TRADY
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3">Puntos: <strong><?php echo $resultado["puntos"]?></strong></span>
                <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="game-card p-4">
                    <!-- Botón de volver atrás -->
                    <a href="perfil-usuario.php" class="btn btn-sm btn-outline-light mb-4">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>

                    <h2 class="text-center mb-4"><i class="fas fa-crown me-2"></i>Elige tu Suscripción</h2>
                    <p class="text-center text-white mb-5">Selecciona el plan que mejor se adapte a tus necesidades como cazador de QR</p>
                    
                    <!-- Planes de suscripción -->
    <!-- -------------------------------------------------------------------------------------------- -->
    <form id="cambio_suscripcion" action="" method="POST">
        <a class="btn btn-sm btn-outline-light mb-4">
            <button type="submit" class="btn btn-save text-success">GUARDAR TIPO DE SUSCRIPCION</button>
        </a>
    <div class="form-section" id="payment_method_change">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="plan-card active" data-plan="free" onclick="selectPlan(this)">
                    <h5>Cobre</h5>
                    <h3 class="my-3"><?php echo $suscripciones[0]["nombre"]?></h3>
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
                <div class="plan-card featured" data-plan="premium" onclick="selectPlan(this)">
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
                <div class="plan-card" data-plan="annual" onclick="selectPlan(this)">
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
    </div>
    </form>


<script>
function selectPlan(selectedCard) {
    // Remover clase 'active' de todas las tarjetas
    document.querySelectorAll('.plan-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // Agregar clase 'active' a la tarjeta seleccionada
    selectedCard.classList.add('active');
    
    // Marcar el radio button correspondiente
    const radioInput = selectedCard.querySelector('input[type="radio"]');
    if (radioInput) {
        radioInput.checked = true;
    }
}

// Inicialización para manejar clicks en las tarjetas
document.querySelectorAll('.plan-card').forEach(card => {
    card.addEventListener('click', function() {
        selectPlan(this);
    });
});
</script>


    <!-- ---------------------------------------------------------------------------------------------------- -->

                    <!-- Comparación de planes -->
                    <div class="game-card p-4 mt-5">
                        <h4 class="text-center mb-4"><i class="fas fa-chart-bar me-2"></i>Comparación de Planes</h4>
                        
                        <div class="table-responsive">
                            <table class="comparison-table">
                                <tr>
                                    <th>Característica</th>
                                    <th>Básico</th>
                                    <th>Premium</th>
                                    <th>VIP</th>
                                </tr>
                                <tr>
                                    <td>Precio mensual</td>
                                    <td>$4.99</td>
                                    <td>$9.99</td>
                                    <td>$14.99</td>
                                </tr>
                                <tr>
                                    <td>Rutas simultáneas</td>
                                    <td>5</td>
                                    <td>Ilimitadas</td>
                                    <td>Ilimitadas</td>
                                </tr>
                                <tr>
                                    <td>Puntos bonus/mes</td>
                                    <td>100</td>
                                    <td>300</td>
                                    <td>500</td>
                                </tr>
                                <tr>
                                    <td>Acceso a rutas exclusivas</td>
                                    <td><i class="fas fa-times feature-unavailable"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                </tr>
                                <tr>
                                    <td>Estadísticas avanzadas</td>
                                    <td><i class="fas fa-times feature-unavailable"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                </tr>
                                <tr>
                                    <td>Desafíos exclusivos</td>
                                    <td><i class="fas fa-times feature-unavailable"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                </tr>
                                <tr>
                                    <td>Soporte prioritario</td>
                                    <td><i class="fas fa-times feature-unavailable"></i></td>
                                    <td><i class="fas fa-times feature-unavailable"></i></td>
                                    <td><i class="fas fa-check feature-available"></i></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Preguntas frecuentes -->
                    <div class="game-card p-4 mt-4">
                        <h4 class="text-center mb-4"><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</h4>
                        
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item bg-transparent border-0 mb-2">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        ¿Puedo cambiar de plan en cualquier momento?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Sí, puedes cambiar entre planes en cualquier momento. El cambio será efectivo en tu próximo ciclo de facturación.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item bg-transparent border-0 mb-2">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        ¿Hay un período de compromiso?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        No, todos nuestros planes son mensuales sin compromiso. Puedes cancelar en cualquier momento.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed bg-transparent text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        ¿Qué métodos de pago aceptan?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Aceptamos todas las tarjetas de crédito/débito principales (Visa, MasterCard, American Express) y PayPal.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-75 text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© 2025 Trady - ¡Encuentra, Escanea, Gana!</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para funcionalidad -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simular selección de plan
            const planButtons = document.querySelectorAll('.plan-card .btn:not(.btn-custom)');
            
            planButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const planName = this.closest('.plan-card').querySelector('h4').textContent;
                    
                    // Simular cambio de plan
                    alert(`¡Has seleccionado el plan ${planName}! Serás redirigido para confirmar el cambio.`);
                    
                    // Aquí iría la lógica real para cambiar de plan
                    // window.location.href = 'confirmar-cambio.html?plan=' + encodeURIComponent(planName);
                });
            });
        });
    </script>
</body>

</html>