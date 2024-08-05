<?php
require_once '../models/database.php';
require_once '../models/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = ucwords($_POST["marca"]);

    $database = new Database();
    $db = $database->getConnection();

    $marcaManager = new AddMarca($db);
    if ($marcaManager->addMarca($marca)) {
     
        header("Location: ../views/marcas.php");
        exit();
    } else {
        echo "Error al agregar la marca.";
    }
}