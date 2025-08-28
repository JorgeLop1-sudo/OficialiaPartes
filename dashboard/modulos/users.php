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
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>SIS-OP</h3>
            <p>Sistema de Oficialia de Partes</p>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="homeadmin.php">
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
                <a class="nav-link" href="../../index.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h2 class="mb-0">Dashboard</h2>
            <div class="user-info">
                <div class="user-avatar">AD</div>
                <div>
                    <div class="fw-bold">Admin User</div>
                    <div class="small text-muted">Administrador</div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <h3>Gestión de Usuarios</h3>
            <button class="btn btn-new" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </button>
        </div>

        <!-- Users Cards -->
        <div class="users-container">
            <!-- User Card 1 -->
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-name">User</div>
                    <div class="user-id">ID: 1</div>
                </div>
                <div class="user-details">
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Tipo:</strong> User
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Nombre:</strong> Nombre
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Área:</strong> MESA DE PARTES
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Email:</strong> user@example.com
                        </div>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <!-- User Card 2 -->
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-name">User</div>
                    <div class="user-id">ID: 2</div>
                </div>
                <div class="user-details">
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Tipo:</strong> User
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Nombre:</strong> Tarea Completo
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Área:</strong> MESA DE PARTES
                        </div>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <!-- User Card 3 -->
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-name">User</div>
                    <div class="user-id">ID: 3</div>
                </div>
                <div class="user-details">
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Tipo:</strong> Admin
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Nombre:</strong> Admin
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Área:</strong> Contact
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Email:</strong> admin@gmail.com
                        </div>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <!-- User Card 4 -->
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-name">User</div>
                    <div class="user-id">ID: 4</div>
                </div>
                <div class="user-details">
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Tipo:</strong> User
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Nombre:</strong> Previous
                        </div>
                    </div>
                    <div class="user-detail">
                        <div class="user-detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="user-detail-text">
                            <strong>Email:</strong> Next
                        </div>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
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
                <div class="modal-body">
                    <form id="nuevoUsuarioForm">
                        <div class="mb-3">
                            <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                            <select class="form-select" id="tipoUsuario" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="admin">Administrador</option>
                                <option value="user">Usuario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="areaUsuario" class="form-label">Área</label>
                            <select class="form-select" id="areaUsuario" required>
                                <option value="" selected disabled>Seleccionar área</option>
                                <option value="mesa_partes">MESA DE PARTES</option>
                                <option value="gerencia">GERENCIA</option>
                                <option value="rrhh">RECURSOS HUMANOS</option>
                                <option value="contabilidad">CONTABILIDAD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordUsuario" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="passwordUsuario" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>