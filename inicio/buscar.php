<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficialia de partes - Buscar Trámite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="..\css\inicio\stylebuscar.css">

</head>
<body>
    <div class="header">
        <h1>Oficialia de partes</h1>
        <p>Sistema de gestión de Oficios</p>
    </div>
    
    <div class="nav-links">
        <a href="index.php" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
        <a href="registrar.php" class="nav-link"><i class="fas fa-file-alt"></i> Registrar Oficio</a>
        <a href="login.php" class="nav-link"><i class="fas fa-user"></i> Iniciar Sesion</a>
    </div>
    
    <div class="container">
        <div class="content">
            <h2 class="page-title"><i class="fas fa-search me-2"></i>Buscar Trámite</h2>
            
            <form id="searchForm" action="procesar_busqueda.php" method="POST">
                <div class="mb-3">
                    <label for="expediente" class="form-label">Ingresar N° de Expediente</label>
                    <input type="text" class="form-control" id="expediente" name="expediente" placeholder="Ejemplo: 2023-00123-MP" required>
                </div>
                
                <div class="mb-3">
                    <label for="codigo" class="form-label">Ingresar Código de Seguridad</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese el código mostrado" required>
                </div>
                
                <div class="security-code">
                    <span id="codigoSeguridad">A7B9</span>
                    <div>
                        <p class="mb-1">Código de seguridad (distingue entre mayúsculas y minúsculas)</p>
                        <a href="#" onclick="generarCodigo(); return false;"><i class="fas fa-sync-alt"></i> Generar nuevo código</a>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-search">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <p>Oficialia de partes - Busqueda de oficio</p>
        </div>
    </div>

    <script>
        // Función para generar un código de seguridad aleatorio
        function generarCodigo() {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let codigo = '';
            for (let i = 0; i < 4; i++) {
                codigo += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            document.getElementById('codigoSeguridad').textContent = codigo;
        }
        
        // Generar código inicial al cargar la página
        window.onload = function() {
            generarCodigo();
        };
        
        // Validación del formulario
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            const expediente = document.getElementById('expediente').value;
            const codigo = document.getElementById('codigo').value;
            const codigoSeguridad = document.getElementById('codigoSeguridad').textContent;
            
            if (!expediente) {
                alert('Por favor, ingrese el número de expediente');
                event.preventDefault();
                return;
            }
            
            if (codigo !== codigoSeguridad) {
                alert('El código de seguridad no coincide. Por favor, inténtelo de nuevo.');
                event.preventDefault();
                generarCodigo();
                return;
            }
            
            // Aquí normalmente se enviaría el formulario al servidor
            alert('Búsqueda realizada con éxito. Redirigiendo a resultados...');
            // event.preventDefault(); // Descomentar para desarrollo
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>