<?php
require_once '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar formulario de login
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        error_log("Intento de login con email: $email");
        
        if (login($email, $password)) {
            error_log("Login exitoso para $email");
            header('Location: admin/dashboard.php');
            exit;
        } else {
            error_log("Falló el login para $email");
            $error = "Credenciales incorrectas. Por favor, intente nuevamente.";
        }
    }
    
    // Procesar recuperación de contraseña
    if (isset($_POST['recovery_email'])) {
        $recovery_email = $_POST['recovery_email'];
        error_log("Solicitud de recuperación para: $recovery_email");
        
        // Aquí iría la lógica para enviar el correo de recuperación
        // Por ahora simulamos el envío
        $recovery_success = true; // Cambiar por lógica real
        
        if ($recovery_success) {
            $recovery_message = "Se ha enviado un enlace de recuperación a $recovery_email";
        } else {
            $recovery_error = "No se encontró una cuenta con ese correo electrónico";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Denuncias</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="login-logo">
            <i class="fas fa-shield-alt"></i>
        </div>
        
        <h1 class="login-title">Acceso Encargado</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="login-form">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required 
                       placeholder="Ingrese su correo electrónico"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Ingrese su contraseña">
                <div class="forgot-password">
                    <a href="#" id="forgot-password-link">¿Olvidó su contraseña?</a>
                </div>
            </div>
            
            <button type="submit" class="login-button">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
    </div>
    
    <!-- Modal para recuperación de contraseña -->
    <div id="recoveryModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="modal-title">Recuperar Contraseña</h3>
            
            <?php if (isset($recovery_message)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($recovery_message) ?>
                </div>
            <?php elseif (isset($recovery_error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($recovery_error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="modal-form" id="recoveryForm">
                <div class="form-group">
                    <label for="recovery_email">Correo electrónico</label>
                    <input type="email" id="recovery_email" name="recovery_email" required 
                           placeholder="Ingrese su correo electrónico">
                </div>
                
                <button type="submit" class="modal-button">
                    <i class="fas fa-paper-plane"></i> Enviar Enlace
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Manejo del modal
        const modal = document.getElementById("recoveryModal");
        const btn = document.getElementById("forgot-password-link");
        const span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function(e) {
            e.preventDefault();
            modal.style.display = "block";
        }
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        // Limpiar el formulario al cerrar
        span.addEventListener('click', function() {
            document.getElementById("recoveryForm").reset();
        });
        
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                document.getElementById("recoveryForm").reset();
            }
        });
    </script>
</body>
</html>