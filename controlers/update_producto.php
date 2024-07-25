<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_producto'])) {

    $database = new Database();
    $db = $database->getConnection();
    $productoManager = new updateProducto($db);
    $productoId = intval($_POST['id_producto']); 
    $producto = ucfirst($_POST['producto']);
    $numero_producto = $_POST['numero_producto'];
    $id_marca = $_POST['id_marca'];
    $id_categoria = $_POST['id_categoria'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    if ($productoManager->updateProductos($productoId, $producto, $numero_producto, $id_marca, $id_categoria, $stock, $precio)) {
        header("Location: ../views/productos.php");
        exit();
    } else {
        
        echo "Error al actualizar el producto.";
    }
}

