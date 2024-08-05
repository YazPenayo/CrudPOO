<?php
require_once '../models/database.php';
require_once '../models/functions.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = ucwords(trim($_POST['nombre']));
    $apellido = ucwords(trim($_POST['apellido']));
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($confirm_password)) {
        session_start();
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
        header("Location: ../views/register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        session_start();
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
        header("Location: ../views/register.php");
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();

    $userManager = new NewUser($db);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($userManager->registerUser($nombre, $apellido, $email, $hashed_password)) {
        session_start();
        $_SESSION['success_message'] = "Registro exitoso. Puedes iniciar sesión ahora.";
        header("Location: ../views/login.php");
        exit();
    } else {
        session_start();
        $_SESSION['error_message'] = "Ya se encuentra registrado el usuario.";
        header("Location: ../views/register.php");
        exit();
    }
}

