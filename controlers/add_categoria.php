<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = ucwords($_POST["categoria"]);

    $database = new Database();
    $db = $database->getConnection();

    $categoriaManager = new AddCategoria($db);
    if ($categoriaManager->addCategoria($categoria)) {
     
        header("Location: ../views/categorias.php");
        exit();
    } else {
        echo "Error al agregar la categoria.";
    }
}