<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/css/styles_login.css">
    <link rel="icon" type="image/png" sizes="64x64" href="../assets/img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h2 class="form-title">REGISTRO DE USUARIO</h2>
        <br>
        <br>
        <form id="register-form" class="login-form" action="../controlers/register_user.php" method="POST">
            <div class="form-group">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group password-group">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <span id="toggle-password" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="form-group password-group">
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                <span id="toggle-confirm-password" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="form-group"> <!-- Asegura que el mensaje de error esté dentro del mismo tipo de contenedor -->
                    <div id="error-message" class="error-message"><?php echo $_SESSION['error_message']; ?></div>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <button type="submit">Registrar</button>
            <p class="login-prompt">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm-password');
            const togglePassword = document.getElementById('toggle-password');
            const toggleConfirmPassword = document.getElementById('toggle-confirm-password');

            function togglePasswordVisibility(input, toggleElement) {
                toggleElement.addEventListener('click', function () {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            togglePasswordVisibility(passwordInput, togglePassword);
            togglePasswordVisibility(confirmPasswordInput, toggleConfirmPassword);
        });
    </script>
</body>
</html>
