<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Rutas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Leaflet CSS (para mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .route-card {
            transition: transform 0.2s;
        }
        .route-card:hover {
            transform: translateY(-5px);
        }
        .badge-custom {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
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
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-route me-2"></i> Gestión de Rutas</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRouteModal">
                        <i class="fas fa-plus me-1"></i> Nueva Ruta
                    </button>
                </div>
                <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <!-- Mapa de Visualización -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-map-marked-alt me-2"></i> Mapa de Rutas
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de Rutas -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-list me-2"></i> Listado de Rutas
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="routesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Dificultad</th>
                                        <th>Duración</th>
                                        <th>Puntos de Interés</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos (en producción vendrían de la BD) -->
                                    <tr>
                                        <td>1</td>
                                        <td>Ruta Histórica</td>
                                        <td>Recorrido por los principales monumentos históricos</td>
                                        <td><span class="badge bg-success badge-custom">Fácil</span></td>
                                        <td>2 horas</td>
                                        <td>8</td>
                                        <td><span class="badge bg-success">Activa</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Ruta Gastronómica</td>
                                        <td>Descubre los sabores tradicionales de la región</td>
                                        <td><span class="badge bg-warning text-dark badge-custom">Media</span></td>
                                        <td>3.5 horas</td>
                                        <td>12</td>
                                        <td><span class="badge bg-success">Activa</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ruta Natural</td>
                                        <td>Explora los paisajes naturales más impresionantes</td>
                                        <td><span class="badge bg-danger badge-custom">Difícil</span></td>
                                        <td>5 horas</td>
                                        <td>6</td>
                                        <td><span class="badge bg-secondary">Inactiva</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir nueva ruta -->
    <div class="modal fade" id="addRouteModal" tabindex="-1" aria-labelledby="addRouteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRouteModalLabel"><i class="fas fa-route me-2"></i>Nueva Ruta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="routeForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="routeName" class="form-label">Nombre de la Ruta</label>
                                <input type="text" class="form-control" id="routeName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="routeDifficulty" class="form-label">Dificultad</label>
                                <select class="form-select" id="routeDifficulty" required>
                                    <option value="easy">Fácil</option>
                                    <option value="medium" selected>Media</option>
                                    <option value="hard">Difícil</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="routeDuration" class="form-label">Duración (horas)</label>
                                <input type="number" class="form-control" id="routeDuration" min="0.5" step="0.5" required>
                            </div>
                            <div class="col-md-6">
                                <label for="routeStatus" class="form-label">Estado</label>
                                <select class="form-select" id="routeStatus" required>
                                    <option value="active" selected>Activa</option>
                                    <option value="inactive">Inactiva</option>
                                    <option value="maintenance">En mantenimiento</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="routeDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="routeDescription" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="routePoints" class="form-label">Puntos de Interés</label>
                                <select class="form-select" id="routePoints" multiple>
                                    <!-- Estos datos vendrían de la base de datos -->
                                    <option value="1">Monumento Histórico</option>
                                    <option value="2">Restaurante Tradicional</option>
                                    <option value="3">Mirador Natural</option>
                                    <option value="4">Museo Local</option>
                                    <option value="5">Playa</option>
                                </select>
                                <small class="text-muted">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples opciones.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dibujar Ruta en el Mapa</label>
                                <div id="routeMap" style="height: 250px; border-radius: 8px;"></div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="startDrawing">
                                        <i class="fas fa-draw-polygon me-1"></i>Dibujar Ruta
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="clearDrawing">
                                        <i class="fas fa-eraser me-1"></i>Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveRouteBtn">Guardar Ruta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Leaflet JS (para mapas) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#routesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            // Inicializar mapa principal
            const map = L.map('map').setView([36.7213, -4.4214], 13); // Coordenadas de Málaga
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Añadir marcadores de ejemplo
            const markers = [
                {lat: 40.4168, lng: -3.7038, title: "Punto de inicio", description: "Plaza Mayor"},
                {lat: 40.4186, lng: -3.7002, title: "Museo", description: "Museo de Historia"},
                {lat: 40.4150, lng: -3.7075, title: "Restaurante", description: "Comida tradicional"}
            ];

            markers.forEach(marker => {
                L.marker([marker.lat, marker.lng])
                    .addTo(map)
                    .bindPopup(`<b>${marker.title}</b><br>${marker.description}`);
            });

            // Manejar el botón de guardar ruta
            $('#saveRouteBtn').click(function() {
                // Aquí iría la lógica para guardar la ruta
                alert('Ruta guardada correctamente (simulación)');
                $('#addRouteModal').modal('hide');
                $('#routeForm')[0].reset();
            });
        });
    </script>
</body>

</html>