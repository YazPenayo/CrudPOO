<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $producto = ucfirst($_POST["producto"]);
    $numero_producto = $_POST["numero_producto"];
    $id_marca = $_POST["id_marca"];
    $id_categoria = $_POST["id_categoria"]; 
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    $database = new Database();
    $db = $database->getConnection();

    $productoManager = new AddProducto($db);
    if ($productoManager->addProducto($producto, $numero_producto, $id_marca, $id_categoria, $precio, $stock)) {
        header("Location: ../views/productos.php");
        exit();
    } else {
        echo "Error al agregar el producto.";
    }
}

