<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_categoria'])) {

    $database = new Database();
    $db = $database->getConnection();
    $categoriaManager = new deleteCategorias($db);
    $categoriaId = intval($_POST['id_categoria']);

    if ($categoriaManager->deleteCategoria($categoriaId)) {
        header("Location: ../views/categorias.php");
        exit();
    } else {
        echo "Error al eliminar la categoria.";
    }
}

