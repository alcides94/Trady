<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Códigos QR</title>
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
        .qr-card {
            transition: all 0.3s ease;
            border-top: 3px solid;
        }
        .qr-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .qr-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
        }
        .qr-badge {
            font-size: 0.8rem;
        }
        .usage-chart {
            height: 200px;
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
                    <h2><i class="fas fa-qrcode me-2"></i> Gestión de Códigos QR</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newQRModal">
                        <i class="fas fa-plus me-1"></i> Generar QR
                    </button>
                </div>
                <a href="panel-admin.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                </button>
                </a>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-dark h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Total QR Generados</h6>
                                <h3 class="mb-0">48</h3>
                            </div>
                            <i class="fas fa-qrcode fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">QR Activos</h6>
                                <h3 class="mb-0">36</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Escaneos Hoy</h6>
                                <h3 class="mb-0">124</h3>
                            </div>
                            <i class="fas fa-mobile-screen fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Escaneos Totales</h6>
                                <h3 class="mb-0">2,548</h3>
                            </div>
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de Códigos QR -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-list me-2"></i> Listado de Códigos QR
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="qrTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Código QR</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Asociado a</th>
                                        <th>Escaneos</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos -->
                                    <tr>
                                        <td>QR-1001</td>
                                        <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=TRA-1001" alt="QR Code" class="qr-img"></td>
                                        <td>QR Restaurante La Parrilla</td>
                                        <td><span class="badge bg-success qr-badge">Partner</span></td>
                                        <td>Restaurante La Parrilla</td>
                                        <td>428</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Desactivar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button class="btn btn-sm btn-dark" title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>QR-1002</td>
                                        <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=TRA-1002" alt="QR Code" class="qr-img"></td>
                                        <td>QR Ruta Histórica</td>
                                        <td><span class="badge bg-primary qr-badge">Ruta</span></td>
                                        <td>Ruta Histórica</td>
                                        <td>312</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Desactivar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button class="btn btn-sm btn-dark" title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>QR-1003</td>
                                        <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=TRA-1003" alt="QR Code" class="qr-img"></td>
                                        <td>QR Alcazaba</td>
                                        <td><span class="badge bg-warning text-dark qr-badge">Sitio</span></td>
                                        <td>Alcazaba de Málaga</td>
                                        <td>896</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Desactivar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button class="btn btn-sm btn-dark" title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>QR-1004</td>
                                        <td><img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=TRA-1004" alt="QR Code" class="qr-img"></td>
                                        <td>QR Evento Octubre</td>
                                        <td><span class="badge bg-info qr-badge">Evento</span></td>
                                        <td>Festival Gastronómico</td>
                                        <td>124</td>
                                        <td><span class="badge bg-secondary">Expirado</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Activar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-dark" title="Descargar">
                                                <i class="fas fa-download"></i>
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

    <!-- Modal para generar nuevo QR -->
    <div class="modal fade" id="newQRModal" tabindex="-1" aria-labelledby="newQRModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newQRModalLabel"><i class="fas fa-qrcode me-2"></i>Generar Nuevo Código QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="qrForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="qrName" class="form-label">Nombre del QR</label>
                                <input type="text" class="form-control" id="qrName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="qrType" class="form-label">Tipo de QR</label>
                                <select class="form-select" id="qrType" required>
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="partner">Partner</option>
                                    <option value="route">Ruta</option>
                                    <option value="site">Sitio de Interés</option>
                                    <option value="event">Evento</option>
                                    <option value="other">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="qrAssociation" class="form-label">Asociar a</label>
                                <select class="form-select" id="qrAssociation" required>
                                    <option value="" selected disabled>Seleccione primero el tipo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="qrIdentifier" class="form-label">Identificador</label>
                                <div class="input-group">
                                    <span class="input-group-text">TRA-</span>
                                    <input type="text" class="form-control" id="qrIdentifier" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="qrStatus" class="form-label">Estado</label>
                                <select class="form-select" id="qrStatus" required>
                                    <option value="active" selected>Activo</option>
                                    <option value="inactive">Inactivo</option>
                                    <option value="expired">Expirado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="qrExpiration" class="form-label">Fecha de Expiración</label>
                                <input type="date" class="form-control" id="qrExpiration">
                            </div>
                            <div class="col-12">
                                <label for="qrNotes" class="form-label">Notas</label>
                                <textarea class="form-control" id="qrNotes" rows="2"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-qrcode me-2"></i> Vista Previa del QR
                                    </div>
                                    <div class="card-body text-center">
                                        <img id="qrPreview" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TRA-SAMPLE" alt="QR Preview" class="img-fluid mb-3" style="max-width: 200px;">
                                        <div class="d-flex justify-content-center gap-3">
                                            <button type="button" class="btn btn-outline-dark" id="downloadQR">
                                                <i class="fas fa-download me-1"></i> Descargar PNG
                                            </button>
                                            <button type="button" class="btn btn-outline-dark" id="downloadSVG">
                                                <i class="fas fa-download me-1"></i> Descargar SVG
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveQRBtn">Guardar QR</button>
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
            $('#qrTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                columnDefs: [
                    { orderable: false, targets: [1, 7] } // Deshabilitar ordenación para columna de QR y Acciones
                ]
            });

            // Manejar cambio en tipo de QR
            $('#qrType').change(function() {
                const type = $(this).val();
                const $associationSelect = $('#qrAssociation');
                
                $associationSelect.empty().append('<option value="" selected disabled>Cargando...</option>');
                
                // Simular carga de datos según el tipo seleccionado
                setTimeout(function() {
                    $associationSelect.empty().append('<option value="" selected disabled>Seleccione una opción</option>');
                    
                    if (type === 'partner') {
                        $associationSelect.append('<option value="1">Restaurante La Parrilla</option>');
                        $associationSelect.append('<option value="2">Hotel Playa</option>');
                        $associationSelect.append('<option value="3">Tienda de Regalos</option>');
                    } else if (type === 'route') {
                        $associationSelect.append('<option value="101">Ruta Histórica</option>');
                        $associationSelect.append('<option value="102">Ruta Gastronómica</option>');
                        $associationSelect.append('<option value="103">Ruta Natural</option>');
                    } else if (type === 'site') {
                        $associationSelect.append('<option value="201">Alcazaba de Málaga</option>');
                        $associationSelect.append('<option value="202">Museo Picasso</option>');
                        $associationSelect.append('<option value="203">Catedral de Málaga</option>');
                    } else if (type === 'event') {
                        $associationSelect.append('<option value="301">Festival Gastronómico</option>');
                        $associationSelect.append('<option value="302">Feria de Abril</option>');
                    } else {
                        $associationSelect.append('<option value="401">Genérico 1</option>');
                        $associationSelect.append('<option value="402">Genérico 2</option>');
                    }
                }, 500);
            });

            // Actualizar vista previa del QR al cambiar el identificador
            $('#qrIdentifier').on('input', function() {
                const identificador = $(this).val() || 'SAMPLE';
                $('#qrPreview').attr('src', 
                    `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TRA-${identificador}`);
            });

            // Manejar descarga de QR
            $('#downloadQR').click(function() {
                const identificador = $('#qrIdentifier').val() || 'SAMPLE';
                const url = `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=TRA-${identificador}`;
                
                // Crear enlace temporal para descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = `QR-TRA-${identificador}.png`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });

            $('#downloadSVG').click(function() {
                const identificador = $('#qrIdentifier').val() || 'SAMPLE';
                const url = `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=TRA-${identificador}&format=svg`;
                
                // Crear enlace temporal para descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = `QR-TRA-${identificador}.svg`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });

            // Manejar el botón de guardar QR
            $('#saveQRBtn').click(function() {
                // Aquí iría la lógica para guardar el QR
                alert('Código QR guardado correctamente (simulación)');
                $('#newQRModal').modal('hide');
                $('#qrForm')[0].reset();
                // Restablecer la vista previa
                $('#qrPreview').attr('src', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TRA-SAMPLE');
            });
        });
    </script>
</body>

</html>