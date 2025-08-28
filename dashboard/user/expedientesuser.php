<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS-OP - Gestión de Expedientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css">
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
        <h3 class="page-title">Gestión de Expedientes</h3>

        <!-- Search Section -->
        <div class="search-section">
            <h5 class="search-title">Búsqueda de Expedientes</h5>
            <div class="search-grid">
                <div class="search-field">
                    <label for="nroExpediente">Nro. Expediente</label>
                    <input type="text" id="nroExpediente" placeholder="Ingrese número de expediente">
                </div>
                <div class="search-field">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" placeholder="Ingrese código">
                </div>
                <div class="search-field">
                    <label for="archivo">Archivo</label>
                    <input type="text" id="archivo" placeholder="Buscar por archivo">
                </div>
                <div class="search-field">
                    <label for="estado">Estado</label>
                    <select id="estado">
                        <option value="">Todos los estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="proceso">En proceso</option>
                        <option value="completado">Completado</option>
                        <option value="denegado">Denegado</option>
                    </select>
                </div>
            </div>
            <div class="search-actions">
                <button class="btn btn-secondary">Limpiar</button>
                <button class="btn btn-primary">Buscar</button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card">
            <div class="card-header">
                <h5>Listado de Expedientes</h5>
                <div class="export-buttons">
                    <!-- Los botones se generarán automáticamente con DataTables -->
                </div>
            </div>
            <div class="table-container">
                <table id="expedientesTable" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha/Hora</th>
                            <th>Remitente</th>
                            <th>Asunto</th>
                            <th>Nro. Expediente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2023-07-25 16:36:59</td>
                            <td>María Brass</td>
                            <td>SOLICITUD DE RECORD ACADEMICO</td>
                            <td>2023-001</td>
                            <td><span class="badge-estado badge-pendiente">Pendiente</span></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2023-07-26 09:15:32</td>
                            <td>Juan Pérez</td>
                            <td>SOLICITUD DE CERTIFICADO DE ESTUDIOS</td>
                            <td>2023-002</td>
                            <td><span class="badge-estado badge-proceso">En proceso</span></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2023-07-27 11:45:18</td>
                            <td>Carlos López</td>
                            <td>SOLICITUD DE CONSTANCIA DE TRABAJO</td>
                            <td>2023-003</td>
                            <td><span class="badge-estado badge-completado">Completado</span></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>2023-07-28 14:20:45</td>
                            <td>Ana García</td>
                            <td>SOLICITUD DE PERMISO ADMINISTRATIVO</td>
                            <td>2023-004</td>
                            <td><span class="badge-estado badge-denegado">Denegado</span></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable con botones de exportación
            $('#expedientesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-secondary'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-eye"></i> Column Visibility',
                        className: 'btn btn-sm btn-secondary'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
            });
            
            // Mover los botones de exportación al contenedor correcto
            $('.dt-buttons').appendTo('.export-buttons');
        });
    </script>
</body>
</html>