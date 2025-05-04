<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Detalles de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../util/css/style-admin-usuarios.css">
    
    <?php 
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    require('../util/conexion.php');
    
    session_start();
        if (!isset($_SESSION["usuario"])){
            header("location: ./index.php");
            exit;
        }
    ?>
   
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-header">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <img src="trady_sinFondo.png" alt="Trady Logo" width="40" class="me-2">Trady Admin
            </a>
            <div class="d-flex align-items-center">
                <div class="user-menu d-flex align-items-center text-white">
                    <img src="https://via.placeholder.com/40" alt="Admin Avatar">
                    <span>Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalles de Usuario</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Columna izquierda - Información del usuario -->
            <div class="col-md-4">
                <div class="admin-card p-4 text-center">
                    <img src="https://via.placeholder.com/120" alt="User Avatar" class="user-avatar mb-3">
                    <h3>Juan Pérez</h3>
                    <span class="status-badge status-active mb-3">Activo</span>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <button class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit me-1"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i class="fas fa-lock me-1"></i> Bloquear
                        </button>
                    </div>

                    <div class="text-start info-card mb-4">
                        <h5><i class="fas fa-info-circle me-2"></i>Información Básica</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>ID:</strong> 1001</li>
                            <li class="mb-2"><strong>Email:</strong> juan@example.com</li>
                            <li class="mb-2"><strong>Teléfono:</strong> +34 600 123 456</li>
                            <li class="mb-2"><strong>Registro:</strong> 15/03/2023</li>
                            <li class="mb-2"><strong>Último acceso:</strong> Hoy, 10:45 AM</li>
                        </ul>
                    </div>

                    <div class="text-start info-card">
                        <h5><i class="fas fa-map-marker-alt me-2"></i>Ubicación</h5>
                        <p class="mb-2"><strong>Ciudad:</strong> Madrid</p>
                        <p class="mb-2"><strong>País:</strong> España</p>
                        <div class="map-container mt-3" style="height: 150px;">
                            <!-- Mapa pequeño con ubicación aproximada -->
                            <div id="user-location-map"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Detalles y actividad -->
            <div class="col-md-8">
                <div class="admin-card p-4">
                    <ul class="nav nav-tabs mb-4" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                                <i class="fas fa-user me-2"></i>Detalles
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                <i class="fas fa-list-alt me-2"></i>Actividad
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="routes-tab" data-bs-toggle="tab" data-bs-target="#routes" type="button" role="tab">
                                <i class="fas fa-route me-2"></i>Rutas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rewards-tab" data-bs-toggle="tab" data-bs-target="#rewards" type="button" role="tab">
                                <i class="fas fa-award me-2"></i>Recompensas
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Pestaña Detalles -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><i class="fas fa-id-card me-2"></i>Información Personal</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Nombre completo</th>
                                                    <td>Juan Pérez García</td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha nacimiento</th>
                                                    <td>15/08/1985</td>
                                                </tr>
                                                <tr>
                                                    <th>Género</th>
                                                    <td>Masculino</td>
                                                </tr>
                                                <tr>
                                                    <th>Idioma preferido</th>
                                                    <td>Español</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5><i class="fas fa-chart-line me-2"></i>Estadísticas</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th>Puntos totales</th>
                                                    <td>1,250 <span class="badge bg-primary">Top 15%</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Rutas completadas</th>
                                                    <td>8</td>
                                                </tr>
                                                <tr>
                                                    <th>Sitios visitados</th>
                                                    <td>24</td>
                                                </tr>
                                                <tr>
                                                    <th>Días consecutivos</th>
                                                    <td>12 <i class="fas fa-fire text-danger"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5><i class="fas fa-cog me-2"></i>Preferencias</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge badge-custom bg-primary">Cultura</span>
                                    <span class="badge badge-custom bg-success">Gastronomía</span>
                                    <span class="badge badge-custom bg-warning text-dark">Arte</span>
                                    <span class="badge badge-custom bg-info">Historia</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5><i class="fas fa-shield-alt me-2"></i>Seguridad</h5>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Último cambio de contraseña:</strong> Hace 90 días. Se recomienda actualizar.
                                </div>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-key me-1"></i> Forzar cambio de contraseña
                                </button>
                            </div>
                        </div>

                        <!-- Pestaña Actividad -->
                        <div class="tab-pane fade" id="activity" role="tabpanel">
                            <h5 class="mb-4">Historial de Actividad</h5>
                            
                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Inicio de sesión exitoso</strong>
                                    <small class="text-muted">Hoy, 10:45 AM</small>
                                </div>
                                <p class="mb-0 text-muted">Desde dispositivo móvil (iPhone 13)</p>
                                <small>IP: 192.168.1.45</small>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Ruta completada: Gastronomía Local</strong>
                                    <small class="text-muted">Ayer, 6:30 PM</small>
                                </div>
                                <p class="mb-0">+150 puntos</p>
                                <small>Visitó 5 establecimientos</small>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Recompensa canjeada</strong>
                                    <small class="text-muted">Ayer, 6:15 PM</small>
                                </div>
                                <p class="mb-0">Descuento del 20% en Café Central</p>
                                <small>-200 puntos</small>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Sitio visitado: Catedral de la Ciudad</strong>
                                    <small class="text-muted">Ayer, 4:20 PM</small>
                                </div>
                                <p class="mb-0">+50 puntos</p>
                                <small>Escaneó código QR</small>
                            </div>

                            <div class="text-center mt-3">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history me-1"></i> Cargar más actividad
                                </button>
                            </div>
                        </div>

                        <!-- Pestaña Rutas -->
                        <div class="tab-pane fade" id="routes" role="tabpanel">
                            <h5 class="mb-4">Rutas del Usuario</h5>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ruta</th>
                                            <th>Progreso</th>
                                            <th>Puntos</th>
                                            <th>Última actividad</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Gastronomía Local</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                                </div>
                                            </td>
                                            <td>150</td>
                                            <td>Ayer</td>
                                            <td><span class="badge bg-success">Completada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Ruta Histórica</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                                </div>
                                            </td>
                                            <td>300</td>
                                            <td>Hace 3 días</td>
                                            <td><span class="badge bg-primary">En progreso</span></td>
                                        </tr>
                                        <tr>
                                            <td>Arte Urbano</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                                </div>
                                            </td>
                                            <td>120</td>
                                            <td>Hace 2 semanas</td>
                                            <td><span class="badge bg-secondary">Inactiva</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="mt-5 mb-3">Rutas recomendadas</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="https://via.placeholder.com/300x150?text=Ruta+Histórica" class="card-img-top" alt="Ruta Histórica">
                                        <div class="card-body">
                                            <h6 class="card-title">Ruta Histórica</h6>
                                            <p class="card-text small text-muted">8 lugares históricos en el centro</p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <button class="btn btn-sm btn-outline-primary w-100">Recomendar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="https://via.placeholder.com/300x150?text=Mercados+Tradicionales" class="card-img-top" alt="Mercados Tradicionales">
                                        <div class="card-body">
                                            <h6 class="card-title">Mercados Tradicionales</h6>
                                            <p class="card-text small text-muted">4 mercados con productos locales</p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <button class="btn btn-sm btn-outline-primary w-100">Recomendar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña Recompensas -->
                        <div class="tab-pane fade" id="rewards" role="tabpanel">
                            <h5 class="mb-4">Recompensas del Usuario</h5>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="admin-card p-3 text-center">
                                        <h3 class="text-primary">1,250</h3>
                                        <p class="mb-0">Puntos disponibles</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="admin-card p-3 text-center">
                                        <h3 class="text-success">8</h3>
                                        <p class="mb-0">Recompensas canjeadas</p>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3">Recompensas disponibles</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Descuento 20% Café</h6>
                                            <p class="card-text small text-muted">Café Central</p>
                                            <span class="badge bg-warning text-dark">200 puntos</span>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <button class="btn btn-sm btn-success w-100">Conceder</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Entrada gratis</h6>
                                            <p class="card-text small text-muted">Museo Municipal</p>
                                            <span class="badge bg-warning text-dark">500 puntos</span>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <button class="btn btn-sm btn-success w-100">Conceder</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mt-5 mb-3">Historial de recompensas</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Recompensa</th>
                                            <th>Partner</th>
                                            <th>Puntos</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Descuento 20%</td>
                                            <td>Café Central</td>
                                            <td>200</td>
                                            <td>Ayer</td>
                                            <td><span class="badge bg-success">Canjeada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Bebida gratis</td>
                                            <td>Bar Moderno</td>
                                            <td>150</td>
                                            <td>Hace 1 semana</td>
                                            <td><span class="badge bg-secondary">Expirada</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aquí podrías añadir lógica para cargar los datos del usuario desde una API
        // y actualizar dinámicamente la interfaz
        
        // Ejemplo de inicialización de un mapa (requeriría la API de Google Maps o similar)
        function initUserMap() {
            // Código para inicializar el mapa con la ubicación del usuario
            console.log("Inicializando mapa de ubicación del usuario...");
        }
        
        // Llamar a la función cuando la página cargue
        window.onload = initUserMap;
    </script>
</body>

</html>