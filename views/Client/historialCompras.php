<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HistorialCompras</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/HistorialCompras.css">
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <?php
        
        require '../../util/config.php';
        include_once '../../util/ConexionBD.php';
        include_once '../../model/UsuarioDao.php';

    
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; // Almacena la URL actual
        $correo = $_SESSION['CorreoElectronico'];
        $idCliente = $_SESSION['IdUsuario'];

        $usuario = null;
        $usuarioDao = new usuarioDao();
        $resultado = $usuarioDao->filtrarUsuarioPorCorreo($correo);

        if (!empty($resultado)) {
            $usuario = $resultado[0];
        }

        // print_r( $_SESSION);
        
        $db = new ConexionBD();
        $con = $db->conectar();

        

        $sql = $con->prepare("SELECT IdVenta, Fecha, Total  FROM venta WHERE IdUsuario = ? ORDER BY DATE(Fecha) DESC ");
        $sql->execute([$idCliente]);

    ?>

    <script>
        function cerrarSesion() {
            window.location.href = "../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }
    </script>

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
                <img class="aside__head__profile__Userlogo" src="../../public/img/LogoPrueba.jpg" alt="logoUser">
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
        
        <script src="../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">
        <div class="container">
            <h1>Mis compras</h1>
            
            <hr>

            <?php while($row = $sql->fetch(PDO::FETCH_ASSOC)) {?>
            

            <div class="card">
                <div class="card-header">
                    <?php echo $row['Fecha']; ?>
                </div>

                <div class="card-body">
                    <h5 clas="card-title">Codigo de Compra: <?php echo $row['IdVenta']; ?></h5>
                    <p class="card-text">
                       Total: <?php echo $row['Total']; ?>
                    </p>
                    <a href="DetalleCompra.php?orden=<?php echo $row['IdVenta']; ?>" class="btn btn-primary">Detalles de la Compra</a>
                </div>
            </div>

            <?php } ?>

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