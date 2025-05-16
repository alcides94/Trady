<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Panel de Administración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="row g-4">

            <!-- Tarjeta: Usuarios -->
            
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallausuarios.php">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Usuarios</h5>
                    </div>
                </a>
                </div>
            </div>

           
            
            <!-- Tarjeta: Partners -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallapartners.php">
                    <div class="card-body">
                        <i class="fas fa-store fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Partners</h5>
                    </div>
                </a>
                </div>
            </div>

            <!-- Tarjeta: Rutas -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallarutas.php">
                    <div class="card-body">
                        <i class="fas fa-route fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Rutas</h5>
                    </div>
                </a>
                </div>
            </div>

            <!-- Tarjeta: Sitios de Interés -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallasitiosinteres.php">
                    <div class="card-body">
                        <i class="fas fa-map-marker-alt fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Sitios de Interés</h5>
                    </div>
                </div>
                </a>
            </div>

            <!-- Tarjeta: Suscripciones -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallasuscripciones.php">
                    <div class="card-body">
                        <i class="fas fa-id-card fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Suscripciones</h5>
                    </div>
                </a>
                </div>
            </div>

            <!-- Tarjeta: Códigos QR -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallacodigosqr.php">
                    <div class="card-body">
                        <i class="fas fa-qrcode fa-3x text-dark mb-3"></i>
                        <h5 class="card-title">Códigos QR</h5>
                    </div>
                </a>
                </div>
            </div>

            <!-- Tarjeta: Configuración -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center shadow h-100">
                <a href="pantallaconfiguracion.php">
                    <div class="card-body">
                        <i class="fas fa-cog fa-3x text-secondary mb-3"></i>
                        <h5 class="card-title">Configuración</h5>
                    </div>
                </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            console.log("Mapas inicializados (simulación)");
        }

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const qrInput = document.getElementById('qrIdentificador');
        if (qrInput) {
            qrInput.addEventListener('input', function () {
                const identificador = this.value || 'TRA-SAMPLE';
                document.getElementById('qrPreview').src =
                    'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(identificador);
            });
        }
    </script>
</body>

</html>
