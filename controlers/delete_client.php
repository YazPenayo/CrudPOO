<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cliente'])) {

    $database = new Database();
    $db = $database->getConnection();
    $clientManager = new deleteClients($db);
    $clienteId = intval($_POST['id_cliente']);//validacion

    if ($clientManager->deleteCliente($clienteId)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al eliminar el cliente.";
    }
}

