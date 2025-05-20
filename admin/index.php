<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../util/css/style-admin.css">
    
    <?php
    /**CODIGO DE ERROR */
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 );
        require('../util/conexion.php');
    ?>
   
</head>

<body>
        <?php
        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["usuario"];
            $contrasena = $_POST["contrasena"];

            // Preparar consulta segura con PDO
            $sql = "SELECT * FROM administradores WHERE email = :email";
            $stmt = $_conexion->prepare($sql);
            $stmt->bindParam(':email', $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                echo "El usuario no existe";
            } else {
                if (password_verify($contrasena, $resultado["password"])) {
                    session_start();
                    $_SESSION["usuario"] = $usuario;
                    header("location: ./panel-admin.php");
                    exit;
                } else {
                    echo "Contraseña errónea";
                }
            }
        }

        ?>

    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="../util/img/trady_sinFondo.png" alt="Trady Logo">
                <h2>Trady Admin</h2>
                <p class="text-muted">Panel de administración</p>
            </div>

            <form id="loginForm" method="post">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="usuario" id="username" placeholder="Nombre de usuario" required>
                    </div>
                    <div id="usernameError" class="error-message"></div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="contrasena" id="password" placeholder="Contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="passwordError" class="error-message"></div>
                </div>

                <div class="mb-3 form-check text-start">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Recordar sesión</label>
                </div>

                <button type="submit" class="btn btn-login mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </button>

                <div class="login-footer">
                    <a href="#"><i class="fas fa-question-circle me-1"></i>¿Olvidaste tu contraseña?</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>