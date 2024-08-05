<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y validar los datos del formulario
    $nombre = ucfirst(trim($_POST["nombre"]));
    $apellido = ucfirst(trim($_POST["apellido"]));
    $direccion = ucwords(trim($_POST["direccion"]));
    $email = trim($_POST["email"]);
    $telefono = trim($_POST["telefono"]);
    $dni = trim($_POST["dni"]);

    $database = new Database();
    $db = $database->getConnection();

    $clientManager = new AddClient($db);
    if ($clientManager->addCliente($nombre, $apellido, $direccion, $email, $telefono, $dni)) {
     
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al agregar el cliente.";
    }
}

