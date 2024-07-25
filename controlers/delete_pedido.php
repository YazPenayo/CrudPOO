<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pedido'])) {

    $database = new Database();
    $db = $database->getConnection();

    $pedidoManager = new deletePedidos($db);
    $pedidoId = intval($_POST['id_pedido']);//validacion
    if ($pedidoManager->deletePedido($pedidoId)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al eliminar el pedido.";
    }
}
