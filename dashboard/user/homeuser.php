<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS-MPV - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <a class="nav-link active" href="homeuser.php">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="expedientesuser.php">
                    <i class="fas fa-folder"></i>
                    <span>Expedientes</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link" href="configuser.php">
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

    
    <div class="main-content">
        
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

       
        <h3 class="dashboard-title">Resumen de Trámites</h3>
        <div class="stats-container">
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-title">Pendientes</div>
            </div>
            
            <div class="stat-card in-process">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-title">En Trámite</div>
            </div>
            
            <div class="stat-card completed">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-title">Atendidos</div>
            </div>
            
            <div class="stat-card denied">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-title">Denegados</div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h4 class="activity-title">Actividad Reciente</h4>
            
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user-plus text-primary"></i>
                </div>
                <div class="activity-content">
                    <h5>Nuevo usuario registrado</h5>
                    <p>Se ha registrado el usuario "Juan Pérez" en el sistema</p>
                    <div class="activity-time">Hace 2 horas</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-file-import text-success"></i>
                </div>
                <div class="activity-content">
                    <h5>Nuevo trámite recibido</h5>
                    <p>Se ha recibido el trámite #2023-00125</p>
                    <div class="activity-time">Hace 5 horas</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-check-circle text-warning"></i>
                </div>
                <div class="activity-content">
                    <h5>Trámite completado</h5>
                    <p>El trámite #2023-00120 ha sido marcado como completado</p>
                    <div class="activity-time">Ayer, 15:30</div>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
                <div class="activity-content">
                    <h5>Trámite denegado</h5>
                    <p>El trámite #2023-00118 ha sido denegado por documentación incompleta</p>
                    <div class="activity-time">Ayer, 11:45</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aquí puedes agregar funcionalidad JavaScript si es necesario
        // Por ejemplo, para cargar datos reales desde una API
        
        document.addEventListener('DOMContentLoaded', function() {
            // Simular carga de datos
            setTimeout(() => {
                // Aquí iría la lógica para cargar datos reales
                console.log('Dashboard cargado');
            }, 500);
        });
    </script>
</body>
</html>