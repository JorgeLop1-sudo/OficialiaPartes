<?php
session_start();

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingresa un correo electrónico válido";
    } else {
        // Simulamos el envío para testing
        $token = bin2hex(random_bytes(32));
        $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/inicio/recovery/reset-password.php?token=$token";
        
        // Mensaje de simulación (en producción se enviaría un email real)
        $message = "<div class='alert alert-info'>
            <h4>📧 Email de prueba (Modo Desarrollo)</h4>
            <p><strong>Para:</strong> $email</p>
            <p><strong>Asunto:</strong> Recuperación de Contraseña - Sistema Oficialía de Partes</p>
            <p><strong>Enlace de recuperación:</strong> </p>
            <p><a href='$reset_link' class='btn btn-sm btn-outline-primary'>$reset_link</a></p>
            <p class='mt-3'><small>En producción, esto enviaría un email real al usuario</small></p>
        </div>";
        
        // Guardar token en sesión para testing
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_email'] = $email;
        $_SESSION['token_expiration'] = time() + 3600; // 1 hora de expiración
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1a2a6c, #3498db);
            border: none;
            padding: 12px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3498db, #1a2a6c);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                            <h2>Recuperar Contraseña</h2>
                            <p class="text-muted">Ingresa tu correo electrónico para recibir el enlace de recuperación</p>
                        </div>

                        <?php if (!empty($message)) echo $message; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required 
                                           placeholder="Ingresa tu correo electrónico registrado">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Enlace de Recuperación
                            </button>
                            
                            <div class="text-center">
                                <a href="../login.php" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i>Volver al Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>