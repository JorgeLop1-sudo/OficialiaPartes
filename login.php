<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css\styleindex.css">
</head>
<body>
<div>

    
    <div class="header">
        <h1>Oficialia de partes</h1>
        <p>Sistema de gestión de Oficios</p>
    </div>
    
    <div class="nav-links">
        <a href="index.php" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
        <a href="registrar.php" class="nav-link"><i class="fas fa-file-alt"></i> Registrar Oficio</a>
        <a href="buscar.php" class="nav-link"><i class="fas fa-search"></i> Buscar Oficio</a>
    </div>

    <div class="login-container">
        <div class="login-form">
            <h3 class="text-center mb-4">Inicio de Sesión</h3>
            
            <form id="loginForm" action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Recordar mis datos</label>
                </div>
                
                <button type="submit" class="btn btn-login">Ingresar al Sistema</button>
                
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                </div>
            </form>
        </div>
        

    </div>

</div>
</body>
</html>