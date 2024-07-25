<?php 
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: views/login.php");
    exit();
}
include_once "../models/database.php";
include_once "../models/functions.php";
$nombre = $_SESSION["nombre"];
$database = new Database();
$db = $database->getConnection();

$id_cliente = $_GET['id_cliente'];

$readClients = new ClienteById($db);
$cliente = $readClients->GetClientById($id_cliente);

$readPedidos = new Pedidos($db);
$pedidos = $readPedidos->getPedidos($id_cliente);

$cliente_nombre = '';
if ($cliente) {
    $cliente_nombre = htmlspecialchars($cliente['nombre'] . " " . $cliente['apellido']);
} else {
    $cliente_nombre = 'roto';
}
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
                                <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Pedido</span></a>
                            </div>
                        </div>
                    </div>
                    <?php if (empty($pedidos)) { ?>
                        <div class="alert alert-info" role="alert">
                            Hay 0 pedidos disponibles del cliente.
                        </div>
                    <?php } else { ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Cliente</th>
                                    <th>Fecha de pedido</th>
                                    <th>Descripción</th>
                                    <th>Monto Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido) { ?>
                                <tr>
                                    <td><?php echo $pedido['id_pedido'] ?></td>
                                    <td><?php echo $pedido['nombre'] . " " . $pedido['apellido'] ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($pedido['fecha_pedido'])); ?></td>
                                    <td><?php echo $pedido['descripcion'] ?></td>
                                    <td><?php echo $pedido['monto_total'] ?></td>
                                    <td class="action-icons">
                                        <a href="#editEmployeeModal" class="edit" data-toggle="modal" onclick="fillEditFormPedido(<?php echo htmlspecialchars(json_encode($pedido), ENT_QUOTES, 'UTF-8'); ?>)"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
                                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" onclick="setDeletePedidoId(<?php echo $pedido['id_pedido']; ?>)"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Insert HTML -->
        <div id="addEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../controlers/add_pedido.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar Pedido</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Cliente</label>
                                <input type="text" class="form-control" value="<?php echo $cliente_nombre ?>" readonly>
                                <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente; ?>">
                            </div>
                            <div class="form-group">
                                <label>Fecha de Pedido</label>
                                <input type="date" class="form-control" name="fecha_pedido" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Monto total</label>
                                <input type="number" class="form-control" name="monto_total" required>
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
        <!-- Update HTML -->
        <div id="editEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="../controlers/update_pedido.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Editar Pedido</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <input type="hidden" id="updatePedidoId" name="id_pedido">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Fecha de pedido</label>
                                <input type="date" class="form-control" name="fecha_pedido" id="fecha_pedido" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            </div>
                            <div class="form-group">
                                <label>Monto Total</label>
                                <input type="number" class="form-control" name="monto_total" id="monto_total" required>
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

        <!-- Delete HTML -->
        <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../controlers/delete_pedido.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar Pedido</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este pedido?</p>
                        <p class="text-warning"><small>Esta acción no tiene vuelta atrás.</small></p>
                        <input type="hidden" name="id_pedido" id="deletePedidoId" value="">
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Gestión Comercial. Todos los derechos reservados.</p>
    </footer>
    <script>
            function setDeletePedidoId(pedidoId) {
                document.getElementById('deletePedidoId').value = pedidoId;
            }

            
            function fillEditFormPedido(pedido) {
                console.log('Datos del pedido:', pedido);
                document.getElementById('updatePedidoId').value = pedido.id_pedido;
                document.getElementById('fecha_pedido').value = pedido.fecha_pedido;
                document.getElementById('descripcion').value = pedido.descripcion;
                document.getElementById('monto_total').value = pedido.monto_total;
            }
    </script>
    </body>
</html>
                           
                            