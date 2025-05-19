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
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Ubicación</th>
                                        <th>Telefono</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos -->
                                <?php 
                                    $sql = "SELECT  id_sitio, nombre, tipo, telefono, direccion,estado FROM sitiosInteres";
                                    $stmt = $_conexion->prepare($sql);
                                    $stmt->execute();
                                    $sitios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($sitios as $sitio) {

                                ?>
                                    <tr>
                                        <td><?php echo $sitio["id_sitio"]?></td>
                                        <td><?php echo $sitio["nombre"]?></td>
                                        <td><span class="badge bg-warning text-dark badge-category"><?php echo $sitio["tipo"]?></span></td>
                                        <td><?php echo $sitio["direccion"]?></td>
                                        <td><?php echo $sitio["telefono"]?></td>
                                        <td><span class="badge bg-success"><?php echo $sitio["estado"]?></span></td>
                                        <td class="action-btns">
                                            <button 
                                                class="btn btn-sm btn-info btn-editar" 
                                                data-id="<?php echo $sitio['id_sitio']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editSitioModal" 
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary" title="Ver en Mapa">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </button>
                                        </td>
                                        <td class="action-btns">
                                            <form action="sitios/eliminar_sitio.php" method="post">
                                                <input type="hidden" name="id_sitio" id="id_sitio" value="<?php echo $sitio['id_sitio'] ?>">
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Eliminar" type="submit">     
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                            
                                       
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                    <form id="siteForm" action="sitios/nuevo_sitio.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del Sitio</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="" selected disabled>Seleccione categoría</option>
                                    <option value="Histórico">Histórico</option>
                                    <option value="Playa">Playa</option>
                                    <option value="Cultural">Cultural</option>
                                    <option value="Restaurante">Restaurante</option>
                                    <option value="Tienda">Tienda</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="latitud" class="form-label">Latitud (-90 a 90)</label>
                                <input type="number" class="form-control" id="latitud" name="latitud">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="longitud" class="form-label">Longitud (-180 a 180)</label>
                                <input type="number" class="form-control" id="longitud" name="longitud">
                            </div>

                            <div class="col-12">
                                <label for="siteDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                          
                        </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="activo" name="estado" checked>
                                    <label class="form-check-label" for="activo">
                                        Usuario activo
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="guardar">Guardar Sitio</button>
                            </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal para editar sitio -->
    <div class="modal fade" id="editSitioModal" tabindex="-1" aria-labelledby="editSiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="editar_sitio" action="sitios/editar_sitio.php" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="editSiteModalLabel"><i class="fas fa-edit me-2"></i>Editar Sitio de Interés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="edit_id_sitio" id="edit_id_sitio">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="edit_nombre" class="form-label">Nombre del Sitio</label>
                        <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="edit_tipo" name="edit_tipo" required>
                            <option value="Histórico">Histórico</option>
                            <option value="Playa">Playa</option>
                            <option value="Cultural">Cultural</option>
                            <option value="Restaurante">Restaurante</option>
                            <option value="Tienda">Tienda</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="edit_direccion" name="edit_direccion" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="edit_telefono" name="edit_telefono">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="edit_email">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_latitud" class="form-label">Latitud</label>
                        <input type="number" class="form-control" id="edit_latitud" name="edit_latitud" step="any">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_longitud" class="form-label">Longitud</label>
                        <input type="number" class="form-control" id="edit_longitud" name="edit_longitud" step="any">
                    </div>
                    <div class="col-md-6">
                    <label for="edit_id_qr" class="form-label">QR Asignado</label>
                    <select class="form-select" id="edit_id_qr" name="edit_id_qr">
                        <option value="">Seleccione QR</option>
                        <!-- Agregá dinámicamente los QRs disponibles -->
                    </select>
                    </div>
                    <div class="col-12">
                        <label for="edit_descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="edit_descripcion" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_estado" name="edit_estado">
                        <label class="form-check-label" for="edit_estado">
                        Sitio activo
                        </label>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
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

            /*---------------*/

             // Configurar botones de edición en la tabla
        $(document).ready(function () {
            $('.btn-editar').on('click', function () {
                const id = $(this).data('id');

            // Llamada al backend para obtener los datos del sitio
            fetch(`sitios/obtener_sitio.php?id_sitio=${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#edit_id_sitio').val(data.id_sitio);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_tipo').val(data.tipo);
                    $('#edit_direccion').val(data.direccion);
                    $('#edit_telefono').val(data.telefono);
                    $('#edit_email').val(data.email);
                    $('#edit_latitud').val(data.latitud);
                    $('#edit_longitud').val(data.longitud);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_estado').prop('checked', data.estado === 'activo');

                    // Mostrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSitioModal'));
                    modal.hide();

                })
                .catch(err => {
                    console.error('Error al obtener datos del sitio:', err);
                    alert('No se pudo cargar la información del sitio');
                });
            });
        });


        });
    </script>
</body>

</html>