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
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["name"];
            $correo = $_POST["email"];
            $telefono = $_POST["phone"];
            $fecha = $_POST["birthdate"];
     
            $cont = 0; // Contador de validaciones
     
            // Validación del nombre
            if (!preg_match("/^[a-zA-Z0-9 ]{3,16}$/", $nombre)) {
                echo "<h4>Nombre inválido. Debe contener solo letras y/o numeros (3-16 caracteres).</h4>";
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
            if ($cont == 2) {
                 $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
     
                 $stmt = $_conexion->prepare("
                     UPDATE usuarios SET 
                    nombre = :nombre, 
                    telefono = :telefono, 
                    fecha_nac = :fecha_nac
                    WHERE email = :email
                 ");
                 
                 $stmt->execute([
                     "email" => $correo,
                     "nombre" => $nombre,
                     "fecha_nac" => $fecha,
                     "telefono" => $telefono
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
    <title>Editar Perfil - Trady</title>
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

        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
        }

        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
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

        .avatar-upload {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
        }

        .avatar-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .avatar-upload label {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--game-primary);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .avatar-upload input[type="file"] {
            display: none;
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
                <span class="me-3">Puntos: <strong><?php echo $resultado["puntos"];?></strong></span>
                <img src="https://via.placeholder.com/40" alt=": )" class="rounded-circle">
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container profile-container">
        <div class="profile-card">
            <div class="nav-back" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
            </div>
            
            <h2 class="text-center mb-4"><i class="fas fa-user-edit me-2"></i>Editar Perfil</h2>
            
            <form id="savechangesform" action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" id="firstName" value="<?php echo $resultado["nombre"];?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $resultado["email"];?>">
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $resultado["telefono"];?>">
                </div>
                
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo $resultado["fecha_nac"];?>">
                </div>
                <a class="btn btn-danger" href="cambiar_contraseña.php">CAMBIAR CONTRASEÑA</a>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-cancel me-md-2" onclick="window.history.back()">Cancelar</button>
                    <button type="submit" class="btn btn-save">Guardar Cambios</button>
                </div>
            </form>
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
    
    <!-- Script para la carga de avatar -->
    <script>
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('avatar-preview').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>