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
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-map-marker-alt me-2"></i> Gestión de Usuarios</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Usuario
                    </button>
                </div>
                <a href="panel-admin.php">
                <button class="btn btn-primary">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    
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
                                    $sql = "SELECT * FROM usuarios";
                                    $stmt = $_conexion->prepare($sql);
                                    $stmt->execute();
                                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($usuarios as $usuario) {

                                ?>
                                    <tr>
                                        <td><?php echo $usuario['id_usuario'] ?></td>
                                        <td><?php echo $usuario['nombre'] ?></td>
                                        <td><?php echo $usuario['email'] ?></td>
                                        <td><?php echo $usuario['telefono'] ?></td>
                                        <td><?php echo $usuario['puntos'] ?></td>
                                        <td><?php echo $usuario['fecha_registro'] ?></td>
                                        
                                        <td>
                                            <?php if($usuario['estado'] == 1){ ?>
                                                <span class="status-active"><i class="fas fa-check-circle"></i> Activo</span>
                                            <?php }else{ ?>
                                                <span class="status-inactive"><i class="fas fa-times-circle"></i> Inactiva</span>
                                            <?php } ?>
                                        </td>    
                                        
                                   
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-editar" data-id="<?php echo $usuario['id_usuario']; ?>" data-bs-toggle="tooltip" title="Editar">
                                                <input type="hidden" name="id_usuario" id="id_usuario">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="conexiones/eliminar_usuario.php" method="post" style="display: inline;">
                                                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario'] ?>">
                                                <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="tooltip" title="Eliminar" type="submit">     
                                                    <i class="fas fa-trash-alt"></i>
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
                                <label for="metodoPago" class="form-label">Metodo de Pago</label>
                                <select class="form-select" id="metodoPago" name="metodoPago" required>
                                    <option value="" selected disabled>Seleccione un Metodo de Pago</option>   
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="PayPal">PayPal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nac" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="rol" class="form-label">Suscripcion</label>
                                <select class="form-select" id="id_suscripcion" name="id_suscripcion" required>
                                    <option value="" selected disabled>Seleccione una Suscripcion</option>
                                    <?php 
                                        $sql = "SELECT * FROM suscripcion_usuarios";
                                        $stmt = $_conexion->prepare($sql);
                                        $stmt->execute();
                                        $sus_usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($sus_usuarios as $sus_usuario) {
                                    ?>    
                                        <option value="<?php echo $sus_usuario["id_suscripcion"] ?>"><?php echo $sus_usuario["nombre"] ?></option>
                                    <?php } ?>
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
                                <label for="metodoPago" class="form-label">Metodo de Pago</label>
                                <select class="form-select" id="e_metodoPago" name="e_metodoPago" required>
                                    <option value="" selected disabled>Seleccione un Metodo de Pago</option>   
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="PayPal">PayPal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nac" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="e_fecha_nac" name="e_fecha_nac">
                            </div>
                            <div class="col-md-6">
                                <label for="e_qrs_escaneados" class="form-label">Qrs Escaneados</label>
                                <input type="number" class="form-control" id="e_qrs_escaneados" name="e_qrs_escaneados">
                            </div>
                            <div class="col-md-6">
                                <label for="e_puntos" class="form-label">Puntos</label>
                                <input type="number" class="form-control" id="e_puntos" name="e_puntos">
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
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="e_password" name="e_password" >
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Repetir Contraseña</label>
                                <input type="password" class="form-control" id="e_confirm_password" name="e_confirm_password" >
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="e_estado" name="e_estado" >
                                    <label class="form-check-label" for="activo">
                                        Usuario activo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="e_id_usuario" id="e_id_usuario">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Editar Usuario</button>
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

            $('#formNuevoUsuario').on('submit', function (e) {
                // Obtener valores
                let password = $('#password').val();
                let confirmPassword = $('#confirm_password').val();

                // Eliminar clases previas
                $('#password, #confirm_password').removeClass('is-invalid');

                // Validar coincidencia
                if (password !== confirmPassword) {
                    e.preventDefault(); // Evita el envío
                    $('#confirm_password').addClass('is-invalid');

                    // Si querés, podés mostrar un mensaje adicional:
                    if ($('#errorPassMsg').length === 0) {
                        $('<div id="errorPassMsg" class="invalid-feedback d-block mt-2">Las contraseñas no coinciden.</div>')
                            .insertAfter('#confirm_password');
                    }
                } else {
                    // Si todo está bien, asegurate de quitar mensajes viejos
                    $('#errorPassMsg').remove();
                }
            });

            $('#editarUsuarioModal').on('submit', function (e) {
                let password = $('#e_password').val();
                let confirmPassword = $('#e_confirm_password').val();

                // Eliminar clases previas
                $('#e_password, #e_confirm_password').removeClass('is-invalid');

                // Validar coincidencia
                if (password !== confirmPassword) {
                    e.preventDefault(); // Evita el envío
                    $('#e_confirm_password').addClass('is-invalid');

                    // Si querés, podés mostrar un mensaje adicional:
                    if ($('#errorPassMsg').length === 0) {
                        $('<div id="errorPassMsg" class="invalid-feedback d-block mt-2">Las contraseñas no coinciden.</div>')
                            .insertAfter('#e_confirm_password');
                    }
                } else {
                    // Si todo está bien, asegurate de quitar mensajes viejos
                    $('#errorPassMsg').remove();
                }
            });

            // Configurar botones de edición en la tabla
            $(document).ready(function () {
                $('.btn-editar').on('click', async function () {
                    const idUsuario = $(this).data('id');

                    try {
                        const response = await fetch(`conexiones/obtener_usuario.php?id_usuario=${idUsuario}`);
                        const usuario = await response.json();

                        $('#e_id_usuario').val(usuario.id_usuario);
                        $('#e_nombre').val(usuario.nombre);
                        $('#e_email').val(usuario.email);
                        $('#e_telefono').val(usuario.telefono);
                        $('#e_fecha_nac').val(usuario.fecha_nac);
                        $('#e_qrs_escaneados').val(usuario.qrs_escaneados);
                        $('#e_puntos').val(usuario.puntos);
                        $('#e_metodoPago').val(usuario.metodoPago);
                        $('#e_id_suscripcion').val(usuario.id_suscripcion);
                        $('#e_estado').prop('checked', usuario.estado === 1);

                        const modal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
                        modal.show();

                    } catch (error) {
                        console.error('Error al obtener los datos del usuario:', error);
                    }
                });
            });


        });
    </script>
</body>

</html>