<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y validar los datos del formulario
    $fecha = $_POST["fecha_pedido"];
    $descripcion = ucfirst($_POST["descripcion"]);
    $monto_total = $_POST["monto_total"];
    $id_cliente = $_POST["id_cliente"];

    $database = new Database();
    $db = $database->getConnection();

    $pedidoManager = new AddPedido($db);
    if ($pedidoManager->addPedido($fecha, $descripcion, $monto_total, $id_cliente)) {
     
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al agregar el pedido.";
    }
}

