<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Configuración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require('../util/conexion.php');
    
    session_start();
    if (!isset($_SESSION["usuario"])){
        header("location: ./index.php");
        exit;
    }
    ?>
    <link rel="stylesheet" href="../util/css/style-panel-admin.css">
    <style>
        .profile-pic {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .config-card {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-header">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <img src="../util/img/trady_sinFondo.png" alt="Trady Logo" width="40" class="me-2">Trady Admin
            </a>
            <div class="d-flex align-items-center">
                <div class="user-menu d-flex align-items-center text-white">
                    <?php if (isset($_SESSION["usuario"])) { ?>
                        <h4>Bienvenido <?php echo $_SESSION["usuario"] ?></h4>
                        <a href="cerrar_sesion.php" class="btn btn-danger ms-3">Cerrar Sesión</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
        <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            <div class="col-md-8">
                <div class="card shadow config-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-cog me-2"></i>Configuración de Cuenta</h4>
                    </div>

                    <?php 
                        $email = $_SESSION["usuario"];
                        $sql = "SELECT * FROM administradores where email=:email";
                        $stmt = $_conexion->prepare($sql);
                        $stmt->execute(
                            ['email' => $email]
                        );
                        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                        
                    ?>


                    <div class="card-body">
                        <form action="configuracion/configuracion.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                       value="<?php echo ($usuario['nombre']); ?>" >
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo ($usuario['email']); ?>" ">
                            </div>
                            
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" id="currentPassword" name="contrasena">
                            </div>
                            
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="newPassword" name="contrasenaNueva">
                                <small class="text-muted">Mínimo 8 caracteres</small>
                            </div>
                            
                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirmPassword" name="contrasenaRepetir">
                            </div>
                            
                            <div class="d-grid gap-2">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo ($usuario['id']); ?>" >
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            const nueva = document.getElementById("newPassword").value.trim();
            const repetir = document.getElementById("confirmPassword").value.trim();

            if (nueva !== "" || repetir !== "") {
                if (nueva.length < 8) {
                    alert("La nueva contraseña debe tener al menos 8 caracteres.");
                    event.preventDefault(); // Detiene el envío
                    return;
                }

                if (nueva !== repetir) {
                    alert("Las contraseñas no coinciden.");
                    event.preventDefault(); // Detiene el envío
                    return;
                }
            }

            // Si todo está bien, el formulario se envía normalmente
        });
        </script>

</body>

</html>