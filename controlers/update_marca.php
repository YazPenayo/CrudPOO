<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_marca'])) {

    $database = new Database();
    $db = $database->getConnection();
    $marcaManager = new updateMarca($db);
    $marcaId = intval($_POST['id_marca']); 

    $marca = $_POST['marca'];
    $marcaCapitalizada = ucwords(strtolower($marca)); 

    if ($marcaManager->updateMarcas($marcaId, $marcaCapitalizada)) {
        header("Location: ../views/marcas.php");
        exit();
    } else {
        echo "Error al actualizar la marca.";
    }
}

