   <?php
       error_reporting( E_ALL );
       ini_set( "display_errors", 1 );
      
       //para conectar con la base de datos
       require('../util/conexion.php');


       //averiguamos si está abierta la sesion
       session_start();
       if(!isset($_SESSION["usuario"])){
           $iniciado=false;//usaremos el booleano para indicar si la sesion esta iniciada o no
           echo "<h4>NO SE INICIA LA SESION</h4>";
       }
       else{
           $iniciado=true;


           // Preparar consulta segura con PDO
           $sql = "SELECT * FROM comercios WHERE email = :email";
           $stmt = $_conexion->prepare($sql);
           $stmt->bindParam(':email', $_SESSION["usuario"]);
           $stmt->execute();
           $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


           $sql2 = "SELECT * FROM suscripcion_comercios WHERE id_suscripcion = :id_suscripcion";
           $stmt = $_conexion->prepare($sql2);
           $stmt->bindParam(':id_suscripcion', $resultado["id_suscripcion"]);
           $stmt->execute();
           $suscripcion = $stmt->fetch(PDO::FETCH_ASSOC);
       }
   ?>


<!DOCTYPE html>
<html lang="es">


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trady Partners - Panel de Control</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (iconos) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- Google Charts -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <style>
       :root {
           --partner-primary: #2575fc;
           --partner-secondary: #6a11cb;
           --partner-dark: #1a1a2e;
           --partner-light: #f8f9fa;
           --partner-success: #00b09b;
       }


       body {
           background: linear-gradient(135deg, var(--partner-primary), var(--partner-secondary));
           color: white;
           font-family: 'Arial', sans-serif;
       }


       .partner-card {
           background: rgba(255, 255, 255, 0.1);
           backdrop-filter: blur(10px);
           border-radius: 15px;
           border: 1px solid rgba(255, 255, 255, 0.2);
           transition: transform 0.3s;
       }


       .partner-card:hover {
           transform: scale(1.03);
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


       .qr-generator-btn {
           background: linear-gradient(90deg, var(--partner-success), #96c93d);
           border: none;
           border-radius: 50px;
           font-weight: bold;
           padding: 10px 25px;
           box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
       }


       .stats-card {
           text-align: center;
           padding: 20px;
           border-radius: 10px;
           margin-bottom: 15px;
       }


       .stats-card .number {
           font-size: 2.5rem;
           font-weight: bold;
           margin: 10px 0;
       }


       .stats-card .label {
           font-size: 0.9rem;
           opacity: 0.8;
       }


       .recent-visitors {
           max-height: 300px;
           overflow-y: auto;
       }


       .visitor-item {
           display: flex;
           align-items: center;
           padding: 10px;
           border-bottom: 1px solid rgba(255, 255, 255, 0.1);
       }


       .visitor-item img {
           width: 40px;
           height: 40px;
           border-radius: 50%;
           margin-right: 10px;
       }


       .visitor-info {
           flex-grow: 1;
       }


       .visitor-points {
           background: rgba(255, 255, 255, 0.2);
           padding: 3px 10px;
           border-radius: 20px;
           font-size: 0.8rem;
       }


       .campaign-card {
           background: rgba(0, 0, 0, 0.2);
           border-radius: 10px;
           padding: 15px;
           margin-bottom: 15px;
           transition: all 0.3s;
       }


       .campaign-card:hover {
           background: rgba(0, 0, 0, 0.3);
           transform: translateY(-3px);
       }


       .campaign-progress {
           height: 8px;
           border-radius: 4px;
       }


       .premium-badge {
           background: linear-gradient(90deg, gold, #ffd700);
           color: #1a1a2e;
           padding: 3px 10px;
           border-radius: 15px;
           font-size: 0.8rem;
           font-weight: bold;
           display: inline-block;
       }


       .chart-container {
           height: 300px;
           width: 100%;
           border-radius: 15px;
           background: rgba(255, 255, 255, 0.1);
           padding: 15px;
       }


       .location-card {
           position: relative;
           overflow: hidden;
           border-radius: 10px;
           height: 150px;
           margin-bottom: 15px;
       }


       .location-overlay {
           position: absolute;
           bottom: 0;
           left: 0;
           right: 0;
           background: rgba(0, 0, 0, 0.7);
           padding: 10px;
       }


       .location-image {
           width: 100%;
           height: 100%;
           object-fit: cover;
       }
   </style>
</head>


<body>
   <!-- Barra de Navegación -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
       <div class="container">
           <a class="navbar-brand fw-bold" href="#">
               <i class="qr-icon"><img src="../util/img/trady_sinFondo.png" alt="logo trady" width="70" height="70"></i>TRADY PARTNERS
           </a>
           <div class="d-flex align-items-center">
               <span class="me-3">Nivel: <strong>Partner Oro</strong></span>
               <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
           </div>
       </div>
   </nav>


   <!-- Contenido Principal -->
   <div class="container my-5">
       <div class="row">
           <!-- Sección Perfil y Estadísticas -->
           <div class="col-md-4 mb-4">
               <div class="partner-card p-4 text-center">
                   <h3><?php echo $_SESSION["nombre_usuario"]?></h3>
                   <p class="text-muted">Partner desde: <?php echo $resultado["fecha_alta"]?></p>
                   <span class="premium-badge mb-3">PARTNER PREMIUM</span>
                   <a class="btn btn-danger" href="cerrar_sesion.php">Cerrar Sesión</a>


                   <!-- Pestañas de partner -->
                   <ul class="nav nav-tabs justify-content-center mt-3" id="partnerTabs" role="tablist">
                       <li class="nav-item" role="presentation">
                           <button class="nav-link active" id="stats-tab" data-bs-toggle="tab"
                               data-bs-target="#stats" type="button" role="tab">Estadísticas</button>
                       </li>
                       <li class="nav-item" role="presentation">
                           <button class="nav-link" id="business-tab" data-bs-toggle="tab" data-bs-target="#business"
                               type="button" role="tab">Negocio</button>
                       </li>
                       <li class="nav-item" role="presentation">
                           <button class="nav-link" id="subscription-tab" data-bs-toggle="tab"
                               data-bs-target="#subscription" type="button" role="tab">Suscripción</button>
                       </li>
                   </ul>


                   <div class="tab-content mt-3">
                       <!-- Pestaña de Estadísticas -->
                       <div class="tab-pane fade show active" id="stats" role="tabpanel">
                           <div class="row text-center mt-3">
                               <div class="col-6">
                                   <div class="stats-card" style="background: rgba(0, 176, 155, 0.2);">
                                       <i class="fas fa-users"></i>
                                       <div class="number">142</div>
                                       <div class="label">Visitantes</div>
                                   </div>
                               </div>
                               <div class="col-6">
                                   <div class="stats-card" style="background: rgba(106, 17, 203, 0.2);">
                                       <i class="fas fa-qrcode"></i>
                                       <div class="number">87</div>
                                       <div class="label">Escaneos</div>
                                   </div>
                               </div>
                               <div class="col-6">
                                   <div class="stats-card" style="background: rgba(255, 138, 0, 0.2);">
                                       <i class="fas fa-star"></i>
                                       <div class="number">4.7</div>
                                       <div class="label">Valoración</div>
                                   </div>
                               </div>
                               <div class="col-6">
                                   <div class="stats-card" style="background: rgba(37, 117, 252, 0.2);">
                                       <i class="fas fa-redo"></i>
                                       <div class="number">63%</div>
                                       <div class="label">Repetidores</div>
                                   </div>
                               </div>
                           </div>
                       </div>


                       <!-- Pestaña de Negocio -->
                       <div class="tab-pane fade" id="business" role="tabpanel">
                           <div class="text-start mt-3">
                               <div class="mb-3">
                                   <label class="form-label">Nombre del Negocio:</label>
                                   <p class="form-control bg-transparent text-white"><?php echo $_SESSION["nombre_usuario"]?></p>
                               </div>
                               <div class="mb-3">
                                   <label class="form-label">Categoría:</label>
                                   <p class="form-control bg-transparent text-white"><?php echo $resultado["tipo"]?></p>
                               </div>
                               <div class="mb-3">
                                   <label class="form-label">Dirección:</label>
                                   <p class="form-control bg-transparent text-white"><?php echo $resultado["direccion"]?></p>
                               </div>
                               <div class="mb-3">
                                   <label class="form-label">Teléfono:</label>
                                   <p class="form-control bg-transparent text-white"><?php echo $resultado["telefono"]?></p>
                               </div>
                               <a href="editar-info.php" class="btn btn-sm btn-outline-light w-100">Editar Información</a>
                           </div>
                       </div>


                       <!-- Pestaña de Suscripción -->
                       <div class="tab-pane fade" id="subscription" role="tabpanel">
                           <div class="mt-3 text-start">
                               <h5 class="mb-3">Tu Suscripción Partner</h5>


                               <div class="partner-card p-3 mb-3">
                                   <div class="d-flex justify-content-between align-items-center">
                                       <div>
                                           <h6 class="mb-1"><?php
                                           if($resultado["id_suscripcion"]==1){
                                               echo "Gratis";
                                           }elseif($resultado["id_suscripcion"]==2){
                                               echo "Plata";
                                           }elseif($resultado["id_suscripcion"]==3){
                                               echo "Oro";
                                           }
                                       ?></h6>
                                       </div>
                                       <span class="badge bg-success">Activa</span>
                                   </div>
                                   <div class="d-flex justify-content-between mt-3">
                                       <div>
                                           <small>Próximo pago:</small>
                                           <h5 class="mb-0"><?php echo $suscripcion["precio"];?>€</h5>
                                       </div>
                                       <a href="suscripcion-partner.html" class="btn btn-sm btn-outline-danger">Cambiar</a>
                                   </div>
                               </div>
                               <a href="suscripcion-partner.html" class="btn btn-sm btn-outline-light w-100">
                                   <i class="fas fa-chart-line me-1"></i> Ver planes avanzados
                               </a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>


           <!-- Sección Principal del Partner -->
           <div class="col-md-8">
               <!-- Generador de QR y Campañas -->
               <div class="partner-card p-4 mb-4">
                   <div class="d-flex justify-content-between align-items-center mb-4">
                       <h2><i class="fas fa-qrcode me-2"></i>Tu Código QR</h2>
                       <a href="misQR.html" class="btn btn-outline-light">
                           <i class="fas fa-plus me-1"></i>Nuevo QR
                       </a>
                   </div>
                   <div class="row">
                       <div class="col-md-4 mb-3">
                           <div class="location-card">
                               <img src="https://via.placeholder.com/300x150?text=QR+Bar" alt="Bar" class="location-image">
                               <div class="location-overlay">
                                   <h6 class="mb-0">QR Barra</h6>
                                   <small>32 escaneos</small>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>


               <!-- Estadísticas y Visitantes -->
               <div class="row">
                   <div class="col-md-8 mb-4">
                       <div class="partner-card p-4 h-100">
                           <h4><i class="fas fa-chart-line me-2"></i>Estadísticas</h4>
                           <div class="chart-container mt-3" id="statsChart">
                               <!-- Gráfico se cargará aquí -->
                           </div>
                       </div>
                   </div>
                   <div class="col-md-4 mb-4">
                       <div class="partner-card p-4 h-100">
                           <h4><i class="fas fa-users me-2"></i>Últimos Visitantes</h4>
                           <div class="recent-visitors mt-3">
                               <div class="visitor-item">
                                   <img src="maria.jpg" alt="Visitante">
                                   <div class="visitor-info">
                                       <div>María G.</div>
                                       <small>Ayer 20:15</small>
                                   </div>
                                   <span class="visitor-points">+20 pts</span>
                               </div>
                               <div class="visitor-item">
                                   <img src="carlos.jpg" alt="Visitante">
                                   <div class="visitor-info">
                                       <div>Carlos M.</div>
                                       <small>Ayer 19:30</small>
                                   </div>
                                   <span class="visitor-points">+15 pts</span>
                               </div>
                               <div class="visitor-item">
                                   <img src="ana.jpg" alt="Visitante">
                                   <div class="visitor-info">
                                       <div>Ana T.</div>
                                       <small>Ayer 14:45</small>
                                   </div>
                                   <span class="visitor-points">+10 pts</span>
                               </div>
                               <div class="visitor-item">
                                   <img src="javier.jpg" alt="Visitante">
                                   <div class="visitor-info">
                                       <div>Javier L.</div>
                                       <small>15/11 21:10</small>
                                   </div>
                                   <span class="visitor-points">+20 pts</span>
                               </div>
                               <div class="visitor-item">
                                   <img src="Aurelia.jpg" alt="Visitante">
                                   <div class="visitor-info">
                                       <div>Aurelia R.</div>
                                       <small>15/11 13:20</small>
                                   </div>
                                   <span class="visitor-points">+15 pts</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>


               <!-- Campañas y Promociones -->
               <div class="partner-card p-4 mb-4">
                   <div class="d-flex justify-content-between align-items-center mb-4">
                       <h2><i class="fas fa-bullhorn me-2"></i>Tus Campañas</h2>
                       <a href="gestionar-campanias.html" class="btn btn-sm btn-outline-light">
                           <i class="fas fa me-1"></i>Gestionar Campañas
                       </a>
                   </div>


                   <div class="campaign-card">
                       <div class="d-flex justify-content-between">
                           <div>
                               <h5 class="mb-1">Happy Hour - 2x1 en Cócteles</h5>
                               <small class="text-muted">Activa hasta: 30/11/2023</small>
                           </div>
                           <span class="badge bg-success">Activa</span>
                       </div>
                       <div class="d-flex justify-content-between small mt-2">
                           <span>15/50 reclamaciones</span>
                           <span>30% completado</span>
                       </div>
                       <div class="progress campaign-progress mt-2">
                           <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"></div>
                       </div>
                   </div>


                   <div class="campaign-card">
                       <div class="d-flex justify-content-between">
                           <div>
                               <h5 class="mb-1">Descuento 10% Primera Visita</h5>
                               <small class="text-muted">Activa hasta: 15/12/2023</small>
                           </div>
                           <span class="badge bg-success">Activa</span>
                       </div>
                       <div class="d-flex justify-content-between small mt-2">
                           <span>8/100 reclamaciones</span>
                           <span>8% completado</span>
                       </div>
                       <div class="progress campaign-progress mt-2">
                           <div class="progress-bar bg-info" role="progressbar" style="width: 8%"></div>
                       </div>
                   </div>


                   <div class="campaign-card">
                       <div class="d-flex justify-content-between">
                           <div>
                               <h5 class="mb-1">Menú Degustación Especial</h5>
                               <small class="text-muted">Finalizada: 31/10/2023</small>
                           </div>
                           <span class="badge bg-secondary">Finalizada</span>
                       </div>
                       <div class="d-flex justify-content-between small mt-2">
                           <span>42/40 reclamaciones</span>
                           <span>105% completado</span>
                       </div>
                       <div class="progress campaign-progress mt-2">
                           <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>


   <!-- Footer -->
   <footer class="bg-dark bg-opacity-75 text-center py-3 mt-5">
       <div class="container">
           <p class="mb-0">© 2025 Trady Partners - Panel de Control para Negocios</p>
       </div>
   </footer>


   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


   <!-- Script para gráficos -->
   <script>
       // Cargar la API de visualización de Google
       google.charts.load('current', {'packages':['corechart']});
       google.charts.setOnLoadCallback(drawCharts);


       function drawCharts() {
           // Gráfico de estadísticas
           var statsData = google.visualization.arrayToDataTable([
               ['Día', 'Visitantes', 'Escaneos'],
               ['Lun', 12, 8],
               ['Mar', 15, 10],
               ['Mié', 18, 12],
               ['Jue', 10, 7],
               ['Vie', 22, 15],
               ['Sáb', 35, 25],
               ['Dom', 30, 20]
           ]);


           var statsOptions = {
               backgroundColor: 'transparent',
               colors: ['#6a11cb', '#00b09b'],
               legend: {textStyle: {color: 'white'}},
               hAxis: {textStyle: {color: 'white'}},
               vAxis: {textStyle: {color: 'white'}, gridlines: {color: 'rgba(255,255,255,0.1)'}},
               chartArea: {width: '80%', height: '70%'}
           };


           var statsChart = new google.visualization.LineChart(document.getElementById('statsChart'));
           statsChart.draw(statsData, statsOptions);
       }


       // Redibujar gráficos cuando cambie el tamaño de la ventana
       window.addEventListener('resize', drawCharts);
   </script>
</body>


</html>