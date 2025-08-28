<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS-OP - Configuración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="..\..\css\dashboard\styleconfig.css">
    <link rel="stylesheet" href="..\..\css\dashboard\styledash.css">

</head>
<body>
    
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
                <a class="nav-link" href="../../inicio/index.php">
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
            <h2 class="mb-0">Sistema de Mesa de Partes Virtual</h2>
            <div class="user-info">
                <div class="user-avatar">AD</div>
                <div>
                    <div class="fw-bold">Admin User</div>
                    <div class="small text-muted">Administrador</div>
                </div>
            </div>
        </div>

        <!-- Page Title -->
        <h3 class="page-title">Configuración del Sistema</h3>

        <!-- Configuration Cards -->
        <div class="config-container">
            <!-- General Settings -->
            <div class="config-card">
                <div class="config-card-header">
                    <div class="config-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <h5 class="config-title">Configuración General</h5>
                </div>
                <div class="config-content">
                    <div class="config-item">
                        <span class="config-item-label">Nombre del Sistema</span>
                        <span class="config-item-value">SIS-MPV</span>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Versión</span>
                        <span class="config-item-value">v2.1.0</span>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Máximo de archivos por expediente</span>
                        <span class="config-item-value">10</span>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Tamaño máximo por archivo (MB)</span>
                        <span class="config-item-value">20</span>
                    </div>
                </div>
                <div class="config-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Editar
                    </button>
                </div>
            </div>

            <!-- Notifications -->
            <div class="config-card">
                <div class="config-card-header">
                    <div class="config-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="config-title">Notificaciones</h5>
                </div>
                <div class="config-content">
                    <div class="config-item">
                        <span class="config-item-label">Notificaciones por email</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                        </div>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Notificaciones en sistema</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="systemNotifications" checked>
                        </div>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Notificar nuevos expedientes</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="newExpedientes" checked>
                        </div>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Notificar cambios de estado</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusChanges" checked>
                        </div>
                    </div>
                </div>
                <div class="config-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </div>

            <!-- Security -->
            <div class="config-card">
                <div class="config-card-header">
                    <div class="config-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="config-title">Seguridad</h5>
                </div>
                <div class="config-content">
                    <div class="config-item">
                        <span class="config-item-label">Contraseñas seguras</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="securePasswords" checked>
                        </div>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Doble autenticación</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                        </div>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Intentos de login permitidos</span>
                        <span class="config-item-value">3</span>
                    </div>
                    <div class="config-item">
                        <span class="config-item-label">Bloqueo temporal (minutos)</span>
                        <span class="config-item-value">15</span>
                    </div>
                </div>
                <div class="config-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="system-info">
            <h5 class="mb-4"><i class="fas fa-info-circle me-2"></i>Información del Sistema</h5>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Sistema Operativo</div>
                    <div class="info-value">Linux Ubuntu 20.04</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Servidor Web</div>
                    <div class="info-value">Apache 2.4</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Versión de PHP</div>
                    <div class="info-value">8.1.12</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Base de Datos</div>
                    <div class="info-value">MySQL 8.0</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Espacio en disco</div>
                    <div class="info-value">250 GB / 500 GB</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Memoria RAM</div>
                    <div class="info-value">8 GB</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Última actualización</div>
                    <div class="info-value">2023-10-15 08:30:45</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Estado del sistema</div>
                    <div class="info-value"><span class="badge bg-success">Operativo</span></div>
                </div>
            </div>
        </div>

        <!-- Backup Section -->
        <div class="backup-section">
            <h5 class="mb-4"><i class="fas fa-database me-2"></i>Respaldo y Mantenimiento</h5>
            <p class="text-muted">Realice copias de seguridad de su sistema regularmente para prevenir pérdida de información.</p>
            
            <div class="backup-options">
                <button class="btn btn-primary">
                    <i class="fas fa-download me-2"></i> Respaldar Base de Datos
                </button>
                <button class="btn btn-success">
                    <i class="fas fa-file-archive me-2"></i> Respaldar Documentos
                </button>
                <button class="btn btn-warning">
                    <i class="fas fa-history me-2"></i> Programar Respaldos
                </button>
                <button class="btn btn-info">
                    <i class="fas fa-tasks me-2"></i> Optimizar Base de Datos
                </button>
            </div>
            
            <div class="mt-4">
                <h6>Últimos respaldos</h6>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>backup_20231020.sql</span>
                        <span class="badge bg-secondary">2023-10-20 23:45:00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>backup_20231019.sql</span>
                        <span class="badge bg-secondary">2023-10-19 23:45:00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>backup_20231018.sql</span>
                        <span class="badge bg-secondary">2023-10-18 23:45:00</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Funcionalidad para los switches de configuración
        document.addEventListener('DOMContentLoaded', function() {
            // Simular guardado de configuración
            const saveButtons = document.querySelectorAll('.config-actions .btn');
            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cardTitle = this.closest('.config-card').querySelector('.config-title').textContent;
                    alert(`Configuración de "${cardTitle}" guardada correctamente.`);
                });
            });
            
            // Funcionalidad para botones de respaldo
            const backupButtons = document.querySelectorAll('.backup-options .btn');
            backupButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const buttonText = this.textContent.trim();
                    alert(`Proceso de ${buttonText} iniciado. Esto puede tomar algunos minutos.`);
                });
            });
        });
    </script>
</body>
</html>