<?php
require '../util/config.php';
require '../util/ConexionBD.php';

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $correo = isset($_POST['CorreoElectronico']) ? $_POST['CorreoElectronico'] : null;
    $tarjeta = isset($_POST['Tarjeta']) ? $_POST['Tarjeta'] : null;
    $total = isset($_POST['Total']) ? $_POST['Total'] : 0;

    // Validar datos obligatorios
    if (empty($correo) || empty($tarjeta) || $total <= 0) {
        die("Error: Faltan datos necesarios para procesar el pago.");
    }

    // Obtener carrito desde la sesión
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

    if ($productos == null) {
        die("Error: No hay productos en el carrito.");
    }

    // Conectar a la base de datos
    $db = new ConexionBD();
    $con = $db->conectar();

    try {
        // Iniciar transacción
        $con->beginTransaction();

        // Insertar en la tabla 'venta'
        $sqlVenta = "INSERT INTO venta (IdUsuario, Fecha, Correo, Tarjeta, Total) 
                     VALUES (?, NOW(), ?, ?, ?)";
        $stmtVenta = $con->prepare($sqlVenta);

        $idUsuario = isset($_POST['IdUsuario']) ? $_POST['IdUsuario'] : null; // Aquí puedes reemplazarlo con el IdUsuario real de la sesión
        $stmtVenta->execute([$idUsuario, $correo, $tarjeta, $total]);

        // Obtener el ID de la venta insertada
        $idVenta = $con->lastInsertId();

        // Insertar los productos vendidos en la tabla 'detalle_venta'
        $sqlDetalle = "INSERT INTO detalle_venta (IdVenta, IdProducto, Nombre, Cantidad, Precio) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmtDetalle = $con->prepare($sqlDetalle);

        foreach ($productos as $clave => $cantidad) {
            // Obtener información del producto desde la base de datos
            $sqlProducto = $con->prepare("SELECT NombreProducto, Precio FROM producto WHERE IdProducto = ?");
            $sqlProducto->execute([$clave]);
            $producto = $sqlProducto->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                $nombre = $producto['NombreProducto'];
                $precio = $producto['Precio'];

                // Insertar en la tabla detalle_venta
                $stmtDetalle->execute([$idVenta, $clave, $nombre, $cantidad, $precio]);
            }
        }

        // Confirmar transacción
        $con->commit();

        // Limpiar el carrito después de la compra
        unset($_SESSION['carrito']);

        // Redirigir al index.php
        header("Location: ../views/Client/EvaluacionSatisfaccion.php");
        exit();
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $con->rollBack();
        echo "Error al procesar el pago: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>