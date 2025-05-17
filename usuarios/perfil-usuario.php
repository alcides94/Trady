<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trady - ¡Encuentra, Escanea, Gana!</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Maps API -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script> -->

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        :root {
            --game-primary: #6a11cb;
            --game-secondary: #2575fc;
            --game-dark: #1a1a2e;
            --game-light: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, var(--game-primary), var(--game-secondary));
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .game-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s;
        }

        .game-card:hover {
            transform: scale(1.03);
        }

        .progress {
            height: 20px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.2);
        }

        .progress-bar {
            background: linear-gradient(90deg, #ff8a00, #ff0058);
        }

        .badge-icon {
            font-size: 2rem;
            color: gold;
            margin-bottom: 10px;
        }

        .qr-scanner-btn {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
            border-radius: 50px;
            font-weight: bold;
            padding: 10px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .map-container {
            height: 300px;
            border-radius: 15px;
            /* overflow: hidden; */
            position: relative;
        }

        #map {
            height: 100%;
            width: 100%;
            border-radius: 15px;
        }

        .map-fallback {
            display: none;
            height: 100%;
            width: 100%;
            background: url('https://maps.googleapis.com/maps/api/staticmap?center=36.7213,-4.4214&zoom=13&size=600x300&maptype=roadmap&markers=color:red%7C36.7213,-4.4214&key=TU_API_KEY') no-repeat center center;
            background-size: cover;
        }

        .map-error {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            border-radius: 15px;
        }

        .nav-tabs .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border: none;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link.active {
            color: white;
            background: transparent;
            border-bottom: 2px solid white;
        }

        .route-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .route-card:hover {
            background: rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }

        .route-progress {
            height: 8px;
            border-radius: 4px;
        }

        .subscription-card {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #6a11cb;
        }

        .payment-method {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .payment-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #6a11cb;
        }

        .plan-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .plan-card:hover {
            border-color: #6a11cb;
            transform: translateY(-3px);
        }

        .plan-card.featured {
            border: 2px solid gold;
            position: relative;
        }

        .featured-badge {
            position: absolute;
            top: -10px;
            right: 15px;
            background: gold;
            color: #1a1a2e;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i></i>TRADY
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3">Puntos: <strong>1,250</strong></span>
                <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container my-5">
        <div class="row">
            <!-- Sección Perfil y Progreso -->
            <div class="col-md-4 mb-4">
                <div class="game-card p-4 text-center">
                    <img src="https://via.placeholder.com/100" alt="Avatar" class="rounded-circle mb-3" width="100">
                    <h3>¡Hola, Cazador!</h3>
                    <p class="text-muted">Nivel 5 - Explorador Avanzado</p>

                    <!-- Pestañas de perfil -->
                    <ul class="nav nav-tabs justify-content-center mt-3" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="progress-tab" data-bs-toggle="tab"
                                data-bs-target="#progress" type="button" role="tab">Progreso</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab">Perfil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="subscription-tab" data-bs-toggle="tab"
                                data-bs-target="#subscription" type="button" role="tab">Suscripción</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="routes-tab" data-bs-toggle="tab" data-bs-target="#routes"
                                type="button" role="tab">Rutas</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Pestaña de Progreso -->
                        <div class="tab-pane fade show active" id="progress" role="tabpanel">
                            <div class="my-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Progreso:</span>
                                    <span>1,250/2,000 pts</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: 62.5%"></div>
                                </div>
                            </div>

                            <div class="my-4">
                                <h5><i class="fas fa-trophy me-2"></i>Insignias</h5>
                                <div class="d-flex justify-content-around mt-3">
                                    <div><i class="fas fa-medal badge-icon"></i><br>Oro</div>
                                    <div><i class="fas fa-star badge-icon"></i><br>Explorador</div>
                                    <div><i class="fas fa-bolt badge-icon"></i><br>Rápido</div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña de Perfil -->
                        <div class="tab-pane fade" id="profile" role="tabpanel">
                            <div class="text-start mt-3">
                                <div class="mb-3">
                                    <label class="form-label">Nombre:</label>
                                    <p class="form-control bg-transparent text-white">Juan Pérez</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <p class="form-control bg-transparent text-white">juan.perez@example.com</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Miembro desde:</label>
                                    <p class="form-control bg-transparent text-white">15 Marzo 2023</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">QR escaneados:</label>
                                    <p class="form-control bg-transparent text-white">27</p>
                                </div>
                                <a href="editar-perfil.html" class="btn btn-sm btn-outline-light w-100 mt-2">
                                    <i class="btn btn-sm btn-outline-light w-100">Editar Perfil</i> 
                                </a>
                                
                            </div>
                        </div>

                        <!-- Nueva Pestaña de Suscripción -->
                        <div class="tab-pane fade" id="subscription" role="tabpanel">
                            <div class="mt-3 text-start">
                                <h5 class="mb-3">Tu Suscripción</h5>

                                <div class="subscription-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Plan Premium</h6>
                                            <small class="text-muted">Renovación: 15/11/2023</small>
                                        </div>
                                        <span class="badge bg-success">Activa</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <small>Próximo pago:</small>
                                            <h5 class="mb-0">$9.99</h5>
                                        </div>
                                        <a href="suscripcion-usuario.html" class="btn btn-sm btn-outline-danger">Cambiar</a>
                                    </div>
                                </div>

                                <h5 class="mt-4 mb-3">Método de Pago</h5>

                                <div class="payment-method">
                                    <i class="fab fa-cc-visa payment-icon"></i>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span>Visa **** 4242</span>
                                            <small>Expira: 05/25</small>
                                        </div>
                                        <small class="text-muted">Principal</small>
                                    </div>
                                    <a href="../pagos/editar-pago.html" class="btn btn-sm btn-outline-light w-100 mt-2">
                                        <i class="btn btn-sm btn-outline-light ms-2"></i> Editar
                                    </a>
                                </div>

                                <a href="../pagos/aniadir-metodo-pago.html" class="btn btn-sm btn-outline-light w-100 mt-2">
                                    <i class="fas fa-plus me-1"></i> Añadir método de pago
                                </a>

                                <h5 class="mt-4 mb-3">Historial de Pagos</h5>
                                <div class="list-group">
                                    <div
                                        class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                        <div>
                                            <small>15/10/2023</small>
                                            <div>Plan Premium</div>
                                        </div>
                                        <span>$9.99</span>
                                    </div>
                                    <div
                                        class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                        <div>
                                            <small>15/09/2023</small>
                                            <div>Plan Premium</div>
                                        </div>
                                        <span>$9.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña de Rutas -->
                        <div class="tab-pane fade" id="routes" role="tabpanel">
                            <div class="mt-3 text-start">
                                <h5 class="mb-3">Tus Rutas</h5>

                                <div class="route-card">
                                    <div class="d-flex justify-content-between">
                                        <h6>Ruta Histórica</h6>
                                        <span class="badge bg-success">Activa</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mt-2">
                                        <span>3/8 lugares</span>
                                        <span>150/400 pts</span>
                                    </div>
                                    <div class="progress route-progress mt-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 37.5%"></div>
                                    </div>
                                </div>

                                <div class="route-card">
                                    <div class="d-flex justify-content-between">
                                        <h6>Gastronomía Local</h6>
                                        <span class="badge bg-secondary">Pendiente</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mt-2">
                                        <span>0/5 lugares</span>
                                        <span>0/300 pts</span>
                                    </div>
                                    <div class="progress route-progress mt-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>

                                <div class="route-card">
                                    <div class="d-flex justify-content-between">
                                        <h6>Arte Urbano</h6>
                                        <span class="badge bg-warning">En progreso</span>
                                    </div>
                                    <div class="d-flex justify-content-between small mt-2">
                                        <span>5/6 lugares</span>
                                        <span>350/400 pts</span>
                                    </div>
                                    <div class="progress route-progress mt-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 87.5%"></div>
                                    </div>
                                </div>

                                <a href="rutas.html" class="btn btn-sm btn-outline-light w-100 mt-2">
                                    <i class="fas fa-plus me-1"></i> Nueva Ruta
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Mapa y QR -->
            <div class="col-md-8">
                <div class="game-card p-4 mb-4">
                    <h2><i class="fas fa-map-marked-alt me-2"></i>Mapa de Caza</h2>
                    <p class="text-muted">Encuentra QR cerca de ti y gana puntos.</p>

                    <div class="map-container my-3">
                        <div id="map">

                            <script>
                                var map = L.map('map').setView([36.7213, -4.4214], 13);

                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                // Definir las ubicaciones de los marcadores
                                var markers = [
                                    { lat: 36.7213, lon: -4.4214, popupText: '¡Bienvenido a Málaga!' },
                                    { lat: 36.7300, lon: -4.4200, popupText: 'Lugar A - Información interesante.' },
                                    { lat: 36.7250, lon: -4.4300, popupText: 'Lugar B - Otro dato importante.' },
                                    { lat: 36.7200, lon: -4.4400, popupText: 'Lugar C - Escanea QR aquí.' }
                                ];

                                // Agregar los marcadores al mapa
                                markers.forEach(function(marker) {
                                    L.marker([marker.lat, marker.lon])
                                        .addTo(map)
                                        .bindPopup(marker.popupText);
                                });
                            </script>
                        </div>
                        <!-- <div id="map-fallback" class="map-fallback"></div> -->
                        <div id="map-error" class="map-error">
                            <!-- <i class="fas fa-map-marked-alt fa-3x mb-3"></i> -->
                            <h4>No se pudo cargar el mapa</h4>
                            <!-- <img src="MapaMalaga.png" alt="Bienvenido a Málaga" width="500"> -->
                            
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn qr-scanner-btn btn-lg">
                            <i class="fas fa-qrcode me-2"></i>Escanear QR
                        </button>
                    </div>
                </div>
            </div>

            <!-- Ranking y Desafíos -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="game-card p-4 h-100">
                        <h4><i class="fas fa-crown me-2"></i>Ranking</h4>
                        <ol class="list-group list-group-numbered mt-3">
                            <li class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                <span>Ana_Exploradora</span>
                                <span>3,450 pts</span>
                            </li>
                            <li class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                <span>CarlosQR</span>
                                <span>2,780 pts</span>
                            </li>
                            <li class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                <span>Tú</span>
                                <span class="fw-bold">1,250 pts</span>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="game-card p-4 h-100">
                        <h4><i class="fas fa-flag me-2"></i>Desafíos Activos</h4>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Escanea 5 QR en 24h</span>
                                <span class="badge bg-warning">50 pts</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Visita 3 locales</span>
                                <span class="badge bg-danger">100 pts</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Primer escaneo del día</span>
                                <span class="badge bg-success">20 pts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark bg-opacity-75 text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© 2025 Trady - ¡Encuentra, Escanea, Gana!</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para Google Maps -->
    
</body>

</html>