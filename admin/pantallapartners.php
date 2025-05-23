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
                <button class="btn btn-primary">
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
                                        <td><img src="<?php echo $comercio["imagen"]?>" alt="Logo Partner" class="partner-img"></td>
                                        <td><?php  echo $comercio["nombre"]?></td>
                                        <td><?php echo  $comercio["tipo"]?></td>
                                        <td><?php echo  $comercio["direccion"]?></td>
                                        <td><?php echo  $comercio["telefono"]?></td>
                                        <td>
                                            <?php echo  $comercio["nombre_suscripcion"]?>
                                        </td>
                                        <td>
                                            <?php if($comercio['estado'] == 1){ ?>
                                                <span class="status-pending"><i class="fas fa-clock"></i> Pendiente</span>
                                            <?php } else if ($comercio['estado'] == 2){ ?>
                                                <span class="status-active"><i class="fas fa-check-circle"></i> Activo</span>
                                            <?php } else { ?>
                                                <span class="status-inactive"><i class="fas fa-times-circle"></i> Inactivo</span>
                                            <?php } ?>

                                        </td> 
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
                    <form id="partnerForm" action="comercios/nuevo_comercio.php" method="post" enctype="multipart/form-data">
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
                                    <option value="Restaurante">Restaurante</option>
                                    <option value="Alojamiento">Alojamiento</option>
                                    <option value="Comercio">Comercio</option>
                                    <option value="Ocio">Ocio</option>
                                    <option value="Bar">Bar</option>
                                    <option value="Otro">Otro</option>
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
                                <label for="metodoPago" class="form-label">Metodo de Pago</label>
                                <select class="form-select" id="metodoPago" name="metodoPago" required>
                                    <option value="" selected disabled>Seleccione un Metodo de Pago</option>   
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="PayPal">PayPal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ruta" class="form-label">Ruta</label>
                                <select class="form-select" id="ruta" name="ruta" required>
                                    <option value="" selected disabled>Seleccione una Ruta</option>
                                    <option value="Ruta Tapeo">Ruta Tapeo</option>
                                    <option value="Ruta de los Miradores">Ruta de los Miradores</option>
                                    <option value="Ruta de los Pueblos">Ruta de los Pueblos</option>
                                    <option value="Ruta de Ocio">Ruta de Ocio</option>
                                    <option value="Otro">Otro</option>
                                </select>
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
                                <input type="hidden" name="imagenUrl" id="imagenUrl">
                            </div>

                            <div class="col-md-6">
                                <label for="id_suscripcion" class="form-label">Suscripcion</label>
                                <select class="form-select" id="id_suscripcion" name="id_suscripcion" required>
                                    <option value="" selected disabled>Seleccione una Suscripcion</option>
                                    <?php 
                                        $sql = "SELECT * FROM suscripcion_comercios";
                                        $stmt = $_conexion->prepare($sql);
                                        $stmt->execute();
                                        $sus_comercios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($sus_comercios as $sus_comercio) {
                                    ?>    
                                        <option value="<?php echo $sus_comercio["id_suscripcion"] ?>"><?php echo $sus_comercio["nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="1" selected>Pendiente</option>
                                    <option value="2">Activo</option>
                                    <option value="3">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
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
                    <form id="Edit_partnerForm" action="comercios/editar_comercio.php" method="post" enctype="multipart/form-data">
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
                                    <option value="Restaurante">Restaurante</option>
                                    <option value="Alojamiento">Alojamiento</option>
                                    <option value="Comercio">Comercio</option>
                                    <option value="Ocio">Ocio</option>
                                    <option value="Bar">Bar</option>
                                    <option value="Otro">Otro</option>
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
                                <label for="edit_metodoPago" class="form-label">Metodo de Pago</label>
                                <select class="form-select" id="edit_metodoPago" name="edit_metodoPago" required>
                                    <option value="" selected disabled>Seleccione un Metodo de Pago</option>   
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="PayPal">PayPal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_ruta" class="form-label">Ruta</label>
                                <select class="form-select" id="edit_ruta" name="edit_ruta" required>
                                    <option value="" selected disabled>Seleccione una Ruta</option>
                                    <option value="Ruta Tapeo">Ruta Tapeo</option>
                                    <option value="Ruta de los Miradores">Ruta de los Miradores</option>
                                    <option value="Ruta de los Pueblos">Ruta de los Pueblos</option>
                                    <option value="Ruta de Ocio">Ruta de Ocio</option>
                                    <option value="Otro">Otro</option>
                                </select>
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
                                <input type="hidden" name="edit_imagenUrl" id="edit_imagenUrl">
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
                                <select class="form-select" id="edit_estado" name="edit_estado">
                                    <option value="1">Pendiente</option>
                                    <option value="2">Activo</option>
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



                //SUBIR LA IMAGEN A LA API Y TRAERME LA URL 

            const imgbbApiKey = '2a005bfb265d236c9ea4993e01934b48';

            $('#partnerForm').on('submit', function(e) {
                e.preventDefault();
                
                const imgArchivo = $('#imagen')[0];
                if (!imgArchivo.files.length) {
                    // Si no hay imagen, enviar el formulario directamente
                    this.submit();
                    return;
                }

                const file = imgArchivo.files[0];
                const formData = new FormData();
                formData.append('image', file);

                // Subir imagen a ImgBB
                $.ajax({
                    url: `https://api.imgbb.com/1/upload?key=${imgbbApiKey}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            $('#imagenUrl').val(data.data.url);
                            // Enviar el formulario original
                            $('#partnerForm').off('submit').submit();
                        } else {
                            alert('Error al subir la imagen a ImgBB');
                        }
                    },
                    error: function() {
                        alert('Error al conectar con el servicio de imágenes');
                    }
                });
            });

            /* PARA EDITAR LA IAMGEN */

            $('#Edit_partnerForm').on('submit', function(e) {
                e.preventDefault();
                
                const imgArchivo = $('#edit_imagen')[0];
                if (!imgArchivo.files.length) {
                    // Si no hay imagen, enviar el formulario directamente
                    this.submit();
                    return;
                }

                const file = imgArchivo.files[0];
                const formData = new FormData();
                formData.append('image', file);

                // Subir imagen a ImgBB
                $.ajax({
                    url: `https://api.imgbb.com/1/upload?key=${imgbbApiKey}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success) {
                            $('#edit_imagenUrl').val(data.data.url);
                            // Enviar el formulario original
                            $('#Edit_partnerForm').off('submit').submit();
                        } else {
                            alert('Error al subir la imagen a ImgBB');
                        }
                    },
                    error: function() {
                        alert('Error al conectar con el servicio de imágenes');
                    }
                });
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
                    $('#edit_metodoPago').val(data.metodoPago);
                    $('#edit_ruta').val(data.ruta);
                    $('#edit_telefono').val(data.telefono);
                    $('#edit_email').val(data.email);
                    $('#edit_latitud').val(data.latitud);
                    $('#edit_longitud').val(data.longitud);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_id_suscripcion').val(data.id_suscripcion);
                    $('#edit_estado').val(data.estado);
                    // Mostrar el modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editSitioModal'));
                    modal.hide();

                })
               
            });
            



        });
    </script>
</body>

</html>