<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Sitios de Interés</title>
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
        .site-img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .badge-category {
            font-size: 0.8rem;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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
                    <h2><i class="fas fa-map-marker-alt me-2"></i> Gestión de Sitios de Interés</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSiteModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Sitio
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
                        <i class="fas fa-map-marked-alt me-2"></i> Mapa de Sitios de Interés
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de Sitios -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-list me-2"></i> Listado de Sitios de Interés
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sitesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Ubicación</th>
                                        <th>Horario</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos -->
                                    <tr>
                                        <td>1</td>
                                        <td><img src="https://via.placeholder.com/80x60" alt="Imagen sitio" class="site-img"></td>
                                        <td>Alcazaba de Málaga</td>
                                        <td><span class="badge bg-warning text-dark badge-category">Histórico</span></td>
                                        <td>C/ Alcazabilla, 2</td>
                                        <td>09:00 - 20:00</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><img src="https://via.placeholder.com/80x60" alt="Imagen sitio" class="site-img"></td>
                                        <td>Playa de la Malagueta</td>
                                        <td><span class="badge bg-info badge-category">Playa</span></td>
                                        <td>P.º Marítimo Pablo Ruiz Picasso</td>
                                        <td>24 horas</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><img src="https://via.placeholder.com/80x60" alt="Imagen sitio" class="site-img"></td>
                                        <td>Museo Picasso</td>
                                        <td><span class="badge bg-primary badge-category">Cultural</span></td>
                                        <td>C. San Agustín, 8</td>
                                        <td>10:00 - 19:00</td>
                                        <td><span class="badge bg-secondary">Inactivo</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" title="Ver en Mapa">
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

    <!-- Modal para añadir nuevo sitio -->
    <div class="modal fade" id="addSiteModal" tabindex="-1" aria-labelledby="addSiteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSiteModalLabel"><i class="fas fa-map-marker-alt me-2"></i>Nuevo Sitio de Interés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="siteForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="siteName" class="form-label">Nombre del Sitio</label>
                                <input type="text" class="form-control" id="siteName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="siteCategory" class="form-label">Categoría</label>
                                <select class="form-select" id="siteCategory" required>
                                    <option value="" selected disabled>Seleccione categoría</option>
                                    <option value="historical">Histórico</option>
                                    <option value="beach">Playa</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="restaurant">Restaurante</option>
                                    <option value="shop">Tienda</option>
                                    <option value="other">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="siteAddress" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="siteAddress" required>
                            </div>
                            <div class="col-md-6">
                                <label for="siteSchedule" class="form-label">Horario</label>
                                <input type="text" class="form-control" id="siteSchedule" placeholder="Ej: 09:00 - 20:00" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sitePhone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="sitePhone">
                            </div>
                            <div class="col-md-6">
                                <label for="siteWebsite" class="form-label">Sitio Web</label>
                                <input type="url" class="form-control" id="siteWebsite" placeholder="https://">
                            </div>
                            <div class="col-md-6">
                                <label for="siteImage" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="siteImage" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="siteStatus" class="form-label">Estado</label>
                                <select class="form-select" id="siteStatus" required>
                                    <option value="active" selected>Activo</option>
                                    <option value="inactive">Inactivo</option>
                                    <option value="maintenance">En mantenimiento</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="siteDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="siteDescription" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ubicación en Mapa</label>
                                <div id="siteMap" style="height: 250px; border-radius: 8px;"></div>
                                <small class="text-muted">Haz clic en el mapa para marcar la ubicación</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveSiteBtn">Guardar Sitio</button>
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
            $('#sitesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            // Inicializar mapa principal centrado en Málaga
            const map = L.map('map').setView([36.7213, -4.4214], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Marcadores de ejemplo en Málaga
            const sites = [
                {
                    id: 1,
                    name: "Alcazaba de Málaga",
                    lat: 36.7206,
                    lng: -4.4156,
                    category: "historical",
                    address: "C/ Alcazabilla, 2"
                },
                {
                    id: 2,
                    name: "Playa de la Malagueta",
                    lat: 36.7166,
                    lng: -4.4258,
                    category: "beach",
                    address: "P.º Marítimo Pablo Ruiz Picasso"
                },
                {
                    id: 3,
                    name: "Museo Picasso",
                    lat: 36.7196,
                    lng: -4.4238,
                    category: "cultural",
                    address: "C. San Agustín, 8"
                }
            ];

            // Iconos personalizados por categoría
            const categoryIcons = {
                historical: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34]
                }),
                beach: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34]
                }),
                cultural: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34]
                }),
                default: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-gold.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34]
                })
            };

            // Añadir marcadores al mapa
            sites.forEach(site => {
                const icon = categoryIcons[site.category] || categoryIcons.default;
                
                L.marker([site.lat, site.lng], {icon: icon})
                    .addTo(map)
                    .bindPopup(`<b>${site.name}</b><br>${site.address}`);
            });

            // Configurar mapa en el modal cuando se abre
            let siteMap;
            let marker;
            
            $('#addSiteModal').on('shown.bs.modal', function () {
                siteMap = L.map('siteMap').setView([36.7213, -4.4214], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(siteMap);
                
                // Manejar clic en el mapa para añadir/actualizar marcador
                siteMap.on('click', function(e) {
                    if (marker) {
                        siteMap.removeLayer(marker);
                    }
                    
                    marker = L.marker([e.latlng.lat, e.latlng.lng], {
                        draggable: true,
                        icon: categoryIcons.default
                    }).addTo(siteMap);
                    
                    // Actualizar coordenadas si el marcador se arrastra
                    marker.on('dragend', function() {
                        const position = marker.getLatLng();
                        console.log("Posición actualizada:", position);
                    });
                });
            });

            // Limpiar mapa del modal cuando se cierra
            $('#addSiteModal').on('hidden.bs.modal', function () {
                if (siteMap) {
                    siteMap.remove();
                }
            });

            // Manejar el botón de guardar sitio
            $('#saveSiteBtn').click(function() {
                // Aquí iría la lógica para guardar el sitio
                alert('Sitio guardado correctamente (simulación)');
                $('#addSiteModal').modal('hide');
                $('#siteForm')[0].reset();
            });
        });
    </script>
</body>

</html>