<?php
require_once '../models/database.php';
require_once '../models/functions.php';

$dbInstance = new Database();
$dbConnection = $dbInstance->getConnection();

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userModel = new User($dbConnection);
    $userData = $userModel->getUserByEmail($email);

    if ($userData && $password === $userData['password']) {
        $_SESSION['email'] = $userData['email'];
        $_SESSION['nombre'] = $userData['user_name'];
        
        header('Location: ../index.php');
        exit();
    } else {
        // Si no se encontró coincidencia, mostrar un mensaje de error
        $_SESSION['error_message'] = 'Contraseña o email incorrectos. Vuelva a intentarlo.';
        header('Location: ../views/login.php');
        exit();
    }
}

