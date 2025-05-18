<?php
   error_reporting( E_ALL );
   ini_set( "display_errors", 1 );
  
   //para conectar con la base de datos
   require('../util/conexion.php');


   //averiguamos si está abierta la sesion
   session_start();
   if(!isset($_SESSION["usuario"])){
       $iniciado=false;//usaremos el booleano para indicar si la sesion esta iniciada o no
       header("Location: login.php");
       exit();
   }
   else{
       $iniciado=true;


       // Preparar consulta segura con PDO
       $sql = "SELECT * FROM comercios WHERE email = :email";
       $stmt = $_conexion->prepare($sql);
       $stmt->bindParam(':email', $_SESSION["usuario"]);
       $stmt->execute();
       $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $nombre = $_POST["name"];
       $correo = $_POST["email"];
       $telefono = $_POST["phone"];
       $direccion = $_POST["direccion"];
       $cont = 0; // Contador de validaciones
       // Validación del nombre
       if (!preg_match("/^[a-zA-Z0-9 ]{3,16}$/", $nombre)) {
           echo "<h4>Nombre inválido. Debe contener solo letras y/o numeros (3-16 caracteres).</h4>";
       } else {
           $cont++;
       }
       // Validación del teléfono
       if (!preg_match('/^[0-9]{7,15}$/', $telefono)) {
           echo "<h4>Teléfono inválido. Debe tener entre 7 y 15 dígitos.</h4>";
       } else {
           $cont++;
       }
       // Si todas las validaciones pasaron
       if ($cont == 2) {
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $_conexion->prepare("
                UPDATE comercios SET
               nombre = :nombre,
               telefono = :telefono,
               direccion = :direccion
               WHERE email = :email
            ");
           
            $stmt->execute([
                "email" => $correo,
                "nombre" => $nombre,
                "direccion" => $direccion,
                "telefono" => $telefono
            ]);
            session_start();
           
            $_SESSION["usuario"] = $correo;
               
            $_SESSION["nombre_usuario"] = $nombre;
               
            // Redireccionar
            header("Location: perfil-partner.php");
            exit();
       }
   }
?>








<!DOCTYPE html>
<html lang="es">


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trady Partners - Editar Información</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- FontAwesome (iconos) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- Mismo estilo que el archivo original -->
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
           min-height: 100vh;
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


       .btn-save {
           background: linear-gradient(90deg, var(--partner-success), #96c93d);
           border: none;
           border-radius: 50px;
           font-weight: bold;
           padding: 10px 25px;
           box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
       }


       .form-control, .form-select, .form-control:focus {
           background-color: rgba(255, 255, 255, 0.1);
           border: 1px solid rgba(255, 255, 255, 0.3);
           color: white;
       }


       .form-control:focus, .form-select:focus {
           box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
           border-color: rgba(255, 255, 255, 0.5);
       }


       .logo-upload {
           position: relative;
           width: 150px;
           height: 150px;
           margin: 0 auto 20px;
           border-radius: 50%;
           overflow: hidden;
           border: 3px solid rgba(255, 255, 255, 0.3);
           cursor: pointer;
       }


       .logo-upload img {
           width: 100%;
           height: 100%;
           object-fit: cover;
       }


       .logo-upload .overlay {
           position: absolute;
           top: 0;
           left: 0;
           right: 0;
           bottom: 0;
           background: rgba(0, 0, 0, 0.5);
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: center;
           opacity: 0;
           transition: opacity 0.3s;
       }


       .logo-upload:hover .overlay {
           opacity: 1;
       }


       .business-hours {
           background: rgba(0, 0, 0, 0.2);
           border-radius: 10px;
           padding: 15px;
       }


       .day-selector {
           display: flex;
           margin-bottom: 15px;
       }


       .day-btn {
           flex: 1;
           padding: 8px;
           text-align: center;
           background: rgba(255, 255, 255, 0.1);
           border: 1px solid rgba(255, 255, 255, 0.2);
           color: white;
           cursor: pointer;
       }


       .day-btn:first-child {
           border-radius: 5px 0 0 5px;
       }


       .day-btn:last-child {
           border-radius: 0 5px 5px 0;
       }


       .day-btn.active {
           background: var(--partner-primary);
           border-color: var(--partner-primary);
       }


       .time-inputs {
           display: flex;
           gap: 10px;
           margin-bottom: 15px;
       }


       .time-input-group {
           flex: 1;
       }


       .closed-checkbox {
           margin-top: 10px;
       }


       .category-tag {
           display: inline-block;
           background: rgba(255, 255, 255, 0.2);
           padding: 5px 10px;
           border-radius: 20px;
           margin-right: 5px;
           margin-bottom: 5px;
       }


       .category-tag .remove-tag {
           margin-left: 5px;
           cursor: pointer;
       }


       .preview-card {
           background: rgba(0, 0, 0, 0.3);
           border-radius: 10px;
           padding: 20px;
           margin-top: 20px;
       }


       .preview-logo {
           width: 80px;
           height: 80px;
           border-radius: 50%;
           object-fit: cover;
           margin-bottom: 15px;
       }
   </style>
</head>


<body>


   <!-- Barra de Navegación (igual que en el original) -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75">
       <div class="container">
           <a class="navbar-brand fw-bold" href="#">
               <i class="qr-icon"><img src="trady_sinFondo.png" alt="logo trady" width="70" height="70"></i>TRADY PARTNERS
           </a>
           <div class="d-flex align-items-center">
               <span class="me-3">Nivel: <strong>Partner Oro</strong></span>
               <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-circle">
           </div>
       </div>
   </nav>


   <!-- Contenido Principal -->
   <div class="container my-5">
       <div class="row justify-content-center">
           <div class="col-lg-8">
               <div class="partner-card p-4">
                   <!-- Botón de volver atrás -->
                   <a href="perfil-partner.html" class="btn btn-sm btn-outline-light mb-4">
                       <i class="fas fa-arrow-left me-1"></i> Volver
                   </a>


                   <h2 class="text-center mb-4"><i class="fas fa-store me-2"></i>Editar Información del Negocio</h2>


                   <!-- Formulario de edición -->
                   <form id="businessInfoForm" method="POST" action="">
                       <!-- Logo del negocio -->
                       <div class="text-center mb-4">
                           <div class="logo-upload">
                               <img src="../util/img/trady_sinFondo.png" id="businessLogo">
                           </div>
                       </div>


                       <!-- Información básica -->
                       <div class="mb-4">
                           <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Información Básica</h5>
                          
                           <div class="mb-3">
                               <label for="businessName" class="form-label">Nombre del Negocio*</label>
                               <input type="text" class="form-control" name="name" id="businessName" value="<?php echo $resultado["nombre"];?>" required>
                           </div>
                          
                           <div class="mb-3">
                               <label for="businessCategory" class="form-label">Categorías*</label>
                               <div class="mb-2" id="categoryTags">
                                   <span class="category-tag">
                                       Restaurante
                                       <span class="remove-tag"><i class="fas fa-times"></i></span>
                                   </span>
                                   <span class="category-tag">
                                       Comida Mediterránea
                                       <span class="remove-tag"><i class="fas fa-times"></i></span>
                                   </span>
                               </div>
                               <div class="input-group">
                                   <input type="text" class="form-control" id="newCategory" placeholder="Añadir categoría">
                                   <button class="btn btn-outline-light" type="button" id="addCategory">
                                       <i class="fas fa-plus"></i>
                                   </button>
                               </div>
                           </div>
                       </div>


                       <!-- Información de contacto -->
                       <div class="mb-4">
                           <h5 class="mb-3"><i class="fas fa-phone-alt me-2"></i>Información de Contacto</h5>
                          
                           <div class="row">
                               <div class="col-md-6 mb-3">
                                   <label for="businessPhone" class="form-label">Teléfono*</label>
                                   <input type="tel" class="form-control" name="phone" id="businessPhone" value="<?php echo $resultado["telefono"];?>" required>
                               </div>
                               <div class="col-md-6 mb-3">
                                   <label for="businessEmail" class="form-label">Email*</label>
                                   <input type="email" class="form-control" name="email" id="businessEmail" value="<?php echo $resultado["email"];?>" required>
                               </div>
                           </div>
                          
                           <div class="mb-3">
                               <label for="businessAddress" class="form-label">Dirección*</label>
                               <input type="text" class="form-control" name="direccion" id="businessAddress" value="<?php echo $resultado["direccion"];?>" required>
                           </div>
                       </div>


                       <!-- Botones de acción -->
                       <div class="d-flex justify-content-between mt-4">
                           <button type="button" class="btn btn-outline-light" onclick="history.back()">
                               <i class="fas fa-times me-1"></i> Cancelar
                           </button>
                           <button type="submit" class="btn btn-save">
                               <i class="fas fa-save me-1"></i> Guardar Cambios
                           </button>
                       </div>
                   </form>
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


   <!-- Script para funcionalidad -->
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Subir logo
           const logoUpload = document.querySelector('.logo-upload');
           const logoInput = document.getElementById('logoUpload');
           const logoPreview = document.getElementById('businessLogo');
          
           logoUpload.addEventListener('click', function() {
               logoInput.click();
           });
          
           logoInput.addEventListener('change', function(e) {
               if (e.target.files && e.target.files[0]) {
                   const reader = new FileReader();
                   reader.onload = function(event) {
                       logoPreview.src = event.target.result;
                   };
                   reader.readAsDataURL(e.target.files[0]);
               }
           });


           // Selector de días
           const dayButtons = document.querySelectorAll('.day-btn');
           const dayHours = document.querySelectorAll('.day-hours');
          
           dayButtons.forEach(button => {
               button.addEventListener('click', function() {
                   // Remover activo de todos los botones
                   dayButtons.forEach(btn => btn.classList.remove('active'));
                   // Añadir activo al botón clickeado
                   this.classList.add('active');
                  
                   // Ocultar todos los horarios
                   dayHours.forEach(hours => hours.style.display = 'none');
                   // Mostrar horario del día seleccionado
                   const day = this.getAttribute('data-day');
                   document.getElementById(`${day}-hours`).style.display = 'block';
               });
           });


           // Añadir categorías
           const addCategoryBtn = document.getElementById('addCategory');
           const newCategoryInput = document.getElementById('newCategory');
           const categoryTagsContainer = document.getElementById('categoryTags');
          
           addCategoryBtn.addEventListener('click', function() {
               if (newCategoryInput.value.trim() !== '') {
                   const tag = document.createElement('span');
                   tag.className = 'category-tag';
                   tag.innerHTML = `
                       ${newCategoryInput.value.trim()}
                       <span class="remove-tag"><i class="fas fa-times"></i></span>
                   `;
                   categoryTagsContainer.appendChild(tag);
                   newCategoryInput.value = '';
                  
                   // Añadir evento para eliminar tag
                   tag.querySelector('.remove-tag').addEventListener('click', function() {
                       tag.remove();
                   });
               }
           });


           // Eliminar categorías existentes
           document.querySelectorAll('.remove-tag').forEach(tag => {
               tag.addEventListener('click', function() {
                   this.closest('.category-tag').remove();
               });
           });


           // Actualizar vista previa en tiempo real
           const formInputs = document.querySelectorAll('#businessInfoForm input, #businessInfoForm textarea');
           formInputs.forEach(input => {
               input.addEventListener('input', function() {
                   const previewId = `preview${this.id.replace('business', '')}`;
                   const previewElement = document.getElementById(previewId);
                   if (previewElement) {
                       previewElement.textContent = this.value;
                   }
                  
                   // Caso especial para el nombre
                   if (this.id === 'businessName') {
                       document.getElementById('previewName').textContent = this.value;
                   }
               });
           });


           // Validación del formulario
           /*document.getElementById('businessInfoForm').addEventListener('submit', function(e) {
               e.preventDefault();
              
               // Validación básica
               const requiredFields = ['businessName', 'businessPhone', 'businessEmail', 'businessAddress'];
               let isValid = true;
              
               requiredFields.forEach(fieldId => {
                   const field = document.getElementById(fieldId);
                   if (!field.value.trim()) {
                       field.classList.add('is-invalid');
                       isValid = false;
                   } else {
                       field.classList.remove('is-invalid');
                   }
               });
              
               if (isValid) {
                   // Simular envío del formulario
                   alert('¡Los cambios se han guardado correctamente!');
                   // window.location.href = 'panel-control.html'; // Redirigir al panel
               } else {
                   alert('Por favor, completa todos los campos obligatorios.');
               }
           });*/
       });
   </script>
</body>


</html>