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
$productos = $readProductos->getProductos();
$marcas = $readProductos->getMarcas();
$categorias = $readProductos->getCategorias();

/*var_dump($productos);
exit();*/
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
                                <span>Productos</span>
                            </a>
                            <a href="../views/marcas.php" class="btn btn-warning" data-toggle="modal">
                                <i class="material-icons">&#xE8B6;</i>
                                <span>Marcas</span>
                            </a>
                            <a href="../views/categorias.php" class="btn btn-info" data-toggle="modal">
                                <i class="material-icons">&#xE8B6;</i>
                                <span>Categorías</span>
                            </a>
                            <a href="../index.php" class="btn btn-primary">
                                <i class="material-icons">&#xE88A;</i> 
                                <span>Inicio</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if (empty($productos)) { ?>
                        <div class="alert alert-info" role="alert">
                            Hay 0 productos disponibles.
                        </div>
                    <?php } else { ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>N° de Producto</th>
                            <th>Marca</th>
                            <th>Categoria</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto['id_producto'] ?></td>
                            <td><?php echo $producto['producto'] ?></td>
                            <td><?php echo $producto['numero_producto'] ?></td>
                            <td><?php echo $producto['marca'] ?></td>
                            <td><?php echo $producto['categoria'] ?></td>
                            <td><?php echo $producto['stock'] ?></td>
                            <td><?php echo $producto['precio'] ?></td>
                            <td class="action-icons">
                                <a href="#editEmployeeModal" class="edit" data-toggle="modal" onclick="fillEditFormProducto(<?php echo htmlspecialchars(json_encode($producto), ENT_QUOTES, 'UTF-8'); ?>)"><i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i></a>
                                <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" onclick="setDeleteProductoId(<?php echo $producto['id_producto']; ?>)"><i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i></a>
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
                <form method="POST" action="../controlers/delete_producto.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este producto?</p>
                        <p class="text-warning"><small>Esta acción no tiene vuelta atrás.</small></p>
                        <input type="hidden" name="id_producto" id="deleteProductoId" value="">
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
                <form method="POST" action="../controlers/add_producto.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Producto</label>
                            <input type="text" class="form-control" name="producto" required>
                        </div>
                        <div class="form-group">
                            <label>N° de Serie</label>
                            <input type="number" class="form-control" name="numero_producto" required>
                        </div>
                        <div class="form-group">
                            <label>Marca</label>
                            <select class="form-control" name="id_marca" required>
                                <option value="">Selecciona una marca</option>
                                <?php foreach ($marcas as $marca) { ?>
                                    <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['marca']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" name="id_categoria" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['categoria']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" class="form-control" name="precio" required>
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
                <form method="POST" action="../controlers/update_producto.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <input type="hidden" name="id_producto" id="updateProductoId" value="">
                    <div class="modal-body">
                    <div class="form-group">
                            <label>Producto</label>
                            <input type="text" class="form-control" name="producto" id="producto" required>
                        </div>
                        <div class="form-group">
                            <label>N° de Serie</label>
                            <input type="number" class="form-control" name="numero_producto" id="numero_producto" required>
                        </div>
                        <div class="form-group">
                            <label>Marca</label>
                            <select class="form-control" name="id_marca" id="id_marca" required>
                                <?php foreach ($marcas as $marca) { ?>
                                    <option value="<?php echo $marca['id_marca']; ?>" <?php echo ($marca['id_marca'] === $producto['id_marca']) ? 'selected' : ''; ?>>
                                        <?php echo $marca['marca']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" name="id_categoria" id="id_categoria" required>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['categoria']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>stock</label>
                            <input type="number" class="form-control" name="stock" id="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" class="form-control" name="precio" id="precio" required>
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
        function setDeleteProductoId(productoId) {
            document.getElementById('deleteProductoId').value = productoId;
        }

        function fillEditFormProducto(producto) {
            console.log('Datos del producto:', producto);
            document.getElementById('updateProductoId').value = producto.id_producto;
            document.getElementById('producto').value = producto.producto;
            document.getElementById('numero_producto').value = producto.numero_producto;
            document.getElementById('id_marca').value = producto.id_marca;
            document.getElementById('id_categoria').value = producto.id_categoria;
            document.getElementById('precio').value = producto.precio;
            document.getElementById('stock').value = producto.stock;
        }
        // Selección de la categoría correspondiente
        var select = document.getElementById('id_categoria');
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value == producto.id_categoria) {
                select.selectedIndex = i;
                break;
            }
        }
        
        document.getElementById('precio').value = producto.precio;
        document.getElementById('stock').value = producto.stock;
        
    </script>
</body>
</html>
