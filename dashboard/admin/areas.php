<?php
session_start();

// Headers para prevenir caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../../inicio/index.php");
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

// Crear tabla de áreas si no existe
$create_table = "CREATE TABLE IF NOT EXISTS areas (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1
)";

if (!mysqli_query($conn, $create_table)) {
    die("Error creando tabla: " . mysqli_error($conn));
}

// Procesar formularios
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear nueva área
    if (isset($_POST['crear_area'])) {
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        
        // Verificar si el área ya existe
        $check_query = mysqli_query($conn, "SELECT * FROM areas WHERE nombre = '$nombre'");
        if (mysqli_num_rows($check_query) > 0) {
            $mensaje = "Error: El área ya existe";
        } else {
            $insert_query = "INSERT INTO areas (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
            
            if (mysqli_query($conn, $insert_query)) {
                $mensaje = "Área creada exitosamente";
                header("Location: areas.php?mensaje=" . urlencode($mensaje));
                exit();
            } else {
                $mensaje = "Error al crear área: " . mysqli_error($conn);
            }
        }
    }
    
    // Editar área
    if (isset($_POST['editar_area'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
        
        $update_query = "UPDATE areas SET nombre = '$nombre', descripcion = '$descripcion' WHERE id = '$id'";
        
        if (mysqli_query($conn, $update_query)) {
            $mensaje = "Área actualizada exitosamente";
            header("Location: areas.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $mensaje = "Error al actualizar área: " . mysqli_error($conn);
        }
    }
}

// Procesar eliminación de área
if (isset($_GET['eliminar'])) {
    $id = mysqli_real_escape_string($conn, $_GET['eliminar']);
    
    // Verificar si el área está en uso antes de eliminar
    $check_use = mysqli_query($conn, "SELECT * FROM login WHERE area = (SELECT nombre FROM areas WHERE id = '$id')");
    if (mysqli_num_rows($check_use) > 0) {
        $mensaje = "No se puede eliminar el área porque está asignada a usuarios";
    } else {
        $delete_query = "DELETE FROM areas WHERE id = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            $mensaje = "Área eliminada exitosamente";
            header("Location: areas.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $mensaje = "Error al eliminar área: " . mysqli_error($conn);
        }
    }
}

// Obtener área específica para editar
$area_editar = null;
if (isset($_GET['editar'])) {
    $id_editar = mysqli_real_escape_string($conn, $_GET['editar']);
    $query_editar = mysqli_query($conn, "SELECT * FROM areas WHERE id = '$id_editar'");
    if (mysqli_num_rows($query_editar) > 0) {
        $area_editar = mysqli_fetch_assoc($query_editar);
    }
}

// Obtener todas las áreas
$areas = [];
$query = mysqli_query($conn, "SELECT * FROM areas ORDER BY nombre ASC");
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $areas[] = $row;
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
    <title>SIS-OP - Gestión de Áreas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="..\..\css\dashboard\styledash.css">
    <style>
        .btn-action {
            margin: 0 3px;
        }
        .area-card {
            transition: transform 0.2s;
        }
        .area-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>SIS-OP</h3>
            <p>Sistema de Oficialia de Partes</p>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="homeadmin.php">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="areas.php">
                    <i class="fas fa-layer-group"></i>
                    <span>Áreas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="expedientes.php">
                    <i class="fas fa-folder"></i>
                    <span>Expedientes</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link" href="config.php">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../inicio/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>

    
    <div class="main-content">
        
        <div class="header">
            <h2 class="mb-0">Dashboard Administrador</h2>
            <div class="user-info">
                <div class="user-avatar"><?php echo substr($_SESSION['nombre'], 0, 2); ?></div>
                <div>
                    <div class="fw-bold"><?php echo $_SESSION['nombre']; ?></div>
                    <div class="small text-muted"><?php echo $_SESSION['tipo_usuario']; ?></div>
                </div>
            </div>
        </div>

        <!-- Mostrar mensajes -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['mensaje']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje) && !isset($_GET['mensaje'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        
        <div class="page-title">
            <h3>Gestión de Áreas</h3>
            <button class="btn btn-new" data-bs-toggle="modal" data-bs-target="#nuevaAreaModal">
                <i class="fas fa-plus"></i> Nueva Área
            </button>
        </div>

        
        <div class="users-container">
            <?php if (empty($areas)): ?>
                <div class="alert alert-warning">
                    No hay áreas registradas en el sistema.
                </div>
            <?php else: ?>
                <?php foreach ($areas as $area): ?>
                    <div class="user-card area-card">
                        <div class="user-card-header">
                            <div class="user-name"><?php echo htmlspecialchars($area['nombre']); ?></div>
                            <div class="user-id">ID: <?php echo $area['id']; ?></div>
                        </div>
                        <div class="user-details">
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Descripción:</strong> 
                                    <?php echo !empty($area['descripcion']) ? htmlspecialchars($area['descripcion']) : 'Sin descripción'; ?>
                                </div>
                            </div>
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Creación:</strong> 
                                    <?php echo date('d/m/Y', strtotime($area['fecha_creacion'])); ?>
                                </div>
                            </div>
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-status"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Estado:</strong> 
                                    <span class="badge bg-<?php echo $area['activo'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $area['activo'] ? 'Activa' : 'Inactiva'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="user-actions">
                            <a href="?editar=<?php echo $area['id']; ?>" class="btn btn-sm btn-primary btn-action">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button class="btn btn-sm btn-danger btn-action" 
                                    onclick="confirmarEliminacion(<?php echo $area['id']; ?>, '<?php echo htmlspecialchars($area['nombre']); ?>')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para Nueva Área -->
    <div class="modal fade" id="nuevaAreaModal" tabindex="-1" aria-labelledby="nuevaAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaAreaModalLabel">Nueva Área</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Área *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required 
                                   placeholder="Ej: Recursos Humanos, Contabilidad, etc.">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" 
                                      rows="3" placeholder="Descripción de las funciones del área"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="crear_area" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Área -->
    <?php if ($area_editar): ?>
    <div class="modal fade show" id="editarAreaModal" tabindex="-1" aria-labelledby="editarAreaModalLabel" aria-hidden="false" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarAreaModalLabel">Editar Área</h5>
                    <a href="areas.php" class="btn-close" aria-label="Close"></a>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $area_editar['id']; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_edit" class="form-label">Nombre del Área *</label>
                            <input type="text" class="form-control" id="nombre_edit" name="nombre" 
                                   value="<?php echo htmlspecialchars($area_editar['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_edit" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_edit" name="descripcion" 
                                      rows="3"><?php echo htmlspecialchars($area_editar['descripcion']); ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="areas.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_area" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminacion(id, nombre) {
            if (confirm(`¿Estás seguro de eliminar el área "${nombre}"? Esta acción no se puede deshacer.`)) {
                window.location.href = `?eliminar=${id}`;
            }
        }
        
        // Cerrar modal de edición al hacer clic fuera
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('editarAreaModal');
            if (event.target === modal) {
                window.location.href = 'areas.php';
            }
        });

        // Cerrar modal con ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.href = 'areas.php';
            }
        });
    </script>
</body>
</html>