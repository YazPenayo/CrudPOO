<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pedido'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $pedidoManager = new updatePedido($db);
    $pedidoId = intval($_POST['id_pedido']); 

    $fecha_pedido = $_POST['fecha_pedido'];
    $descripcion = ucwords($_POST['descripcion']);
    $monto_total = $_POST['monto_total'];

    if ($pedidoManager->updatePedidos($pedidoId, $fecha_pedido, $descripcion, $monto_total)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al actualizar el pedido. Verifica los datos y vuelve a intentarlo.";
    }
} else {
    echo "Error: Datos no recibidos correctamente.";
}

