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
                                        <th>Identificador</th>
                                        <th>Acciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos -->

                                    <?php 
                                        $sql = "SELECT * FROM qr_codigos";
                                        $stmt = $_conexion->prepare($sql);
                                        $stmt->execute();
                                        $codigos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($codigos as $codigo) {
                                    ?>

                                    <tr>
                                        <td><?php echo $codigo["id_qr"]?> </td>
                                        
                                        <td><img src="<?php echo $codigo["qr"]?>" alt="QR Code" class="qr-img" ></td>
                                        <td><?php echo $codigo["nombre"]?> </td>
                                    
                                        <td><span class="badge bg-success qr-badge"><?php echo $codigo["tipo"]?> </span></td>
                                        <td><span class="badge bg-success">TRADY-<?php echo $codigo["identificador_qr"]?> </span></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-info btn-editar" 
                                                data-id="<?php echo $codigo['id_qr']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editQrModal" 
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            
                                            <button class="btn btn-sm btn-dark downloadQR" title="Descargar" data-id="<?php echo $codigo['identificador_qr']; ?>" >
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <form action="qr/eliminar_qr.php" method="post">
                                                <input type="hidden" name="id_qr" value="<?php echo $codigo['id_qr']; ?>">
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

    <!-- Modal para generar nuevo QR -->
    <div class="modal fade" id="newQRModal" tabindex="-1" aria-labelledby="newQRModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newQRModalLabel"><i class="fas fa-qrcode me-2"></i>Generar Nuevo Código QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newQr" action="qr/nuevo_qr.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del QR</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de QR</label>
                                <select class="form-select" id="tipo" name="tipo"required>
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Ruta">Ruta</option>
                                    <option value="Sitio de Interés">Sitio de Interés</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                          
                            <div class="col-md-6">
                                <label for="identificador_qr" class="form-label">Identificador</label>
                                <div class="input-group">
                                    <span class="input-group-text">TRADY-</span>
                                    <input type="text" class="form-control" id="identificador_qr" name ="identificador_qr" required>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="guardar">Guardar QR</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

<!-- Modal para generar Modificar QR -->
<div class="modal fade" id="editQrModal" tabindex="-1" aria-labelledby="editQrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQrModalLabel"><i class="fas fa-qrcode me-2"></i>Generar Nuevo Código QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newQr" action="qr/editar_qr.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del QR</label>
                                <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" >
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo de QR</label>
                                <select class="form-select" id="edit_tipo" name="edit_tipo">
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Ruta">Ruta</option>
                                    <option value="Sitio de Interés">Sitio de Interés</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                          
                            <div class="col-md-6">
                                <label for="identificador_qr" class="form-label">Identificador</label>
                                <div class="input-group">
                                    <span class="input-group-text">TRADY-</span>
                                    <input type="text" class="form-control" id="edit_identificador_qr" name ="edit_identificador_qr" >
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="edit_id_qr" id="edit_id_qr">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="guardar">Guardar QR</button>
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
            $('#qrTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });


            // Configurar botones de edición 
            
            $('.btn-editar').on('click', function () {
                const id = $(this).data('id');

                fetch(`qr/obtener-qr.php?id_qr=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert('No se encontró el QR');
                            return;
                        }

                        $('#edit_id_qr').val(data.id_qr);
                        $('#edit_nombre').val(data.nombre);
                        $('#edit_tipo').val(data.tipo);
                        $('#edit_identificador_qr').val(data.identificador_qr);

                        // Mostrar el modal
                       

                    })
                    .catch(err => {
                        console.error('Error al obtener datos del qr:', err);
                        alert('No se pudo cargar la información del sitio');
                    });
            });

        
            // Manejar descarga de QR
           
                
            $('.downloadQR').click(function() {
                const id = $(this).data('id');
                const url = `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=TRADY-${id}`;
                
                // Crear enlace temporal para descarga
                const a = document.createElement('a');
                a.href = url;
                a.download = `TRADY-${id}.png`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });

            
        });
    </script>
</body>

</html>