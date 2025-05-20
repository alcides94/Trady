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
                                        <th>Suscripcion</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos (en producción vendrían de la BD) -->

                                 
                                    <?php 
                                        $sql = "SELECT 
                                            c.*,
                                            c.nombre AS nombre_comercio,
                                            sc.nombre AS nombre_suscripcion
                                        FROM comercios c
                                        LEFT JOIN suscripcion_comercios sc ON c.id_suscripcion = sc.id_suscripcion
                                        ";
                                        $stmt = $_conexion->prepare($sql);
                                        $stmt->execute();
                                        $comercios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($comercios as $comercio) {
                                    ?>

                                    <tr>
                                        <td><?php echo $comercio["id_comercios"]?></td>
                                        <td><img src="<?php $comercio["imagen"]?>" alt="Logo Partner" class="partner-img"></td>
                                        <td><?php  echo $comercio["nombre"]?></td>
                                        <td><?php echo  $comercio["tipo"]?></td>
                                        <td><?php echo  $comercio["direccion"]?></td>
                                        <td><?php echo  $comercio["telefono"]?></td>
                                        <td>
                                            <?php echo  $comercio["nombre_suscripcion"]?>
                                        </td>
                                        <td><span class="badge bg-success"><?php  echo $comercio["estado"]?></span></td>
                                        <td class="action-btns">
                                            <button class="btn btn-sm btn-info btn-editar" 
                                                data-bs-toggle="modal" 
                                                data-id="<?php echo $comercio["id_comercios"] ?>"
                                                data-bs-target="#modificarPartner"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="comercios/eliminar_comercio.php" method="post" style="display: inline;">
                                                <input type="hidden" name="id_comercios" value="<?php echo $comercio['id_comercios']; ?>">
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

    <!-- Modal para añadir nuevo partner -->
    <div class="modal fade" id="addPartnerModal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartnerModalLabel"><i class="fas fa-plus-circle me-2"></i>Nuevo Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="partnerForm" action="comercios/nuevo_comercio.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del Partner</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cif" class="form-label">CIF</label>
                                <input type="text" class="form-control" id="cif" name="cif" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="" selected disabled>Seleccione una categoría</option>
                                    <option value="restaurante">Restaurante</option>
                                    <option value="alojamiento">Alojamiento</option>
                                    <option value="comercio">Comercio</option>
                                    <option value="ocio">Ocio</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="latitud" class="form-label">Latitud (-90 a 90)</label>
                                <input type="number" class="form-control" id="latitud" name="latitud">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="longitud" class="form-label">Longitud (-180 a 180)</label>
                                <input type="number" class="form-control" id="longitud" name="longitud">
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="id_suscripcion" class="form-label">Suscripcion</label>
                                <select class="form-select" id="id_suscripcion" name="id_suscripcion" required>
                                    <option value="" selected disabled>Seleccione una Suscripcion</option>
                                    <option value="1">Bronce</option>
                                    <option value="2">Plata</option>
                                    <option value="3">Oro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="partnerStatus" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="2">Pendiente</option>
                                    <option value="3">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="partnerDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="guardar">Guardar Partner</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal para modificar nuevo partner -->
    <div class="modal fade" id="modificarPartner" tabindex="-1" aria-labelledby="modificarPartnerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarPartnerLabel"><i class="fas fa-plus-circle me-2"></i>Modificar Partner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="partnerForm" action="comercios/editar_comercio.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit_nombre" class="form-label">Nombre del Partner</label>
                                <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_cif" class="form-label">CIF</label>
                                <input type="text" class="form-control" id="edit_cif" name="edit_cif" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="edit_tipo" name="edit_tipo" required>
                                    <option value="" selected disabled>Seleccione una categoría</option>
                                    <option value="restaurante">Restaurante</option>
                                    <option value="alojamiento">Alojamiento</option>
                                    <option value="comercio">Comercio</option>
                                    <option value="ocio">Ocio</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="edit_email"required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="edit_telefono" name="edit_telefono" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="edit_direccion" name="edit_direccion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_latitud" class="form-label">Latitud (-90 a 90)</label>
                                <input type="number" class="form-control" id="edit_latitud" name="edit_latitud">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="edit_longitud" class="form-label">Longitud (-180 a 180)</label>
                                <input type="number" class="form-control" id="edit_longitud" name="edit_longitud">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_imagen" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="edit_imagen" name="edit_imagen" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_id_suscripcion" class="form-label">Suscripcion</label>
                                <select class="form-select" id="edit_id_suscripcion" name="edit_id_suscripcion" required>
                                    <option value="" selected disabled>Seleccione una Suscripcion</option>
                                    <option value="1">Bronce</option>
                                    <option value="2">Plata</option>
                                    <option value="3">Oro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_estado" class="form-label">Estado</label>
                                <select class="form-select" id="edit_estado" name="edit_estado" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="2">Pendiente</option>
                                    <option value="3">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="edit_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="edit_descripcion" name="edit_descripcion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="edit_id_comercios" id="edit_id_comercios">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="modificar">Modificar Partner</button>
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
            $('#partnersTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            $('.btn-editar').on('click', function () {
                const id = $(this).data('id');

            // Llamada al backend para obtener los datos del sitio
            fetch(`comercios/obtener_comercio.php?id_comercios=${id}`)
                .then(res => res.json())
                .then(data => {
                    $('#edit_id_comercios').val(data.id_comercios);
                    $('#edit_cif').val(data.cif);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_tipo').val(data.tipo);
                    $('#edit_direccion').val(data.direccion);
                    $('#edit_telefono').val(data.telefono);
                    $('#edit_email').val(data.email);
                    $('#edit_latitud').val(data.latitud);
                    $('#edit_longitud').val(data.longitud);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_id_suscripcion').val(data.id_suscripcion);
                    $('#edit_estado').prop('checked', data.estado === 'activo');

                    // Mostrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSitioModal'));
                    modal.hide();

                })
               /* .catch(err => {
                    console.error('Error al obtener datos del sitio:', err);
                    alert('No se pudo cargar la información del sitio');
                });*/
            });
            



        });
    </script>
</body>

</html>