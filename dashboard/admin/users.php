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

// Obtener todas las áreas disponibles desde la base de datos
$areas_disponibles = [];
$query_areas = mysqli_query($conn, "SELECT id, nombre FROM areas WHERE activo = 1 ORDER BY nombre ASC");
if ($query_areas) {
    while ($row = mysqli_fetch_assoc($query_areas)) {
        $areas_disponibles[] = $row;
    }
}

// Procesar formulario de nuevo usuario
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_usuario'])) {
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $tipo_usuario = mysqli_real_escape_string($conn, $_POST['tipo_usuario']);
        $area_id = mysqli_real_escape_string($conn, $_POST['area']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        // Obtener el nombre del área basado en el ID seleccionado
        $area_nombre = "";
        $query_area_nombre = mysqli_query($conn, "SELECT nombre FROM areas WHERE id = '$area_id'");
        if ($query_area_nombre && mysqli_num_rows($query_area_nombre) > 0) {
            $area_data = mysqli_fetch_assoc($query_area_nombre);
            $area_nombre = $area_data['nombre'];
        }
        
        // Verificar si el usuario ya existe
        $check_query = mysqli_query($conn, "SELECT * FROM login WHERE usuario = '$usuario'");
        if (mysqli_num_rows($check_query) > 0) {
            $mensaje = "Error: El usuario ya existe";
        } else if (empty($area_nombre)) {
            $mensaje = "Error: El área seleccionada no es válida";
        } else {
            // Insertar nuevo usuario
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO login (usuario, password, nombre, tipo_usuario, area, email) 
                            VALUES ('$usuario', '$password_hashed', '$nombre', '$tipo_usuario', '$area_nombre', '$email')";
            
            if (mysqli_query($conn, $insert_query)) {
                $mensaje = "Usuario creado exitosamente";
                header("Location: users.php?mensaje=" . urlencode($mensaje));
                exit();
            } else {
                $mensaje = "Error al crear usuario: " . mysqli_error($conn);
            }
        }
    }
    
    // Procesar edición de usuario
    if (isset($_POST['editar_usuario'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $tipo_usuario = mysqli_real_escape_string($conn, $_POST['tipo_usuario']);
        $area_id = mysqli_real_escape_string($conn, $_POST['area']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        // Obtener el nombre del área basado en el ID seleccionado
        $area_nombre = "";
        $query_area_nombre = mysqli_query($conn, "SELECT nombre FROM areas WHERE id = '$area_id'");
        if ($query_area_nombre && mysqli_num_rows($query_area_nombre) > 0) {
            $area_data = mysqli_fetch_assoc($query_area_nombre);
            $area_nombre = $area_data['nombre'];
        }
        
        // Si se proporcionó una nueva contraseña, actualizarla
        $password_update = "";
        if (!empty($_POST['password'])) {
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $password_update = ", password = '$password_hashed'";
        }
        
        $update_query = "UPDATE login SET usuario = '$usuario', nombre = '$nombre', 
                         tipo_usuario = '$tipo_usuario', area = '$area_nombre', email = '$email'
                         $password_update WHERE id = '$id'";
        
        if (mysqli_query($conn, $update_query)) {
            $mensaje = "Usuario actualizado exitosamente";
            header("Location: users.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $mensaje = "Error al actualizar usuario: " . mysqli_error($conn);
        }
    }
}

// Procesar eliminación de usuario
if (isset($_GET['eliminar'])) {
    $id = mysqli_real_escape_string($conn, $_GET['eliminar']);
    
    // No permitir eliminarse a sí mismo
    if ($id != $_SESSION['id_usuario']) {
        $delete_query = "DELETE FROM login WHERE id = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            $mensaje = "Usuario eliminado exitosamente";
            header("Location: users.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $mensaje = "Error al eliminar usuario: " . mysqli_error($conn);
        }
    } else {
        $mensaje = "No puedes eliminarte a ti mismo";
    }
}

// Obtener usuario específico para editar
$usuario_editar = null;
if (isset($_GET['editar'])) {
    $id_editar = mysqli_real_escape_string($conn, $_GET['editar']);
    $query_editar = mysqli_query($conn, "SELECT * FROM login WHERE id = '$id_editar'");
    if (mysqli_num_rows($query_editar) > 0) {
        $usuario_editar = mysqli_fetch_assoc($query_editar);
        
        // Obtener el ID del área actual del usuario para seleccionarlo en el formulario
        if ($usuario_editar) {
            $area_actual = $usuario_editar['area'];
            $query_area_id = mysqli_query($conn, "SELECT id FROM areas WHERE nombre = '$area_actual'");
            if ($query_area_id && mysqli_num_rows($query_area_id) > 0) {
                $area_data = mysqli_fetch_assoc($query_area_id);
                $usuario_editar['area_id'] = $area_data['id'];
            }
        }
    }
}

// Obtener todos los usuarios de la base de datos
$usuarios = [];
$query = mysqli_query($conn, "SELECT * FROM login ORDER BY id DESC");
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $usuarios[] = $row;
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
    <title>SIS-OP - Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="..\..\css\dashboard\styledash.css">
    <style>
        .btn-action {
            margin: 0 3px;
        }
        .modal-content {
            border-radius: 10px;
        }
        .password-toggle {
            cursor: pointer;
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
                <a class="nav-link" href="areas.php">
                    <i class="fas fa-layer-group"></i>
                    <span>Áreas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="users.php">
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

        
        <div class="page-title">
            <h3>Gestión de Usuarios</h3>
            <button class="btn btn-new" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </button>
        </div>

        
        <div class="users-container">
            <?php if (empty($usuarios)): ?>
                <div class="alert alert-warning">
                    No hay usuarios registrados en el sistema.
                </div>
            <?php else: ?>
                <?php foreach ($usuarios as $user): ?>
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-name"><?php echo htmlspecialchars($user['usuario']); ?></div>
                            <div class="user-id">ID: <?php echo $user['id']; ?></div>
                        </div>
                        <div class="user-details">
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Tipo:</strong> 
                                    <span class="badge bg-<?php echo $user['tipo_usuario'] == 'admin' ? 'warning' : 'info'; ?>">
                                        <?php echo htmlspecialchars($user['tipo_usuario']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombre']); ?>
                                </div>
                            </div>
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Área:</strong> <?php echo htmlspecialchars($user['area']); ?>
                                </div>
                            </div>
                            <?php if (!empty($user['email'])): ?>
                            <div class="user-detail">
                                <div class="user-detail-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="user-detail-text">
                                    <strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="user-actions">
                            <a href="?editar=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary btn-action">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button class="btn btn-sm btn-danger btn-action" 
                                    onclick="confirmarEliminacion(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['usuario']); ?>')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para Nuevo Usuario -->
    <div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoUsuarioModalLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario *</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuario *</label>
                            <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="admin">Administrador</option>
                                <option value="user">Usuario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">Área *</label>
                            <select class="form-select" id="area" name="area" required>
                                <option value="" selected disabled>Seleccionar área</option>
                                <?php foreach ($areas_disponibles as $area): ?>
                                    <option value="<?php echo $area['id']; ?>"><?php echo htmlspecialchars($area['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="crear_usuario" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Usuario -->
    <?php if ($usuario_editar): ?>
    <div class="modal fade show" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="false" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <a href="users.php" class="btn-close" aria-label="Close"></a>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $usuario_editar['id']; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="usuario_edit" class="form-label">Usuario *</label>
                            <input type="text" class="form-control" id="usuario_edit" name="usuario" 
                                   value="<?php echo htmlspecialchars($usuario_editar['usuario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_edit" class="form-label">Nueva Contraseña (dejar vacío para no cambiar)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_edit" name="password">
                                <span class="input-group-text password-toggle" onclick="togglePassword('password_edit')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_edit" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre_edit" name="nombre" 
                                   value="<?php echo htmlspecialchars($usuario_editar['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_usuario_edit" class="form-label">Tipo de Usuario *</label>
                            <select class="form-select" id="tipo_usuario_edit" name="tipo_usuario" required>
                                <option value="admin" <?php echo $usuario_editar['tipo_usuario'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                <option value="user" <?php echo $usuario_editar['tipo_usuario'] == 'user' ? 'selected' : ''; ?>>Usuario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="area_edit" class="form-label">Área *</label>
                            <select class="form-select" id="area_edit" name="area" required>
                                <option value="" disabled>Seleccionar área</option>
                                <?php foreach ($areas_disponibles as $area): ?>
                                    <option value="<?php echo $area['id']; ?>" 
                                        <?php echo (isset($usuario_editar['area_id']) && $usuario_editar['area_id'] == $area['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($area['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email_edit" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_edit" name="email" 
                                   value="<?php echo htmlspecialchars($usuario_editar['email']); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="users.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_usuario" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminacion(id, usuario) {
            if (confirm(`¿Estás seguro de eliminar al usuario "${usuario}"? Esta acción no se puede deshacer.`)) {
                window.location.href = `?eliminar=${id}`;
            }
        }
        
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.parentElement.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Cerrar modal de edición al hacer clic fuera
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('editarUsuarioModal');
            if (event.target === modal) {
                window.location.href = 'users.php';
            }
        });
    </script>
</body>
</html>