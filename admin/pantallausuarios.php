<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Gestión de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../util/css/style-panel-admin.css">
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

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-header">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="panel-admin.html">
                <img src="../util/img/trady_sinFondo.png" alt="Trady Logo" width="40" class="me-2">Trady Admin
            </a>
            <div class="d-flex align-items-center">
            <?php if (isset($_SESSION["usuario"])) { ?>
                        <h4>Bienvenido <?php echo $_SESSION["usuario"] ?></h4>
                        <a href="cerrar_sesion.php" class="btn btn-danger ms-3">Cerrar Sesión</a>
                    <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2><i class="fas fa-users me-2"></i> Gestión de Usuarios</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel-admin.html">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
                <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Listado de Usuarios</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            <i class="fas fa-plus me-1"></i> Nuevo Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaUsuarios" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Puntos</th>
                                        <th>Fecha Registro</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $sql = "SELECT id_usuario, nombre, email, fecha_nac, fecha_registro, puntos,estado FROM usuarios";
                                    $stmt = $_conexion->prepare($sql);
                                    $stmt->execute();
                                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($usuarios as $usuario) {

                                ?>
                                    <tr>
                                        <td><?php echo $usuario['id_usuario'] ?></td>
                                        <td><?php echo $usuario['nombre'] ?></td>
                                        <td><?php echo $usuario['email'] ?></td>
                                        <td><?php echo $usuario['fecha_nac'] ?></td>
                                        <td><?php echo $usuario['puntos'] ?></td>
                                        <td><?php echo $usuario['fecha_registro'] ?></td>
                                        <td><span class="badge bg-success"><?php echo $usuario['estado'] ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-editar" data-id="<?php echo $usuario['id_usuario']; ?>" data-bs-toggle="tooltip" title="Editar">
                                                    <input type="hidden" name="id_usuario" id="id_usuario">
                                                    <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="tooltip" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
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
        </div>
    </div>

    <!-- Modal Nuevo Usuario -->
    <div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoUsuarioModalLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoUsuario" action="conexiones/nuevo_usuario.php" method="post">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nac" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="rol" class="form-label">Suscripcion</label>
                                <select class="form-select" id="rol" name="id_suscripcion" required>
                                    <option value="1">Bronce</option>
                                    <option value="2">Plata</option>
                                    <option value="3">Oro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="activo" name="estado" checked>
                                    <label class="form-check-label" for="activo">
                                        Usuario activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarUsuario" action="conexiones/editar_usuario.php" method="post">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="e_nombre" name="e_nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="e_email" name="e_email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="e_telefono" name="e_telefono">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nac" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="e_fecha_nac" name="e_fecha_nac">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="id_suscripcion" class="form-label">Suscripcion</label>
                                <select class="form-select" id="e_id_suscripcion" name="e_id_suscripcion" required>
                                    <option value="1">Bronce</option>
                                    <option value="2">Plata</option>
                                    <option value="3">Oro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="e_password" name="e_password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="e_confirm_password" name="e_confirm_password" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="e_activo" name="e_estado" checked>
                                    <label class="form-check-label" for="activo">
                                        Usuario activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_usuario" id="id_usuario">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Editar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
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
        // Inicializar DataTable
        $(document).ready(function() {
            $('#tablaUsuarios').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                order: [[0, 'desc']]
            });
            
            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Configurar botones de edición en la tabla
            document.querySelectorAll('.btn-editar').forEach(boton => {
                boton.addEventListener('click', () => {
                    const idUsuario = boton.getAttribute('data-id');
                    
                    fetch('conexiones/editar_usuario.php?id_usuario=' + idUsuario)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                        alert('Error: ' + data.error);
                        return;
                        }

                        // Rellenar los campos del modal
                        document.getElementById('e_nombre').value = data.nombre;
                        document.getElementById('e_email').value = data.email;
                        document.getElementById('e_telefono').value = data.telefono;
                        document.getElementById('e_fecha_nac').value = data.fecha_nac;
                       // document.getElementById('id_suscripcion').value = data.id_suscripcion;
                        //document.getElementById('estado').value = data.estado;

                        // Mostrar el modal (si usás Bootstrap 5)
                        const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del usuario:', error);
                    });
                });
                });

            
            // Configurar botones de eliminación en la tabla
            $('.btn-outline-danger').on('click', function() {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const nombre = row.find('td:eq(1)').text();
                
                // Configurar el modal de confirmación
                $('#confirmarEliminarModal .modal-body').html(
                    `¿Estás seguro de que deseas eliminar al usuario <strong>${nombre}</strong> (ID: ${id})? Esta acción no se puede deshacer.`
                );
                
                // Configurar el botón de confirmar eliminación
                $('#btnConfirmarEliminar').off('click').on('click', function() {
                    alert(`Usuario ${id} eliminado correctamente (simulación)`);
                    $('#confirmarEliminarModal').modal('hide');
                    row.fadeOut(300, function() { $(this).remove(); });
                });
                
                $('#confirmarEliminarModal').modal('show');
            });
        });
    </script>
</body>

</html>