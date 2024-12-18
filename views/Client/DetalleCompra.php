<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Compras</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/HistorialCompras.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <?php
        
        require '../../util/config.php';
        include_once '../../util/ConexionBD.php';
        include_once '../../model/UsuarioDao.php';

    
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; // Almacena la URL actual
        $correo = $_SESSION['CorreoElectronico'];
        $idCliente = $_SESSION['IdUsuario'];
        $orden = $_GET['orden'] ?? null;

        $usuario = null;
        $usuarioDao = new usuarioDao();
        $resultado = $usuarioDao->filtrarUsuarioPorCorreo($correo);

        if (!empty($resultado)) {
            $usuario = $resultado[0];
        }
        
        $db = new ConexionBD();
        $con = $db->conectar();

        $sqlCompra = $con->prepare("SELECT IdVenta, Fecha, Total  FROM venta WHERE IdVenta = ? LIMIT 1 ");
        $sqlCompra->execute([$orden]);
        $rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);

        $sqlDetalle = $con->prepare("SELECT Nombre, Cantidad, Precio  FROM detalle_venta WHERE IdVenta = ?  ");
        $sqlDetalle->execute([$orden]);
    
        
    ?>

</head>

<body>

    <header class="header">
        <div class="header_logo">
            <img src="../../public/img/logo.png">
        </div>
        <div class="header_option"> 
            <a class="Boton"  href="../../index.php">
                <span class="material-symbols-outlined iconOption">shopping_cart</span>
                <span class="option"> Catálogo de Productos</span>
            </a>
        </div>
    </header>

    <aside class="aside" id="aside">
        <div class="aside__head">
            <div class="aside__head__profile">
                <img class="aside__head__profile__Userlogo" src="../../../public/img/LogoPrueba.jpg" alt="logoUser">
                <p class="aside__head__nameUser"><?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?></p>
            </div>
            <span class="material-symbols-outlined logMenu" id="menu">menu</span>
        </div>
            
        <ul class="aside__list">
            <a href="AdmPerfil.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">account_circle</span>
                    <span class="option"> Perfil </span>
                </li>
            </a>
            
            <a href="historialCompras.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">order_approve</span>
                    <span class="option"> Historial de Compras </span>
                </li>
            </a>
        </ul>

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        
        <script src="../../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">
        <div class="container">
            <h1>Detalle de Compra</h1>
            <div class="row">
                <div class="col-12 col-md-4">
                  <div class="card mb-3">  
                            <div class="card-header">
                                <strong>Detalles</strong>
                            </div>
                            <div class="card-body">
                                <p><strong>Fecha: <?php echo $rowCompra['Fecha']; ?></strong></p>
                                <p><strong>Orden: <?php echo $rowCompra['IdVenta']; ?></strong></p>
                                <p><strong>Total: 
                                    <?php echo MONEDA . number_format($rowCompra['Total'], 2, '.', ','); ?>
                                </strong></p>
                            </div>
                        </div>
                </div> 
                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)){
                                        $cantidad = $row['Cantidad'];
                                        $precio = $row['Precio'];
                                        $subtotal = $precio*$cantidad;
                                    
                                ?>
                                <tr>
                                    <td><?php echo $row['Nombre']; ?></td>
                                    <td><?php echo $precio ?></td>
                                    <td><?php echo $cantidad ?></td>
                                    <td><?php echo $subtotal ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table> 
                    </div>
                </div>     
            </div>   
        </div>
            
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#usuariosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/Spanish.json",
                    "emptyTable": "No se encontraron registros coincidentes",
                    "zeroRecords": "No se encontraron registros coincidentes"
                },
                "dom": 'rtip' // Eliminar el campo de búsqueda global
            });
        });
        
        function buscarPorId() {
            event.preventDefault();
            var id = $('#searchIdUsuario').val();
            var table = $('#usuariosTable').DataTable();
            table.columns(0).search(id).draw(); // Filtrar solo por la primera columna (ID Usuario)
        }
    </script>
</body>
</html>