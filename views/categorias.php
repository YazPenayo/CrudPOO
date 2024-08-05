<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: ../views/login.php");
    exit();
}
include_once "../models/database.php";
include_once "../models/functions.php";
$nombre = $_SESSION["nombre"];
$database = new Database();
$db = $database->getConnection();

$readProductos = new Productos($db);
$categorias = $readProductos->getCategorias();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion Comercial</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/crud.css">
    <link rel="icon" type="image/png" sizes="64x64" href="../assets/img/logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar-container">
            <nav class="navbar">
                <img src="../assets/img/logo.png" class="logo" height="100" width="100">
                <span class="navbar-brand">Gestión<b>Comercial</b></span>
                <div class="nav-actions">
                    <h5>Hola <?php echo $nombre ?>!</h5>
                    <a href="../controlers/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </nav>
    </div>
    <div class="margin-top"></div>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2>Gestion<b>Comercial</b></h2>
                        </div>
                        <div class="col-xs-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i>
                                <span>Categorias</span>
                            </a>
                            <a href="../views/marcas.php" class="btn btn-warning" data-toggle="modal">
                                <i class="material-icons">&#xE8B6;</i>
                                <span>Marcas</span>
                            </a>
                            <a href="../index.php" class="btn btn-primary">
                                <i class="material-icons">&#xE88A;</i> <!-- Aquí puedes usar cualquier ícono que te guste -->
                                <span>Inicio</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if (empty($categorias)) { ?>
                        <div class="alert alert-info" role="alert">
                            Hay 0 categorias disponibles.
                        </div>
                    <?php } else { ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>N°</th>
                            <th></th>
                            <th>Categoria</th>
                            <th></th>
                            <th>Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria) { ?>
                        <tr>
                            <th></th>
                            <td><?php echo $categoria['id_categoria'] ?></td>
                            <td></td>
                            <td><?php echo $categoria['categoria'] ?></td>
                            <td></td>
                            <td class="action-icons">
                                <a href="#editEmployeeModal" class="edit" data-toggle="modal" onclick="fillEditFormCategoria(<?php echo htmlspecialchars(json_encode($categoria), ENT_QUOTES, 'UTF-8'); ?>)"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
                                <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" onclick="setDeleteCategoriaId(<?php echo $categoria['id_categoria']; ?>)"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
                            </td>
                            
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../controlers/delete_categoria.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar Categoria</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este categoria?</p>
                        <p class="text-warning"><small>Esta acción no tiene vuelta atrás.</small></p>
                        <input type="hidden" name="id_categoria" id="deleteCategoriaId" value="">
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../controlers/add_categoria.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Categoria</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>categoria</label>
                            <input type="text" class="form-control" name="categoria" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Agregar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../controlers/update_categoria.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Categoria</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <input type="hidden" name="id_categoria" id="updateCategoriaId" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>categoria</label>
                            <input type="text" class="form-control" name="categoria" id="categoria" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-info" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Gestión Comercial. Todos los derechos reservados.</p>
    </footer>
    <script>
        function setDeleteCategoriaId(categoriaId) {
            document.getElementById('deleteCategoriaId').value = categoriaId;
        }

        function fillEditFormCategoria(categoria) {
            console.log('Datos del categoria:', categoria);
            document.getElementById('updateCategoriaId').value = categoria.id_categoria;
            document.getElementById('categoria').value = categoria.categoria;
        }
    </script>
</body>
</html>
