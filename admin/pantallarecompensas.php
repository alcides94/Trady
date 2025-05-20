<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Recompensas</title>
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
        .reward-card {
            transition: all 0.3s ease;
            border-top: 3px solid;
        }
        .reward-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .reward-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
        }
        .reward-badge {
            font-size: 0.8rem;
        }
        .status-active {
            color: #28a745;
        }
        .status-inactive {
            color: #dc3545;
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
                    <h2><i class="fas fa-gift me-2"></i> Gestión de Recompensas</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRewardModal">
                        <i class="fas fa-plus me-1"></i> Nueva Recompensa
                    </button>
                </div>
                <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <!-- Listado de Recompensas -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-list me-2"></i> Listado de Recompensas
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="rewardsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Puntos</th>
                                        <th>QRs a Escanear</th>
                                        <th>Fecha Alta</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM recompensas";
                                        $stmt = $_conexion->prepare($sql);
                                        $stmt->execute();
                                        $recompensas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($recompensas as $recompensa) {
                                    ?>
                                    <tr>
                                        <td><?php echo $recompensa["id_recompensas"]?></td>
                                        <td><?php echo $recompensa["nombre"]?></td>
                                        <td><?php echo $recompensa["puntos"]?></td>
                                        <td><?php echo $recompensa["qrs_escanear"]?></td>
                                        <td><?php echo $recompensa["fecha_alta"]?></td>
                                        <td>
                                            <?php if($recompensa["estado"] == 1): ?>
                                                <span class="status-active"><i class="fas fa-check-circle"></i> Activa</span>
                                            <?php else: ?>
                                                <span class="status-inactive"><i class="fas fa-times-circle"></i> Inactiva</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-info btn-editar" 
                                                data-id="<?php echo $recompensa['id_recompensas']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editRewardModal" 
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form action="recompensas/eliminar_recompensa.php" method="post" style="display: inline;">
                                                <input type="hidden" name="id_recompensa" value="<?php echo $recompensa['id_recompensas']; ?>">
                                                <button class="btn btn-sm btn-danger" title="Eliminar" type="submit">
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
    </div>

    <!-- Modal para nueva recompensa -->
    <div class="modal fade" id="newRewardModal" tabindex="-1" aria-labelledby="newRewardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newRewardModalLabel"><i class="fas fa-gift me-2"></i>Nueva Recompensa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newRewardForm" action="recompensas/nueva_recompensa.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="nombre" class="form-label">Nombre de la Recompensa</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="puntos" class="form-label">Puntos a otorgar</label>
                                <input type="number" class="form-control" id="puntos" name="puntos" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="qrs_escanear" class="form-label">QRs a escanear</label>
                                <input type="number" class="form-control" id="qrs_escanear" name="qrs_escanear" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="1" selected>Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Recompensa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar recompensa -->
    <div class="modal fade" id="editRewardModal" tabindex="-1" aria-labelledby="editRewardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRewardModalLabel"><i class="fas fa-gift me-2"></i>Editar Recompensa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRewardForm" action="recompensas/editar_recompensa.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="edit_nombre" class="form-label">Nombre de la Recompensa</label>
                                <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_puntos" class="form-label">Puntos requeridos</label>
                                <input type="number" class="form-control" id="edit_puntos" name="edit_puntos" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_qrs_escanear" class="form-label">QRs a escanear</label>
                                <input type="number" class="form-control" id="edit_qrs_escanear" name="edit_qrs_escanear" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_estado" class="form-label">Estado</label>
                                <select class="form-select" id="edit_estado" name="edit_estado" required>
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="edit_id_recompensa" id="edit_id_recompensa">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#rewardsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                order: [[0, 'desc']]
            });

            // Configurar botones de edición 
            $('.btn-editar').on('click', function () {
                const id = $(this).data('id');

                fetch(`recompensas/obtener_recompensa.php?id_recompensa=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert('No se encontró la recompensa');
                            return;
                        }

                        $('#edit_id_recompensa').val(data.id_recompensas);
                        $('#edit_nombre').val(data.nombre);
                        $('#edit_puntos').val(data.puntos);
                        $('#edit_qrs_escanear').val(data.qrs_escanear);
                        $('#edit_estado').val(data.estado);
                    })
                    .catch(err => {
                        console.error('Error al obtener datos de la recompensa:', err);
                        alert('No se pudo cargar la información de la recompensa');
                    });
            });
        });
    </script>
</body>
</html>