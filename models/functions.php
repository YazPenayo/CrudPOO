<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////LOGIN/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class User {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class NewUser {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    public function registerUser($nombre, $apellido, $email, $password) {

        if ($this->getUserByEmail($email)) {
            return false; 
        }

        $sql = "INSERT INTO users (user_name, last_name, email, password, id_rol) VALUES (:user_name, :last_name, :email, :password, :id_rol)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':user_name', $nombre);
        $stmt->bindParam(':last_name', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $id_rol = 1;
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////CLIENTES/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class Clients {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getClientes() {
        $stmt = $this->db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class deleteClients {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function deleteCliente($id) {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id_cliente = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}

class AddClient {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addCliente($nombre, $apellido, $direccion, $email, $telefono, $dni) {
        // Preparar la consulta SQL para insertar un nuevo cliente
        $stmt = $this->db->prepare("INSERT INTO clientes (nombre, apellido, direccion, email, telefono, dni) VALUES (:nombre, :apellido, :direccion, :email, :telefono, :dni)");
        
        // Vincular los parámetros de la consulta con los valores recibidos
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':dni', $dni);
        
        // Ejecutar la consulta
        return $stmt->execute();
    }
}

class ClienteById {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function GetClientById($id) {
        $stmt = $this->db->prepare("SELECT id_cliente, nombre, apellido FROM clientes WHERE id_cliente = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Obtiene el resultado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class updateClient {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updateCliente($id_cliente, $nombre, $apellido, $direccion, $email, $telefono, $dni) {
        // Preparar la consulta SQL para actualizar los datos del cliente
        $stmt = $this->db->prepare("UPDATE clientes SET nombre = :nombre, apellido = :apellido, direccion = :direccion, email = :email, telefono = :telefono, dni = :dni WHERE id_cliente = :id_cliente");
        
        // Vincular los parámetros de la consulta con los valores recibidos
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':dni', $dni);
        
        // Ejecutar la consulta
        return $stmt->execute();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////PEDIDOS/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class Pedidos {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getPedidos($id_cliente) {
        $stmt = $this->db->prepare("SELECT p.id_pedido,
                                           p.fecha_pedido,
                                           p.descripcion,
                                           p.monto_total,
                                           p.id_cliente,
                                           c.nombre,
                                           c.apellido
                                    FROM pedidos p 
                                    JOIN clientes c ON p.id_cliente = c.id_cliente 
                                    WHERE p.id_cliente = :id_cliente");
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class deletePedidos {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function deletePedido($id) {
        $stmt = $this->db->prepare("DELETE FROM pedidos WHERE id_pedido = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}

class AddPedido {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addPedido($fecha, $descripcion, $monto_total, $id_cliente) {
        $stmt = $this->db->prepare("INSERT INTO pedidos (fecha_pedido, descripcion, monto_total, id_cliente) VALUES (:fecha_pedido, :descripcion, :monto_total, :id_cliente)");
        $stmt->bindParam(':fecha_pedido', $fecha);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':monto_total', $monto_total);
        $stmt->bindParam(':id_cliente', $id_cliente);
        return $stmt->execute();
    }
}

class updatePedido {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updatePedidos($id_pedido, $fecha_pedido, $descripcion, $monto_total) {
        $stmt = $this->db->prepare("UPDATE pedidos SET fecha_pedido = :fecha_pedido, descripcion = :descripcion, monto_total = :monto_total WHERE id_pedido = :id_pedido");
        
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->bindParam(':fecha_pedido', $fecha_pedido);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':monto_total', $monto_total);
        
        return $stmt->execute();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////PRODUCTOS/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class Productos {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getProductos() {
        
            $query = "SELECT p.id_producto,
                             p.producto,
                             p.numero_producto,
                             p.id_marca,
                             m.marca AS marca,
                             p.id_categoria,
                             cat.categoria AS categoria,
                             p.precio,
                             p.stock
                      FROM productos p 
                      JOIN marcas m ON p.id_marca = m.id_marca
                      JOIN categorias cat ON p.id_categoria = cat.id_categoria";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function getMarcas() {
        try {
            $query = "SELECT * FROM marcas";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la consulta de marcas: " . $e->getMessage();
            return [];
        }
    }

    public function getCategorias() {
        try {
            $query = "SELECT * FROM categorias";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la consulta de categorías: " . $e->getMessage();
            return [];
        }
    }
}


class deleteProductos {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function deleteProducto($id) {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}

class AddProducto {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addProducto($producto, $numero_producto, $id_marca, $id_categoria, $precio, $stock) {
        $stmt = $this->db->prepare("INSERT INTO productos (producto, numero_producto, id_marca, id_categoria, precio, stock) VALUES (:producto, :numero_producto, :id_marca, :id_categoria, :precio, :stock)");
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':numero_producto', $numero_producto);
        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        return $stmt->execute();
    }
}


class updateProducto {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updateProductos($id_producto, $producto, $numero_producto, $id_marca, $id_categoria, $precio, $stock) {
        $stmt = $this->db->prepare("UPDATE productos SET producto = :producto, numero_producto = :numero_producto, id_marca = :id_marca, id_categoria = :id_categoria, precio = :precio, stock = :stock WHERE id_producto = :id_producto");

        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':numero_producto', $numero_producto);
        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);

        return $stmt->execute();

    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////MARCAS/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class deleteMarcas {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function deleteMarca($id) {
         // Verificar si hay productos asociados a esta marca
         $stmtCheck = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE id_marca = :id");
         $stmtCheck->bindParam(':id', $id);
         $stmtCheck->execute();
         $count = $stmtCheck->fetchColumn();
 
         if ($count > 0) {
            echo "<script>alert('No se puede eliminar la marca porque tiene productos asociados.');</script>";
            echo "<script>window.location.href = '../views/marcas.php';</script>";
            exit(); // Salir del script para evitar cualquier otra ejecución
         }
 
         // No hay productos asociados, proceder con la eliminación de la marca
         $stmtDelete = $this->db->prepare("DELETE FROM marcas WHERE id_marca = :id");
         $stmtDelete->bindParam(':id', $id);
         return $stmtDelete->execute();
    }

}

class AddMarca {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addMarca($marca) {
        $stmt = $this->db->prepare("INSERT INTO marcas (marca) VALUES (:marca)");
        $stmt->bindParam(':marca', $marca);
        return $stmt->execute();
    }
}

class updateMarca {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updateMarcas($id_marca, $marca) {
        $stmt = $this->db->prepare("UPDATE marcas SET marca = :marca WHERE id_marca = :id_marca");

        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->bindParam(':marca', $marca);
        return $stmt->execute();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////CATEGORIAS/////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class deleteCategorias {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function deleteCategoria($id) {
        $stmtCheck = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE id_categoria = :id");
        $stmtCheck->bindParam(':id', $id);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('No se puede eliminar la categoría porque tiene productos asociados.');</script>";
            echo "<script>window.location.href = '../views/categorias.php';</script>";
            exit(); 
        }

        $stmtDelete = $this->db->prepare("DELETE FROM categorias WHERE id_categoria = :id");
        $stmtDelete->bindParam(':id', $id);
        return $stmtDelete->execute();
    }
}

class AddCategoria {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addCategoria($categoria) {
        $stmt = $this->db->prepare("INSERT INTO categorias (categoria) VALUES (:categoria)");
        $stmt->bindParam(':categoria', $categoria);
        return $stmt->execute();
    }
}

class updateCategoria {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function updateCategorias($id_categoria, $categoria) {
        $stmt = $this->db->prepare("UPDATE categorias SET categoria = :categoria WHERE id_categoria = :id_categoria");

        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':categoria', $categoria);
        return $stmt->execute();
    }
}