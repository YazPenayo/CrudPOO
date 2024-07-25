<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_marca'])) {

    $database = new Database();
    $db = $database->getConnection();
    $marcaManager = new deleteMarcas($db);
    $marcaId = intval($_POST['id_marca']);

    if ($marcaManager->deleteMarca($marcaId)) {
        header("Location: ../views/marcas.php");
        exit();
    } else {
        echo "Error al eliminar la marca.";
    }
}

