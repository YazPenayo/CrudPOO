<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: views/login.php");
    exit();
}
//hola
include_once "models/database.php";
include_once "models/functions.php";
$nombre = $_SESSION["nombre"];

$database = new Database();
$db = $database->getConnection();

$readClients = new Clients($db);
$clientes = $readClients->getClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión Comercial</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/crud.css">
    <link rel="icon" type="image/png" sizes="64x64" href="assets/img/logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar-container">
        <nav class="navbar">
            <img src="assets/img/logo.png" class="logo" height="100" width="100">
            <span class="navbar-brand">Gestión<b>Comercial</b></span>
            <div class="nav-actions">
                <h5>Hola <?php echo $nombre ?>!</h5>
                <a href="controlers/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i></a>
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
                            <h2>Gestión<b>Comercial</b></h2>
                     </div>
                        <div class="col-xs-6">
                            
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i>
                                <span>Cliente</span>
                            </a>
                            <a href="views/productos.php" class="btn btn-warning" data-toggle="modal">
                                <i class="material-icons">&#xE8B6;</i>
                                <span>Productos</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente) { ?>
                        <tr>
                            <td><?php echo $cliente['id_cliente'] ?></td>
                            <td><?php echo $cliente['nombre'] . " " . $cliente['apellido'] ?></td>
                            <td><?php echo $cliente['direccion'] ?></td>
                            <td><?php echo $cliente['email'] ?></td>
                            <td><?php echo $cliente['telefono'] ?></td>
                            <td class="action-icons">
                                <a href="views/pedido.php?id_cliente=<?php echo $cliente['id_cliente'] ?>" class="pedido">
                                    <i class="fas fa-clipboard-list" data-toggle="tooltip" title="Pedidos"></i>
                                </a>
                                <a href="#editEmployeeModal" class="edit" data-toggle="modal" onclick="fillEditForm(<?php echo htmlspecialchars(json_encode($cliente), ENT_QUOTES, 'UTF-8'); ?>)"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
                                <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" onclick="setDeleteClientId(<?php echo $cliente['id_cliente']; ?>)"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="controlers/delete_client.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este cliente?</p>
                        <p class="text-warning"><small>Esta acción no tiene vuelta atrás.</small></p>
                        <input type="hidden" name="id_cliente" id="deleteClientId" value="">
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
                <form method="POST" action="controlers/add_client.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" class="form-control" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" class="form-control" name="dni" required>
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
                <form method="POST" action="controlers/update_client.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <input type="hidden" name="id_cliente" id="updateClientId" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" class="form-control" name="apellido" id="apellido">
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="direccion" id="direccion">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono">
                        </div>
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni">
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
        function toggleMenu() {
        var menu = document.getElementById('menuOptions');
        var hamburger = document.querySelector('.hamburger');

            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                hamburger.classList.remove('active');
            } else {
                menu.classList.add('show');
                hamburger.classList.add('active');
            }
        }
        function setDeleteClientId(clientId) {
            document.getElementById('deleteClientId').value = clientId;
        }

        function fillEditForm(cliente) {
            console.log('Datos del cliente:', cliente);
            document.getElementById('updateClientId').value = cliente.id_cliente;
            document.getElementById('nombre').value = cliente.nombre;
            document.getElementById('apellido').value = cliente.apellido;
            document.getElementById('direccion').value = cliente.direccion;
            document.getElementById('email').value = cliente.email;
            document.getElementById('telefono').value = cliente.telefono;
            document.getElementById('dni').value = cliente.dni;
        }
    </script>
</body>
</html>
