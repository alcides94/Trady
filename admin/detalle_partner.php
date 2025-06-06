<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady Admin - Detalles de Partner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="../util/css/style-admin-partner.css">

    <?php 
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
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
            <a class="navbar-brand fw-bold" href="#">
                <img src="trady_sinFondo.png" alt="Trady Logo" width="40" class="me-2">Trady Admin
            </a>
            <div class="d-flex align-items-center">
                <div class="user-menu d-flex align-items-center text-white">
                    <img src="https://via.placeholder.com/40" alt="Admin Avatar">
                    <span>Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Partners</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalles del Partner</li>
            </ol>
        </nav>

        <!-- Partner Header -->
        <div class="partner-header">
            <img src="https://via.placeholder.com/100" alt="Logo del Partner" class="partner-logo">
            <div>
                <h3>Café Central <span class="status-badge status-active">Activo</span></h3>
                <p class="mb-1"><i class="fas fa-store"></i> Cafetería | <i class="fas fa-map-marker-alt"></i> Calle Principal, 123</p>
                <p class="mb-1"><i class="fas fa-envelope"></i> contacto@cafecentral.com | <i class="fas fa-phone"></i> +34 123 456 789</p>
                <div class="partner-stats">
                    <span class="stat-item"><i class="fas fa-users"></i> 245 visitas</span>
                    <span class="stat-item"><i class="fas fa-star"></i> 4.8/5 (128)</span>
                    <span class="stat-item"><i class="fas fa-qrcode"></i> 156 escaneos</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información del Partner -->
            <div class="col-md-6">
                <div class="admin-card p-4">
                    <h4><i class="fas fa-info-circle me-2"></i>Información General</h4>
                    
                    <div class="form-section">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Establecimiento</label>
                                    <input type="text" class="form-control" value="Café Central">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Negocio</label>
                                    <select class="form-select">
                                        <option selected>Cafetería</option>
                                        <option>Restaurante</option>
                                        <option>Bar</option>
                                        <option>Panadería</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" rows="3">Cafetería tradicional con más de 50 años de historia, especializada en cafés de origen y repostería casera.</textarea>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email de contacto</label>
                                    <input type="email" class="form-control" value="contacto@cafecentral.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" value="+34 123 456 789">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Horario</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Apertura</label>
                                        <input type="time" class="form-control" value="08:00">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Cierre</label>
                                        <input type="time" class="form-control" value="20:00">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select">
                                    <option selected>Activo</option>
                                    <option>Pendiente</option>
                                    <option>Bloqueado</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Logo del Establecimiento</label>
                                <input type="file" class="form-control">
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                            <button type="button" class="btn btn-outline-secondary">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Ubicación y Rutas -->
            <div class="col-md-6">
                <div class="admin-card p-4">
                    <h4><i class="fas fa-map-marked-alt me-2"></i>Ubicación</h4>
                    
                    <div class="map-container">
                        <div id="partner-map"></div>
                    </div>
                    
                    <div class="form-section">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" value="Calle Principal, 123">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" value="28001">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" value="Madrid">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">País</label>
                                    <input type="text" class="form-control" value="España">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Coordenadas (Lat, Long)</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="40.4168" placeholder="Latitud">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="-3.7038" placeholder="Longitud">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <h4 class="mt-4"><i class="fas fa-route me-2"></i>Rutas Asociadas</h4>
                    
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ruta Gastronómica</h5>
                                <span class="badge bg-primary rounded-pill">Activa</span>
                            </div>
                            <p class="mb-1">5 establecimientos con comida tradicional</p>
                            <small>300 puntos totales</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Ruta del Café</h5>
                                <span class="badge bg-primary rounded-pill">Activa</span>
                            </div>
                            <p class="mb-1">Las mejores cafeterías de la ciudad</p>
                            <small>250 puntos totales</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas y Actividad -->
        <div class="admin-card p-4 mt-3">
            <h4><i class="fas fa-chart-line me-2"></i>Estadísticas y Actividad</h4>
            
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="admin-card p-3 text-center">
                        <h5>Visitas este mes</h5>
                        <h2 class="text-primary">68</h2>
                        <small class="text-success"><i class="fas fa-caret-up"></i> 12% más que el mes pasado</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-card p-3 text-center">
                        <h5>Escaneos QR</h5>
                        <h2 class="text-success">42</h2>
                        <small class="text-success"><i class="fas fa-caret-up"></i> 8% más que el mes pasado</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-card p-3 text-center">
                        <h5>Valoración media</h5>
                        <h2 class="text-warning">4.8 <small>/5</small></h2>
                        <small>Basado en 128 valoraciones</small>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="admin-card p-3">
                        <h5 class="mb-3">Visitas por día (últimos 30 días)</h5>
                        <div style="height: 300px;">
                            <!-- Aquí iría un gráfico de visitas -->
                            <canvas id="visitsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Comentarios y Valoraciones -->
        <div class="admin-card p-4 mt-3">
            <h4><i class="fas fa-comments me-2"></i>Comentarios y Valoraciones</h4>
            
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Valoración</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2" width="30">
                                    <span>María López</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </td>
                            <td>El mejor café de la ciudad, sin duda. Ambiente muy acogedor.</td>
                            <td>15/06/2023</td>
                            <td>
                                <button class="btn btn-sm btn-danger action-btn">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2" width="30">
                                    <span>Carlos Ruiz</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </td>
                            <td>Buen café pero el servicio podría mejorar.</td>
                            <td>10/06/2023</td>
                            <td>
                                <button class="btn btn-sm btn-danger action-btn">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inicialización del mapa (simulado)
        document.addEventListener('DOMContentLoaded', function() {
            // Simulación de mapa
            const mapElement = document.getElementById('partner-map');
            mapElement.innerHTML = '<div style="width:100%;height:100%;background:#eee;display:flex;align-items:center;justify-content:center;color:#666;"><i class="fas fa-map-marked-alt fa-3x"></i><p class="ms-2">Mapa interactivo de ubicación</p></div>';
            
            // Gráfico de visitas
            const ctx = document.getElementById('visitsChart').getContext('2d');
            const visitsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
                    datasets: [{
                        label: 'Visitas diarias',
                        data: [2, 3, 1, 4, 2, 3, 5, 2, 4, 3, 2, 1, 3, 4, 2, 3, 4, 2, 3, 1, 2, 4, 3, 2, 1, 3, 4, 2, 3, 4],
                        borderColor: '#2c3e50',
                        backgroundColor: 'rgba(44, 62, 80, 0.1)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>