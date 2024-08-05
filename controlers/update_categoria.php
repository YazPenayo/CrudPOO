<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_categoria'])) {

    $database = new Database();
    $db = $database->getConnection();
    $categoriaManager = new updateCategoria($db);
    $categoriaId = intval($_POST['id_categoria']); 

    $categoria = $_POST['categoria'];
    $categoriaCapitalizada = ucwords(strtolower($categoria)); 

    if ($categoriaManager->updateCategorias($categoriaId, $categoriaCapitalizada)) {
        header("Location: ../views/categorias.php");
        exit();
    } else {
        echo "Error al actualizar la categoría.";
    }
}

