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
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#statsModal">
                            <i class="fas fa-chart-bar me-1"></i> Estadísticas
                        </button>
                        <a href="panel-admin.php">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            VOLVER
                        </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Suscripciones -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
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
                                        <th>Usuario</th>
                                        <th>Tipo</th>
                                        <th>Inicio</th>
                                        <th>Vencimiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos para usuarios -->
                                    <tr>
                                        <td>US-1001</td>
                                        <td>usuario1@email.com</td>
                                        <td><span class="badge bg-info subscription-badge">Premium</span></td>
                                        <td>01/10/2023</td>
                                        <td>01/11/2023</td>
                                        <td><span class="badge bg-success">Activa</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>US-1002</td>
                                        <td>usuario2@email.com</td>
                                        <td><span class="badge bg-warning text-dark subscription-badge">Básica</span></td>
                                        <td>15/09/2023</td>
                                        <td>15/10/2023</td>
                                        <td><span class="badge bg-secondary">Expirada</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Renovar">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>US-1003</td>
                                        <td>usuario3@email.com</td>
                                        <td><span class="badge bg-info subscription-badge">Premium</span></td>
                                        <td>20/09/2023</td>
                                        <td>20/12/2023</td>
                                        <td><span class="badge bg-success">Activa</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-store me-2"></i> Suscripciones de Partners
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="partnerSubscriptionsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Partner</th>
                                        <th>Plan</th>
                                        <th>Inicio</th>
                                        <th>Vencimiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ejemplo de datos estáticos para partners -->
                                    <tr>
                                        <td>PT-2001</td>
                                        <td>Restaurante La Parrilla</td>
                                        <td><span class="badge bg-primary subscription-badge">Empresarial</span></td>
                                        <td>05/10/2023</td>
                                        <td>05/01/2024</td>
                                        <td><span class="badge bg-success">Activa</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" title="Cancelar">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PT-2002</td>
                                        <td>Hotel Playa</td>
                                        <td><span class="badge bg-secondary subscription-badge">Estándar</span></td>
                                        <td>10/09/2023</td>
                                        <td>10/10/2023</td>
                                        <td><span class="badge bg-warning text-dark">Por vencer</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Renovar">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PT-2003</td>
                                        <td>Tienda de Regalos</td>
                                        <td><span class="badge bg-secondary subscription-badge">Estándar</span></td>
                                        <td>01/08/2023</td>
                                        <td>01/09/2023</td>
                                        <td><span class="badge bg-danger">Vencida</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success" title="Renovar">
                                                <i class="fas fa-sync-alt"></i>
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

        <!-- Tarjetas de Resumen -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Usuarios Activos</h6>
                                <h3 class="mb-0">42</h3>
                            </div>
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Partners Activos</h6>
                                <h3 class="mb-0">18</h3>
                            </div>
                            <i class="fas fa-store fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Por Vencer (7 días)</h6>
                                <h3 class="mb-0">5</h3>
                            </div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">Vencidas</h6>
                                <h3 class="mb-0">7</h3>
                            </div>
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
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
                    <form id="subscriptionForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="subscriptionType" class="form-label">Tipo de Suscripción</label>
                                <select class="form-select" id="subscriptionType" required>
                                    <option value="" selected disabled>Seleccione tipo</option>
                                    <option value="user">Usuario</option>
                                    <option value="partner">Partner</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionTarget" class="form-label">Usuario/Partner</label>
                                <select class="form-select" id="subscriptionTarget" required>
                                    <option value="" selected disabled>Seleccione primero el tipo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionPlan" class="form-label">Plan</label>
                                <select class="form-select" id="subscriptionPlan" required>
                                    <option value="" selected disabled>Seleccione plan</option>
                                    <option value="basic">Básico</option>
                                    <option value="standard">Estándar</option>
                                    <option value="premium">Premium</option>
                                    <option value="enterprise">Empresarial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionDuration" class="form-label">Duración</label>
                                <select class="form-select" id="subscriptionDuration" required>
                                    <option value="1">1 Mes</option>
                                    <option value="3" selected>3 Meses</option>
                                    <option value="6">6 Meses</option>
                                    <option value="12">1 Año</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionStart" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="subscriptionStart" required>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionEnd" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" id="subscriptionEnd" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionPrice" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control" id="subscriptionPrice" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="subscriptionStatus" class="form-label">Estado</label>
                                <select class="form-select" id="subscriptionStatus" required>
                                    <option value="active" selected>Activa</option>
                                    <option value="pending">Pendiente</option>
                                    <option value="canceled">Cancelada</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="subscriptionNotes" class="form-label">Notas</label>
                                <textarea class="form-control" id="subscriptionNotes" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveSubscriptionBtn">Guardar Suscripción</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estadísticas -->
    <div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statsModalLabel"><i class="fas fa-chart-bar me-2"></i>Estadísticas de Suscripciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-chart-pie me-2"></i> Distribución por Plan
                                </div>
                                <div class="card-body">
                                    <canvas id="plansChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-chart-line me-2"></i> Nuevas Suscripciones (últimos 6 meses)
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <i class="fas fa-table me-2"></i> Resumen de Ingresos
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Activas</th>
                                                    <th>Ingreso Mensual</th>
                                                    <th>Ingreso Anual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Usuarios</td>
                                                    <td>42</td>
                                                    <td>1.260 €</td>
                                                    <td>15.120 €</td>
                                                </tr>
                                                <tr>
                                                    <td>Partners</td>
                                                    <td>18</td>
                                                    <td>2.700 €</td>
                                                    <td>32.400 €</td>
                                                </tr>
                                                <tr class="table-active">
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>60</strong></td>
                                                    <td><strong>3.960 €</strong></td>
                                                    <td><strong>47.520 €</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Exportar
                    </button>
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
            $('#subscriptionType').change(function() {
                const type = $(this).val();
                const $targetSelect = $('#subscriptionTarget');
                
                $targetSelect.empty().append('<option value="" selected disabled>Cargando...</option>');
                
                // Simular carga de datos
                setTimeout(function() {
                    $targetSelect.empty().append('<option value="" selected disabled>Seleccione una opción</option>');
                    
                    if (type === 'user') {
                        $targetSelect.append('<option value="1">usuario1@email.com</option>');
                        $targetSelect.append('<option value="2">usuario2@email.com</option>');
                        $targetSelect.append('<option value="3">usuario3@email.com</option>');
                    } else if (type === 'partner') {
                        $targetSelect.append('<option value="101">Restaurante La Parrilla</option>');
                        $targetSelect.append('<option value="102">Hotel Playa</option>');
                        $targetSelect.append('<option value="103">Tienda de Regalos</option>');
                    }
                }, 500);
            });

            // Calcular fecha de fin basada en duración
            $('#subscriptionDuration, #subscriptionStart').change(function() {
                const duration = parseInt($('#subscriptionDuration').val());
                const startDate = $('#subscriptionStart').val();
                
                if (duration && startDate) {
                    const start = new Date(startDate);
                    const end = new Date(start);
                    end.setMonth(start.getMonth() + duration);
                    
                    // Formatear fecha como YYYY-MM-DD
                    const endStr = end.toISOString().split('T')[0];
                    $('#subscriptionEnd').val(endStr);
                }
            });

            // Manejar el botón de guardar suscripción
            $('#saveSubscriptionBtn').click(function() {
                // Aquí iría la lógica para guardar la suscripción
                alert('Suscripción guardada correctamente (simulación)');
                $('#newSubscriptionModal').modal('hide');
                $('#subscriptionForm')[0].reset();
            });

            // Configurar gráficos cuando se abre el modal de estadísticas
            $('#statsModal').on('shown.bs.modal', function () {
                // Gráfico de torta - Distribución por plan
                const plansCtx = document.getElementById('plansChart').getContext('2d');
                const plansChart = new Chart(plansCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Básico', 'Estándar', 'Premium', 'Empresarial'],
                        datasets: [{
                            data: [15, 25, 30, 10],
                            backgroundColor: [
                                '#6c757d',
                                '#0dcaf0',
                                '#0d6efd',
                                '#6610f2'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // Gráfico de barras - Suscripciones mensuales
                const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
                const monthlyChart = new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [
                            {
                                label: 'Usuarios',
                                data: [5, 7, 10, 8, 6, 9],
                                backgroundColor: '#0d6efd'
                            },
                            {
                                label: 'Partners',
                                data: [2, 3, 5, 4, 3, 4],
                                backgroundColor: '#198754'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>