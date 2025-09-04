<?php
session_start();

// Headers para prevenir caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "test";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No hay conexión: " . mysqli_connect_error());
}

// Procesar formulario de registro de oficio
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar datos del formulario
    $remitente = mysqli_real_escape_string($conn, $_POST['remitente']);
    $tipo_persona = mysqli_real_escape_string($conn, $_POST['tipoPersona']);
    $tipo_documento = mysqli_real_escape_string($conn, $_POST['tipoDocumento']);
    $numero_documento = isset($_POST['numeroDocumento']) ? mysqli_real_escape_string($conn, $_POST['numeroDocumento']) : null;
    $folios = mysqli_real_escape_string($conn, $_POST['folios']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $asunto = mysqli_real_escape_string($conn, $_POST['asunto']);
    
    // Valores fijos como solicitaste
    $area_id = 5; // Valor fijo para area_id
    $usuario_id = 1; // Valor fijo para usuario_id
    
    // Verificar si el área existe
    $query_area_check = mysqli_query($conn, "SELECT id FROM areas WHERE id = '$area_id'");
    if (mysqli_num_rows($query_area_check) === 0) {
        $mensaje = "Error: El área seleccionada no es válida";
        $tipoMensaje = "error";
    } else {
        // Procesar archivo subido
        $archivo_nombre = null;
        $archivo_ruta = null;
        $archivo_ruta2 = null;
        
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $directorio = "../uploads/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            
            $archivo_nombre = basename($_FILES['archivo']['name']);
            $archivo_temporal = $_FILES['archivo']['tmp_name'];
            $archivo_ruta = $directorio . time() . '_' . $archivo_nombre;
            $archivo_ruta2 = '../../'.$directorio . time() . '_' . $archivo_nombre;
            
            if (!move_uploaded_file($archivo_temporal, $archivo_ruta)) {
                $mensaje = "Error al subir el archivo.";
                $tipoMensaje = "error";
            }
        }
        
        // Si no hay error hasta ahora, insertar en la base de datos
        if (empty($mensaje)) {
            $insert_query = "INSERT INTO oficios (remitente, tipo_persona, tipo_documento, numero_documento, folios, correo, telefono, asunto, archivo_nombre, archivo_ruta, area_id, usuario_id) 
                            VALUES ('$remitente', '$tipo_persona', '$tipo_documento', '$numero_documento', '$folios', '$correo', '$telefono', '$asunto', '$archivo_nombre', '$archivo_ruta2', '$area_id', '$usuario_id')";
            
            if (mysqli_query($conn, $insert_query)) {
                $mensaje = "Oficio registrado correctamente.";
                $tipoMensaje = "success";
                
                // Limpiar el formulario después de un registro exitoso
                echo '<script>document.getElementById("registerForm").reset();</script>';
            } else {
                $mensaje = "Error al registrar el oficio: " . mysqli_error($conn);
                $tipoMensaje = "error";
            }
        }
    }
}

// Cerrar conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficialia de Partes - Registrar Oficio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="..\css\inicio\styleoficios.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>Oficialia de partes</h1>
        <p>Sistema de gestión de Oficios</p>
    </div>
    
    <div class="nav-links">
        <a href="index.php" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
        <a href="login.php" class="nav-link"><i class="fas fa-user"></i> Iniciar Sesion</a>
        <a href="buscar.php" class="nav-link"><i class="fas fa-search"></i> Buscar Oficio</a>
    </div>
    
    <div class="container">
        <div class="content">
            <h2 class="page-title"><i class="fas fa-file-alt me-2"></i>Registrar Oficio</h2>
            
            <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipoMensaje == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <form id="registerForm" method="POST" enctype="multipart/form-data">
                <!-- Sección de Remitente -->
                <div class="form-section">
                    <h3 class="form-section-title">Datos del Remitente</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="remitente" class="form-label">Remitente</label>
                            <input type="text" class="form-control" id="remitente" name="remitente" placeholder="Nombre completo o razón social" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tipoPersona" class="form-label">Tipo de Persona</label>
                            <select class="form-select" id="tipoPersona" name="tipoPersona" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="natural">Persona Natural</option>
                                <option value="juridica">Persona Jurídica</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Documento</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" id="tipoCarta" name="tipoDocumento" value="carta" required>
                                    <label for="tipoCarta">Carta, oficio, etc.</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="tipoRucDni" name="tipoDocumento" value="ruc_dni">
                                    <label for="tipoRucDni">Numero de Oficio</label>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Número de oficio" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="folios" class="form-label">Folios</label>
                            <input type="number" class="form-control" id="folios" name="folios" placeholder="Número de folios" min="1" required>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Contacto -->
                <div class="form-section">
                    <h3 class="form-section-title">Datos de Contacto</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Número de teléfono" required>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Contenido -->
                <div class="form-section">
                    <h3 class="form-section-title">Contenido del Trámite</h3>
                    
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del trámite" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Archivo</label>
                        <div class="file-upload" id="fileUploadArea">
                            <input type="file" id="archivo" name="archivo" style="display: none;">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Seleccionar archivo</p>
                            <p class="file-name" id="fileName">Ningún archivo seleccionado</p>
                        </div>
                    </div>
                    
                    <!-- Información fija sobre el área y usuario asignado -->
                    <div class="alert alert-info">
                        <strong>Información del registro:</strong><br>
                        - Este documento será dirigido hacia recepción
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn-action btn-register">
                        <i class="fas fa-check-circle me-2"></i> Registrar
                    </button>
                    <button type="button" class="btn-action btn-cancel" id="cancelButton">
                        <i class="fas fa-times-circle me-2"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <p>Oficialia de partes - Registrar Oficio</p>
        </div>
    </div>

    <script>
        // Mostrar/ocultar campo de número de documento según selección
        document.querySelectorAll('input[name="tipoDocumento"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const numeroDocumento = document.getElementById('numeroDocumento');
                if (this.value === 'ruc_dni') {
                    numeroDocumento.style.display = 'block';
                    numeroDocumento.setAttribute('required', 'true');
                } else {
                    numeroDocumento.style.display = 'none';
                    numeroDocumento.removeAttribute('required');
                }
            });
        });
        
        // Manejar la subida de archivos
        const fileInput = document.getElementById('archivo');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const fileName = document.getElementById('fileName');
        
        fileUploadArea.addEventListener('click', function() {
            fileInput.click();
        });
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = 'Ningún archivo seleccionado';
            }
        });
        
        // Manejar el botón cancelar
        document.getElementById('cancelButton').addEventListener('click', function() {
            if (confirm('¿Está seguro que desea cancelar? Se perderán todos los datos ingresados.')) {
                window.location.href = 'index.php';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>