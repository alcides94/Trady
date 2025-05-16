<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Partners</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
        .partner-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
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
                    <h2><i class="fas fa-store me-2"></i> Gestión de Partners</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Partner
                    </button>
                </div>
                <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <!-- Tabla de Partners -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="partnersTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Ubicación</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos (en producción vendrían de la BD) -->
                                    <tr>
                                        <td>1</td>
                                        <td><img src="https://via.placeholder.com/60" alt="Logo Partner" class="partner-img"></td>
                                        <td>Restaurante La Parrilla</td>
                                        <td>Restaurante</td>
                                        <td>Calle Principal 123</td>
                                        <td>+34 600 123 456</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><img src="https://via.placeholder.com/60" alt="Logo Partner" class="partner-img"></td>
                                        <td>Hotel Playa</td>
                                        <td>Alojamiento</td>
                                        <td>Avenida del Mar 45</td>
                                        <td>+34 600 789 012</td>
                                        <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><img src="https://via.placeholder.com/60" alt="Logo Partner" class="partner-img"></td>
                                        <td>Tienda de Regalos</td>
                                        <td>Comercio</td>
                                        <td>Plaza Central 7</td>
                                        <td>+34 600 345 678</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
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

    <!-- Modal para añadir nuevo partner -->
    <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartnerModalLabel"><i class="fas fa-plus-circle me-2"></i>Nuevo Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="partnerForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="partnerName" class="form-label">Nombre del Partner</label>
                                <input type="text" class="form-control" id="partnerName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="partnerCategory" class="form-label">Categoría</label>
                                <select class="form-select" id="partnerCategory" required>
                                    <option value="" selected disabled>Seleccione una categoría</option>
                                    <option value="restaurante">Restaurante</option>
                                    <option value="alojamiento">Alojamiento</option>
                                    <option value="comercio">Comercio</option>
                                    <option value="ocio">Ocio</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="partnerEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="partnerEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="partnerPhone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="partnerPhone" required>
                            </div>
                            <div class="col-12">
                                <label for="partnerAddress" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="partnerAddress" required>
                            </div>
                            <div class="col-md-6">
                                <label for="partnerLogo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="partnerLogo" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="partnerStatus" class="form-label">Estado</label>
                                <select class="form-select" id="partnerStatus" required>
                                    <option value="active" selected>Activo</option>
                                    <option value="pending">Pendiente</option>
                                    <option value="inactive">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="partnerDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="partnerDescription" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="savePartnerBtn">Guardar Partner</button>
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
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#partnersTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            // Manejar el botón de guardar partner
            $('#savePartnerBtn').click(function() {
                // Aquí iría la lógica para guardar el partner
                alert('Partner guardado correctamente (simulación)');
                $('#addPartnerModal').modal('hide');
                $('#partnerForm')[0].reset();
            });
        });
    </script>
</body>

</html>