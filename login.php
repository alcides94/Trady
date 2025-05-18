
<?php
    /**CODIGO DE ERROR */
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 );
        require('./util/conexion.php');
?>

<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Preparar consulta segura con PDO para los usuarios
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $_conexion->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $partner=false;

            if (!$resultado) {
                // Preparar consulta segura con PDO
                $sql = "SELECT * FROM comercios WHERE email = :email";
                $stmt = $_conexion->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $partner=true;
            }

            if (!$resultado) {
                echo "El email no existe";
            } else {
                if (!password_verify($password, $resultado["password"])) {
                    echo "Contraseña errónea";
                } else {
                    if(!$partner){
                        session_start();
                        $_SESSION["usuario"] = $email;
                        $_SESSION["nombre_usuario"]=$resultado["nombre"];
                        header("location: ./usuarios/perfil-usuario.php");
                        exit;
                    }else{
                        session_start();
                        $_SESSION["usuario"] = $email;
                        $_SESSION["nombre_usuario"]=$resultado["nombre"];
                        $_SESSION["partner"]=true;
                        header("location: ./comercios/perfil-partner.php");
                        exit;
                    }
                    
                }
            }
        }
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRADY - Inicia Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --game-primary: #6a11cb;
            --game-secondary: #2575fc;
            --game-dark: #1a1a2e;
        }
        body {
            background: linear-gradient(135deg, var(--game-primary), var(--game-secondary));
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .game-login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .game-btn {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
            border-radius: 50px;
            font-weight: bold;
            padding: 10px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .game-btn:hover {
            transform: translateY(-3px);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }
        .qr-icon {
            font-size: 5rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    
</head>
<body>
    
    <div class="container d-flex align-items-center justify-content-center h-100">
        <div class="game-login-card p-4 p-md-5 text-white" style="width: 100%; max-width: 500px;">
            <!-- Logo y Título -->
            <div class="text-center mb-4">
                <i class="qr-icon"><img src="util/img/trady_sinFondo.png" alt="logo trady" width="300" height="300"></i>
                <h1 class="fw-bold">TRADY</h1>
                <p class="mb-4">¡Encuentra, Escanea, Gana!</p>
            </div>

            <!-- Pestañas Login/Registro -->
            <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-white" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab">Iniciar Sesión</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-white" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab">Registrarse</button>
                </li>
            </ul>

            <!-- Contenido de las Pestañas -->
            <div class="tab-content" id="pills-tabContent">
                <!-- Login -->
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="login-email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="login-password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="login-password" name="password" required>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn game-btn">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar
                            </button>
                        </div>
                        <div class="text-center">
                            <a href="#" class="text-white">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                </div>

                <!-- Registro -->
                <div class="tab-pane fade" id="pills-register" role="tabpanel">
                        <div class="d-grid">
                        <a href="paginaDecision.php">
                            <button type="submit" class="btn game-btn">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                            </button>
                        </a>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>