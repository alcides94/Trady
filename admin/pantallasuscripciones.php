<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Suscripciones</title>
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
        .subscription-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        .subscription-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .user-subscription {
            border-left-color: #0d6efd; /* Azul para usuarios */
        }
        .partner-subscription {
            border-left-color: #198754; /* Verde para partners */
        }
        .subscription-badge {
            font-size: 0.8rem;
        }
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
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
                    <h2><i class="fas fa-id-card me-2"></i> Gestión de Suscripciones</h2>
                    <div>
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#newSubscriptionModal">
                            <i class="fas fa-plus me-1"></i> Nueva Suscripción
                        </button>
                        
                        <a href="panel-admin.php">
                            <button class="btn btn-primary" >
                                VOLVER
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Suscripciones -->
        <div class="row mb-4">
            <div class="col-md-12 mb-6 mb-md-0">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-users me-2"></i> Suscripciones de Usuarios
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userSubscriptionsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos para usuarios -->

                                    <?php 
                                    $sql = "SELECT  id_suscripcion, nombre, precio FROM suscripcion_usuarios";
                                    $stmt = $_conexion->prepare($sql);
                                    $stmt->execute();
                                    $sus_usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($sus_usuarios as $sus_usuario) {

                                ?>


                                    <tr>
                                        <td><?php echo $sus_usuario["id_suscripcion"]?></td>
                                        <td><span class="badge bg-info subscription-badge"><?php echo $sus_usuario["nombre"]?></span></td>
                                        <td><span class="badge bg-success"><?php echo $sus_usuario["precio"]?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-editar-usuario" title="Editar" data-bs-toggle="modal" 
                                            data-bs-target="#editSuscripcionModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-store me-2"></i> Suscripciones de Partners / Comercios
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="partnerSubscriptionsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Plan</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos para partners -->
                                     <?php 
                                    $sql = "SELECT  id_suscripcion, nombre, precio FROM suscripcion_comercios";
                                    $stmt = $_conexion->prepare($sql);
                                    $stmt->execute();
                                    $sus_comercios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($sus_comercios as $sus_comercio) {

                                ?>


                                    <tr>
                                        <td><?php echo $sus_comercio["id_suscripcion"]?></td>
                                        <td><span class="badge bg-info subscription-badge"><?php echo $sus_comercio["nombre"]?></span></td>
                                        <td><span class="badge bg-success"><?php echo $sus_comercio["precio"]?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-editar-comercio" title="Editar" data-id="<?php echo $sus_comercio["id_suscripcion"]?>" data-bs-toggle="modal" 
                                            data-bs-target="#editSuscripcionModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal Nueva Suscripción -->
    <div class="modal fade" id="newSubscriptionModal" tabindex="-1" aria-labelledby="newSubscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newSubscriptionModalLabel"><i class="fas fa-plus-circle me-2"></i>Nueva Suscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="suscripcion" action="suscripcion/nuevo_sus.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="subscriptionType" class="form-label">Tipo de Suscripción</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="user">Usuario</option>
                                    <option value="partner">Partner</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input class="form-control" id="nombre" name="nombre" rows="2">
                            </div>

                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="saveSubscriptionBtn">Guardar Suscripción</button>
                            </div>           
                            
                        </div>
                
                    </form>
                </div>
                
            </div>
        </div>
    </div>



    <!-- Modal Modificar Suscripción -->
    <div class="modal fade" id="editSuscripcionModal" tabindex="-1" aria-labelledby="editSuscripcionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuscripcionModalLabel"><i class="fas fa-plus-circle me-2"></i>Modificar Suscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="suscripcion" action="suscripcion/editar_sus.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de Suscripción</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="user">Usuario</option>
                                    <option value="partner">Partner</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="edit_nombre" class="form-label">Nombre</label>
                                <input class="form-control" id="edit_nombre" name="edit_nombre" rows="2">
                            </div>

                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control" id="edit_precio" name="edit_precio" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" id="edit_id_suscripcion" name="edit_id_suscripcion" >
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="saveSubscriptionBtn">Guardar Suscripción</button>
                            </div>           
                            
                        </div>
                
                    </form>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#userSubscriptionsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
            
            $('#partnerSubscriptionsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            // Manejar cambio en tipo de suscripción
            $('.btn-editar-usuario').on('click', function () {
                const id = $(this).data('id');
            // Llamada al backend para obtener los datos del sitio
            fetch(`suscripcion/obtener_sus.php?id_suscripcion_usuario=${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#edit_id_suscripcion').val(data.id_suscripcion);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_precio').val(data.precio);
                    // Mostrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSuscripcionModal'));
                    modal.hide();

                })
                .catch(err => {
                    console.error('Error al obtener datos del sitio:', err);
                    alert('No se pudo cargar la información del sitio');
                });
         
            });

            $('.btn-editar-comercio').on('click', function () {
                const id = $(this).data('id');
            // Llamada al backend para obtener los datos del sitio
            fetch(`suscripcion/obtener_sus.php?id_suscripcion_comercio=${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#edit_id_suscripcion').val(data.id_suscripcion);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_precio').val(data.precio);
                    // Mostrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSuscripcionModal'));
                    modal.hide();

                })
                .catch(err => {
                    console.error('Error al obtener datos del sitio:', err);
                    alert('No se pudo cargar la información del sitio');
                });


         
            });

        });
    </script>
</body>

</html>