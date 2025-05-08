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
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
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
                        <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar Sesion</a>
                    <?php } ?>
                        
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-3">
        <!-- Pestañas de Administración -->
        <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab">
                    <i class="fas fa-users me-2"></i>Usuarios
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="partners-tab" data-bs-toggle="tab" data-bs-target="#partners" type="button" role="tab">
                    <i class="fas fa-store me-2"></i>Partners
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rutas-tab" data-bs-toggle="tab" data-bs-target="#rutas" type="button" role="tab">
                    <i class="fas fa-route me-2"></i>Rutas
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sitios-tab" data-bs-toggle="tab" data-bs-target="#sitios" type="button" role="tab">
                    <i class="fas fa-map-marker-alt me-2"></i>Sitios de Interés
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="suscripciones-tab" data-bs-toggle="tab" data-bs-target="#suscripciones" type="button" role="tab">
                    <i class="fas fa-id-card me-2"></i>Suscripciones
                </button>
            </li>
               <!-- Nueva pestaña para códigos QR -->
         
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr" type="button" role="tab">
                    <i class="fas fa-qrcode me-2"></i>Códigos QR
                </button>
            </li>
          
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="configuracion-tab" data-bs-toggle="tab" data-bs-target="#configuracion" type="button" role="tab">
                    <i class="fas fa-cog me-2"></i>Configuración
                </button>
            </li>
          
        </ul>

        <div class="tab-content">
            <!-- Pestaña de Usuarios -->
            <div class="tab-pane fade show active" id="usuarios" role="tabpanel">
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4><i class="fas fa-users me-2"></i>Gestión de Usuarios</h4>
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar usuarios...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Registro</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1001</td>
                                    <td>Juan Pérez</td>
                                    <td>juan@example.com</td>
                                    <td>15/03/2023</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning action-btn">Bloquear</button>
                                        <button class="btn btn-sm btn-info action-btn">Detalles</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1002</td>
                                    <td>Ana García</td>
                                    <td>ana@example.com</td>
                                    <td>22/05/2023</td>
                                    <td><span class="status-badge status-pending">Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success action-btn">Validar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Rechazar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1003</td>
                                    <td>Carlos López</td>
                                    <td>carlos@example.com</td>
                                    <td>10/06/2023</td>
                                    <td><span class="status-badge status-blocked">Bloqueado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success action-btn">Activar</button>
                                        <button class="btn btn-sm btn-info action-btn">Detalles</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Pestaña de Partners -->
            <div class="tab-pane fade" id="partners" role="tabpanel">
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4><i class="fas fa-store me-2"></i>Gestión de Partners</h4>
                        <div>
                            <button class="btn btn-primary me-2">
                                <i class="fas fa-plus me-1"></i> Nuevo Partner
                            </button>
                            <div class="search-box d-inline-block">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" placeholder="Buscar partners...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2001</td>
                                    <td>Café Central</td>
                                    <td>Cafetería</td>
                                    <td>Calle Principal, 123</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Bloquear</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2002</td>
                                    <td>Libros & Más</td>
                                    <td>Librería</td>
                                    <td>Avenida Libros, 45</td>
                                    <td><span class="status-badge status-pending">Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success action-btn">Aprobar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Rechazar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2003</td>
                                    <td>Tech Solutions</td>
                                    <td>Electrónica</td>
                                    <td>Plaza Tecnología, 7</td>
                                    <td><span class="status-badge status-blocked">Bloqueado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success action-btn">Activar</button>
                                        <button class="btn btn-sm btn-info action-btn">Detalles</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Pestaña de Rutas -->
            <div class="tab-pane fade" id="rutas" role="tabpanel">
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4><i class="fas fa-route me-2"></i>Gestión de Rutas</h4>
                        <div>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevaRutaModal">
                                <i class="fas fa-plus me-1"></i> Nueva Ruta
                            </button>
                            <div class="search-box d-inline-block">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" placeholder="Buscar rutas...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Lista de Rutas -->
                        <div class="col-md-6">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Ruta Histórica</h5>
                                        <small>Activa</small>
                                    </div>
                                    <p class="mb-1">8 lugares históricos en el centro de la ciudad.</p>
                                    <small>400 puntos totales</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Gastronomía Local</h5>
                                        <small>Activa</small>
                                    </div>
                                    <p class="mb-1">5 establecimientos con comida tradicional.</p>
                                    <small>300 puntos totales</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Arte Urbano</h5>
                                        <small>Inactiva</small>
                                    </div>
                                    <p class="mb-1">6 murales y obras de arte callejero.</p>
                                    <small>400 puntos totales</small>
                                </a>
                            </div>
                        </div>

                        <!-- Detalles de Ruta -->
                        <div class="col-md-6">
                            <div class="form-section">
                                <h5>Editar Ruta</h5>
                                <form>
                                    <div class="mb-3">
                                        <label for="rutaNombre" class="form-label">Nombre de la Ruta</label>
                                        <input type="text" class="form-control" id="rutaNombre" value="Ruta Histórica">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rutaDescripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="rutaDescripcion" rows="3">8 lugares históricos en el centro de la ciudad.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rutaPuntos" class="form-label">Puntos Totales</label>
                                        <input type="number" class="form-control" id="rutaPuntos" value="400">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-select">
                                            <option selected>Activa</option>
                                            <option>Inactiva</option>
                                            <option>En revisión</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ubicaciones en la Ruta</label>
                                        <div class="map-container">
                                            <div id="route-map"></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    <button type="button" class="btn btn-danger">Eliminar Ruta</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Sitios de Interés -->
            <div class="tab-pane fade" id="sitios" role="tabpanel">
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4><i class="fas fa-map-marker-alt me-2"></i>Sitios de Interés</h4>
                        <div>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevoSitioModal">
                                <i class="fas fa-plus me-1"></i> Nuevo Sitio
                            </button>
                            <div class="search-box d-inline-block">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" placeholder="Buscar sitios...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Ubicación</th>
                                    <th>Rutas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>3001</td>
                                    <td>Catedral de la Ciudad</td>
                                    <td>Monumento</td>
                                    <td>Plaza Central, 1</td>
                                    <td>Ruta Histórica</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3002</td>
                                    <td>Puente Antiguo</td>
                                    <td>Monumento</td>
                                    <td>Río Ciudad</td>
                                    <td>Ruta Histórica</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3003</td>
                                    <td>Mural Comunitario</td>
                                    <td>Arte Urbano</td>
                                    <td>Calle Arte, 15</td>
                                    <td>Arte Urbano</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="tab-pane fade" id="suscripciones" role="tabpanel">
                <div class="admin-card p-4">
                    <h4><i class="fas fa-id-card me-2"></i>Gestión de Suscripciones</h4>
                    <p class="text-muted mb-4">Administra los diferentes tipos de suscripciones disponibles para usuarios y partners.</p>

                    <ul class="nav nav-tabs mb-4" id="subscriptionTypeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="usuarios-sub-tab" data-bs-toggle="tab" data-bs-target="#usuarios-sub" type="button">
                                <i class="fas fa-users me-1"></i> Usuarios
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="partners-sub-tab" data-bs-toggle="tab" data-bs-target="#partners-sub" type="button">
                                <i class="fas fa-store me-1"></i> Partners
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Suscripciones para Usuarios -->
                        <div class="tab-pane fade show active" id="usuarios-sub" role="tabpanel">
                            <div class="row">
                                <!-- Suscripción Básica -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Básica</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_user_1">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_user_1" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Básica">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="4.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Acceso a rutas básicas</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>3 puntos de interés diarios</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Soporte básico</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Suscripción Premium -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Premium</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_user_2">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_user_2" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Premium">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="9.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Acceso a todas las rutas</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>10 puntos de interés diarios</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Soporte prioritario</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Descuentos en partners</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Suscripción Familiar -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Familiar</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_user_3">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_user_3" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Familiar">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="14.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Todas las ventajas Premium</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Hasta 5 usuarios</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Control parental</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Descuentos exclusivos</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Suscripciones para Partners -->
                        <div class="tab-pane fade" id="partners-sub" role="tabpanel">
                            <div class="row">
                                <!-- Suscripción Básica Partner -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Básica</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_partner_1">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_partner_1" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Básica Partner">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="19.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Listado básico en la app</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Hasta 3 promociones</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Soporte básico</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Suscripción Estándar Partner -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Estándar</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_partner_2">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_partner_2" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Estándar Partner">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="39.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Listado destacado</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Hasta 10 promociones</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Estadísticas básicas</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Soporte prioritario</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Suscripción Premium Partner -->
                                <div class="col-md-4">
                                    <div class="subscription-type-card">
                                        <h5>Suscripción Premium</h5>
                                        <form>
                                            <input type="hidden" name="subscription_id" value="sub_partner_3">
                                            <div class="mb-3">
                                                <label class="form-label">ID de Suscripción</label>
                                                <input type="text" class="form-control" value="sub_partner_3" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="name" value="Premium Partner">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Precio (€/mes)</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="79.99">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Características</label>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Listado destacado en primera posición</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Promociones ilimitadas</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Estadísticas avanzadas</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Soporte 24/7</span>
                                                </div>
                                                <div class="subscription-feature">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Inclusión en rutas premium</span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nueva pestaña para Códigos QR -->
            <div class="tab-pane fade" id="qr" role="tabpanel">
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4><i class="fas fa-qrcode me-2"></i>Gestión de Códigos QR</h4>
                        <div>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevoQrModal">
                                <i class="fas fa-plus me-1"></i> Generar QR
                            </button>
                            <div class="search-box d-inline-block">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" placeholder="Buscar códigos QR...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Imagen QR</th>
                                    <th>Ubicación</th>
                                    <th>Ruta Asociada</th>
                                    <th>Puntos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>QR001</td>
                                    <td>TRA-HIS-001</td>
                                    <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=TRA-HIS-001" alt="QR Code"></td>
                                    <td>Catedral de la Ciudad</td>
                                    <td>Ruta Histórica</td>
                                    <td>50</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info action-btn">Descargar</button>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Desactivar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>QR002</td>
                                    <td>TRA-GAS-001</td>
                                    <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=TRA-GAS-001" alt="QR Code"></td>
                                    <td>Café Central</td>
                                    <td>Gastronomía Local</td>
                                    <td>30</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info action-btn">Descargar</button>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-danger action-btn">Desactivar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>QR003</td>
                                    <td>TRA-ART-001</td>
                                    <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=TRA-ART-001" alt="QR Code"></td>
                                    <td>Mural Comunitario</td>
                                    <td>Arte Urbano</td>
                                    <td>40</td>
                                    <td><span class="status-badge status-blocked">Inactivo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info action-btn">Descargar</button>
                                        <button class="btn btn-sm btn-warning action-btn">Editar</button>
                                        <button class="btn btn-sm btn-success action-btn">Activar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

           <!-- Pestaña de Configuración -->
           <?php

            $email = $_SESSION["usuario"];
            $adminNombre = "";
            $stmt = $_conexion->prepare("SELECT nombre FROM administradores WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $adminNombre = $admin['nombre'];
            }   
           
           ?>

           <div class="tab-pane fade" id="configuracion" role="tabpanel">
                <div class="admin-card p-4">
                    <h4 class="mb-4"><i class="fas fa-cog me-2"></i>Configuración del Administrador</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-section">
                                <h5><i class="fas fa-user-shield me-2"></i>Perfil de Administrador</h5>
                                <form action="conexiones/configuracion.php" id="formuAdmin" method="post">
                                    <div class="mb-3">
                                        <label for="adminNombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="adminNombre" name="adminNombre" value="<?php echo $adminNombre?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="adminEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="adminEmail" id="adminEmail" value="<?php echo $_SESSION["usuario"] ?>" disabled>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-section">
                                <h5><i class="fas fa-lock me-2"></i>Seguridad</h5>
                                <form>
                                    <div class="mb-3">
                                        <label for="currentPassword" class="form-label">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="currentPassword">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="newPassword">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="confirmPassword">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Ruta -->
    <div class="modal fade" id="nuevaRutaModal" tabindex="-1" aria-labelledby="nuevaRutaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaRutaModalLabel">Crear Nueva Ruta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nuevaRutaNombre" class="form-label">Nombre de la Ruta</label>
                            <input type="text" class="form-control" id="nuevaRutaNombre" placeholder="Ej: Ruta Histórica">
                        </div>
                        <div class="mb-3">
                            <label for="nuevaRutaDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="nuevaRutaDescripcion" rows="3" placeholder="Descripción detallada de la ruta"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nuevaRutaPuntos" class="form-label">Puntos Totales</label>
                            <input type="number" class="form-control" id="nuevaRutaPuntos" placeholder="Ej: 400">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sitios de Interés</label>
                            <select class="form-select" multiple>
                                <option selected>Catedral de la Ciudad</option>
                                <option>Puente Antiguo</option>
                                <option>Museo Municipal</option>
                                <option>Torre del Reloj</option>
                                <option>Plaza Mayor</option>
                                <option>Mural Comunitario</option>
                                <option>Parque Central</option>
                            </select>
                            <small class="text-muted">Mantén presionada la tecla Ctrl para seleccionar múltiples sitios.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mapa de la Ruta</label>
                            <div class="map-container">
                                <div id="nueva-ruta-map"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Crear Ruta</button>
                </div>
            </div>
        </div>
    </div>
         <!-- Modal Nuevo Código QR -->
    <div class="modal fade" id="nuevoQrModal" tabindex="-1" aria-labelledby="nuevoQrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoQrModalLabel">Generar Nuevo Código QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="qrIdentificador" class="form-label">Identificador Único</label>
                            <input type="text" class="form-control" id="qrIdentificador" placeholder="Ej: TRA-HIS-001">
                        </div>
                        <div class="mb-3">
                            <label for="qrUbicacion" class="form-label">Ubicación Asociada</label>
                            <select class="form-select" id="qrUbicacion">
                                <option selected>Seleccionar ubicación...</option>
                                <option>Catedral de la Ciudad</option>
                                <option>Puente Antiguo</option>
                                <option>Café Central</option>
                                <option>Mural Comunitario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qrRuta" class="form-label">Ruta Asociada</label>
                            <select class="form-select" id="qrRuta">
                                <option selected>Seleccionar ruta...</option>
                                <option>Ruta Histórica</option>
                                <option>Gastronomía Local</option>
                                <option>Arte Urbano</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qrPuntos" class="form-label">Puntos Otorgados</label>
                            <input type="number" class="form-control" id="qrPuntos" value="50">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vista Previa QR</label>
                            <div class="text-center p-3 bg-light rounded">
                                <img id="qrPreview" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TRA-SAMPLE" alt="Vista previa QR" class="img-fluid mb-2">
                                <p class="small text-muted">El código QR se generará automáticamente al guardar</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Generar Código QR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Nuevo Sitio -->
    <div class="modal fade" id="nuevoSitioModal" tabindex="-1" aria-labelledby="nuevoSitioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoSitioModalLabel">Agregar Sitio de Interés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               

    <!-- Bootstrap JS mahareta -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script>
    <script>
        // Inicialización de mapas (simulado)
        function initMap() {
            console.log("Mapas inicializados (simulación)");
        }
        
        // Activar tooltips y popovers de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Actualizar vista previa del QR cuando cambia el identificador
        document.getElementById('qrIdentificador').addEventListener('input', function() {
            var identificador = this.value || 'TRA-SAMPLE';
            document.getElementById('qrPreview').src = 
                'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(identificador);
        });
    </script>
</body>

</html>