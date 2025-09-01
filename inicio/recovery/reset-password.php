<?php
session_start();

$error = "";
$success = "";
$valid_token = false;
$email = "";

// Verificar si hay un token válido
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verificar contra el token guardado en sesión (para testing)
    if (isset($_SESSION['reset_token']) && 
        $_SESSION['reset_token'] === $token &&
        isset($_SESSION['token_expiration']) &&
        time() < $_SESSION['token_expiration']) {
        
        $valid_token = true;
        $email = $_SESSION['reset_email'];
    } else {
        $error = "El enlace de recuperación es inválido o ha expirado";
    }
} else {
    $error = "Enlace de recuperación no válido";
}

// Procesar cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden";
    } else {
        // Simular actualización en base de datos
        // En producción, aquí actualizarías la base de datos real
        
        $success = "¡Contraseña actualizada correctamente!";
        $success .= "<br>Redirigiendo al login en 5 segundos...";
        
        // Limpiar token de sesión
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_email']);
        unset($_SESSION['token_expiration']);
        
        // Redirigir después de 5 segundos
        header("refresh:5;url=../login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
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
        .btn-success {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border: none;
            padding: 12px;
        }
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 5px;
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
                            <i class="fas fa-key fa-3x text-success mb-3"></i>
                            <h2>Restablecer Contraseña</h2>
                            <?php if ($valid_token): ?>
                                <p class="text-muted">Para: <?php echo htmlspecialchars($email); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="forgot-password.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Solicitar nuevo enlace
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($valid_token && empty($success)): ?>
                            <form method="POST" action="" id="resetForm">
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               required minlength="6" placeholder="Mínimo 6 caracteres">
                                        <button type="button" class="input-group-text toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength bg-secondary mt-1" id="passwordStrength"></div>
                                    <small class="form-text text-muted">La contraseña debe tener al menos 6 caracteres</small>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label fw-bold">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirm_password" 
                                               name="confirm_password" required placeholder="Repite tu contraseña">
                                        <button type="button" class="input-group-text toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small id="passwordMatch" class="form-text"></small>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-save me-2"></i>Actualizar Contraseña
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar contraseña
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Validar fortaleza de contraseña
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrength');
        const confirmInput = document.getElementById('confirm_password');
        const matchText = document.getElementById('passwordMatch');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });

        // Verificar coincidencia de contraseñas
        confirmInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                matchText.textContent = 'Las contraseñas no coinciden';
                matchText.style.color = '#dc3545';
            } else {
                matchText.textContent = 'Las contraseñas coinciden';
                matchText.style.color = '#28a745';
            }
        });
    </script>
</body>
</html>