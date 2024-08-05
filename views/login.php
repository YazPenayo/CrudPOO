<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Comercial</title>
    <link rel="stylesheet" href="../assets/css/styles_login.css">
    <link rel="icon" type="image/png" sizes="64x64" href="../assets/img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h2 class="form-title">GESTIÓN COMERCIAL</h2>
        <img src="../assets/img/logo.png" alt="Logo de la Empresa" class="logo" width="250" height="250">
        <form id="login-form" class="login-form" action="../controlers/user.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group password-group">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <span id="toggle-password" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

                <?php if(isset($_SESSION['success_message'])): ?>
                    <div class="form-group">
                        <div id="success-message" class="success_message"><?php echo $_SESSION['success_message']; ?></div>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>


                <?php if(isset($_SESSION['error_message'])): ?>
                    <div class="form-group"> <!-- Asegura que el mensaje de error esté dentro del mismo tipo de contenedor -->
                        <div id="error-message" class="error-message"><?php echo $_SESSION['error_message']; ?></div>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                
                <button type="submit">Iniciar Sesión</button>
                <p class="register-prompt">¿No estás registrado? <a href="register.php">Regístrate aquí</a></p>
            </form>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>
