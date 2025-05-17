<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../util/conexion.php');

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario
$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $_conexion->prepare($sql);
$stmt->bindParam(':email', $_SESSION["usuario"]);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Procesar cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva_contrasena = $_POST["nueva_contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];
    
    $errores = [];
    
    // Validar campos
    if(empty($nueva_contrasena)) {
        $errores[] = "La nueva contraseña es requerida";
    } elseif(!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,15}$/', $nueva_contrasena)) {
        $errores[] = "La contraseña debe tener entre 8 y 15 caracteres con letras y números";
    }
    
    if($nueva_contrasena !== $confirmar_contrasena) {
        $errores[] = "Las contraseñas no coinciden";
    }
    
    if(empty($errores)) {
        try {
            // Actualizar contraseña directamente
            $sql = "UPDATE usuarios SET password = :password WHERE email = :email";
            $stmt = $_conexion->prepare($sql);
            $stmt->execute([
                ':password' => password_hash($nueva_contrasena, PASSWORD_DEFAULT),
                ':email' => $_SESSION["usuario"]
            ]);
            
            $_SESSION["success"] = "Contraseña actualizada correctamente";
            header("Location: perfil-usuario.php");
            exit();
            
        } catch(PDOException $e) {
            $errores[] = "Error al actualizar la contraseña: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Trady</title>
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
            min-height: 100vh;
            color: white;
        }
        
        .password-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
            font-weight: bold;
        }
        
        .password-strength {
            height: 5px;
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        
        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
        <div class="container">
            <a class="navbar-brand fw-bold" href="perfil-usuario.php">
                <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i> TRADY
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3">Bienvenido, <?php echo htmlspecialchars($usuario["nombre"]); ?></span>
                <img src="https://via.placeholder.com/40" alt=": )" class="rounded-circle">
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="password-card">
            <a href="perfil-usuario.php" class="btn btn-outline-light mb-4">
                <i class="fas fa-arrow-left me-2"></i>Volver al perfil
            </a>
            
            <h2 class="text-center mb-4"><i class="fas fa-lock me-2"></i>Cambiar Contraseña</h2>
            
            <?php if(!empty($errores)): ?>
                <div class="alert alert-danger">
                    <?php foreach($errores as $error): ?>
                        <p class="mb-1"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                
                <div class="mb-3">
                    <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" required>
                        <button class="btn btn-outline-light toggle-password" type="button">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength mt-2">
                        <div class="strength-bar" id="strength-bar"></div>
                    </div>
                    <small class="form-text">Mínimo 8 caracteres, con letras y números</small>
                </div>
                
                <div class="mb-4">
                    <label for="confirmar_contrasena" class="form-label">Confirmar Nueva Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                        <button class="btn btn-outline-light toggle-password" type="button">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar contraseña
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if(input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
        
        // Indicador de fortaleza de contraseña
        document.getElementById('nueva_contrasena').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;
            
            if(password.length >= 8) strength += 1;
            if(/[A-Z]/.test(password)) strength += 1;
            if(/[0-9]/.test(password)) strength += 1;
            if(/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            const width = strength * 25;
            strengthBar.style.width = width + '%';
            
            if(strength < 2) {
                strengthBar.style.backgroundColor = '#ff4d4d';
            } else if(strength < 4) {
                strengthBar.style.backgroundColor = '#ffcc00';
            } else {
                strengthBar.style.backgroundColor = '#00cc66';
            }
        });
    </script>
</body>
</html>