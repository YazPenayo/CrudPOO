<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cliente'])) {

    $database = new Database();
    $db = $database->getConnection();
    $clientManager = new updateClient($db);
    $clienteId = intval($_POST['id_cliente']); 

    $nombre = ucfirst($_POST['nombre']);
    $apellido = ucfirst($_POST['apellido']);
    $direccion = ucwords($_POST['direccion']);
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $dni = $_POST['dni'];

    if ($clientManager->updateCliente($clienteId, $nombre, $apellido, $direccion, $email, $telefono, $dni)) {
        header("Location: ../index.php");
        exit();
    } else {
        
        echo "Error al actualizar el cliente.";
    }
}

