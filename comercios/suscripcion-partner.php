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
            $sql = "SELECT * FROM comercios WHERE email = :email";
            $stmt = $_conexion->prepare($sql);
            $stmt->bindParam(':email', $_SESSION["usuario"]);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql2 = "SELECT * FROM suscripcion_comercios";
            $stmt = $_conexion->prepare($sql2);
            $stmt->execute();
            $suscripciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql3 = "SELECT * FROM suscripcion_comercios WHERE id_suscripcion = :id_suscripcion";
            $stmt = $_conexion->prepare($sql3);
            $stmt->bindParam(':id_suscripcion', $resultado["id_suscripcion"]);
            $stmt->execute();
            $suscripcion = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $id_suscripcion = $_POST["subscription_plan"];

     
            $stmt = $_conexion->prepare("
                    UPDATE comercios SET 
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

            $_SESSION["partner"] = true;
                     
            // Redireccionar
            header("Location: perfil-partner.php");
            exit();
            
        }
    ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trady - Planes para Partners</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .plan-card {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      padding: 20px;
      height: 100%;
      transition: all 0.3s;
      border: 2px solid transparent;
      cursor: pointer;
    }
    .plan-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .plan-card.active {
      border-color: #00b09b;
      background: rgba(0, 176, 155, 0.1);
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
    /* Estilos para los radio buttons personalizados */
    .plan-radio {
      position: absolute;
      opacity: 0;
    }
    .plan-radio:checked + .plan-card {
      border-color: #00b09b;
      background: rgba(0, 176, 155, 0.1);
    }
  </style>
</head>
<body>
  <!-- Barra de Navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i>TRADY PARTNERS
        </a>
        <div class="d-flex align-items-center">
            <span class="me-3">Nivel: <strong>Partner <?php echo $suscripcion["nombre"]?></strong></span>
            <img src="https://via.placeholder.com/40" alt=": )" class="rounded-circle">
        </div>
    </div>
  </nav>

  <div class="container my-5">
    <div class="game-card p-4">
      <a href="perfil-partner.php" class="btn btn-sm btn-outline-light mb-4">
        <i class="fas fa-arrow-left me-1"></i> Volver
      </a>
      <h2 class="text-center mb-4"><i class="fas fa-handshake me-2"></i>Planes para Partners</h2>
      <p class="text-center text-white mb-5">Selecciona el plan que mejor se adapte a tu negocio</p>
      
      <!-- Formulario de planes -->
      <form id="cambio_suscripcion" action="" method="POST">
        <div class="row">
          <!-- Plan 1 -->
          <div class="col-md-4 mb-4">
            <label class="plan-option">
              <input type="radio" name="subscription_plan" value="1" class="plan-radio" <?php echo ($resultado['id_suscripcion'] == 1) ? 'checked' : ''; ?>>
              <div class="plan-card <?php echo ($resultado['id_suscripcion'] == 1) ? 'active' : ''; ?>">
                <h5>Partner <?php echo $suscripciones[0]["nombre"]?></h5>
                <h3 class="my-3">€<?php echo $suscripciones[0]["precio"]?>/mes</h3>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fas fa-check me-2"></i> 1 código QR cada dos meses</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Estadísticas básicas</li>
                  <li class="mb-2"><i class="fas fa-times me-2 text-muted"></i> Sin campañas promocionales</li>
                </ul>
              </div>
            </label>
          </div>
          
          <!-- Plan 2 (Recomendado) -->
          <div class="col-md-4 mb-4">
            <label class="plan-option">
              <input type="radio" name="subscription_plan" value="2" class="plan-radio" <?php echo ($resultado['id_suscripcion'] == 2) ? 'checked' : ''; ?>>
              <div class="plan-card featured <?php echo ($resultado['id_suscripcion'] == 2) ? 'active' : ''; ?>">
                <span class="featured-badge">Recomendado</span>
                <h5>Partner <?php echo $suscripciones[1]["nombre"]?></h5>
                <h3 class="my-3">€<?php echo $suscripciones[1]["precio"]?>/mes</h3>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fas fa-check me-2"></i> 1 código QR al mes</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Estadísticas avanzadas</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Posicionamiento destacado</li>
                </ul>
              </div>
            </label>
          </div>
          
          <!-- Plan 3 -->
          <div class="col-md-4 mb-4">
            <label class="plan-option">
              <input type="radio" name="subscription_plan" value="3" class="plan-radio" <?php echo ($resultado['id_suscripcion'] == 3) ? 'checked' : ''; ?>>
              <div class="plan-card <?php echo ($resultado['id_suscripcion'] == 3) ? 'active' : ''; ?>">
                <h5>Partner <?php echo $suscripciones[2]["nombre"]?></h5>
                <h3 class="my-3">€<?php echo $suscripciones[2]["precio"]?>/mes</h3>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fas fa-check me-2"></i> 1 código QR cada semana</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Analíticas completas</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Posicionamiento muy destacado</li>
                  <li class="mb-2"><i class="fas fa-check me-2"></i> Soporte prioritario 24/7</li>
                </ul>
              </div>
            </label>
          </div>
        </div>
        
        <div class="text-center mt-4">
          <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-save me-2"></i> Guardar Cambios
          </button>
        </div>
      </form>

      <!-- Resto del contenido (tabla comparativa y FAQ) -->
      <!-- ... (mantener igual que en tu código original) ... -->
      
    </div>
  </div>

  <footer class="bg-dark bg-opacity-75 text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0">© 2025 Trady - Herramientas para crecer tu negocio</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Selección de planes al hacer clic en las tarjetas
    document.querySelectorAll('.plan-card').forEach(card => {
      card.addEventListener('click', function() {
        // Encuentra el radio button asociado y lo marca
        const radio = this.closest('.plan-option').querySelector('.plan-radio');
        radio.checked = true;
        
        // Actualiza las clases activas
        document.querySelectorAll('.plan-card').forEach(c => {
          c.classList.remove('active');
        });
        this.classList.add('active');
      });
    });
  </script>
</body>
</html>
