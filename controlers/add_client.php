<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y validar los datos del formulario
    $nombre = ucfirst($_POST["nombre"]);
    $apellido = ucfirst($_POST["apellido"]);
    $direccion = ucwords($_POST["direccion"]);
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $dni = $_POST["dni"];

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

