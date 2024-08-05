<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_producto'])) {

    $database = new Database();
    $db = $database->getConnection();
    $productoManager = new deleteProductos($db);
    $productoId = intval($_POST['id_producto']);//validacion

    if ($productoManager->deleteProducto($productoId)) {
        header("Location: ../views/productos.php");
        exit();
    } else {
        echo "Error al eliminar el producto.";
    }
}

