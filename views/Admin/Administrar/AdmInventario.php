<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Inventarios</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/AdmInventario.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">


    <?php
        include_once '../../../model/UsuarioDao.php';
        session_start();
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; // Almacena la URL actual
        $correo = $_SESSION['CorreoElectronico'];
        $usuario = null;
        $usuarioDao = new usuarioDao();
        $resultado = $usuarioDao->filtrarUsuarioPorCorreo($correo);

        if (!empty($resultado)) {
            $usuario = $resultado[0];
        }
    ?>

    <script>
        function cerrarSesion() {
            window.location.href = "../../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }
    </script>

</head>

<body>

    <header class="header">
        <img src="../../../public/img/logo.png">
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
            <a href="../perfilAdmin.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">account_circle</span>
                    <span class="option"> Perfil </span>
                </li>
            </a>
            <li class="aside__list__options__dropdown">
                <div class="aside__list__button">
                    <span class="material-symbols-outlined iconOption">manufacturing</span>
                    <span class="option"> Administrar </span>
                    <span class="material-symbols-outlined list__arrow">keyboard_arrow_down</span>
                </div>
                <ul class="aside__list__show">
                    <a href="AdmUsuarios.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">groups</span>
                            <span class="option"> Adm. Usuarios </span>
                        </li>
                    </a>
                    <a href="AdmPerfiles.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">assignment_ind</span>
                            <span class="option"> Adm. Perfiles </span>
                        </li>
                    </a>
                    <a href="AdmDistritos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">location_city</span>
                            <span class="option"> Adm. Distritos </span>
                        </li>
                    </a>
                    <a href="AdmProductos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">medication</span>
                            <span class="option"> Adm. Productos </span>
                        </li>
                    </a>
                    <a href="AdmCategorias.php">
                        <li class="aside__list__inside">
                        <span class="material-symbols-outlined iconOption">category</span>
                            <span class="option"> Adm. Categorías </span>
                        </li>
                    </a>
                </ul>
            </li>
            <a href="AdmInventario.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">inventory</span>
                    <span class="option"> Stock de Productos </span>
                </li>
            </a>
            <a href="">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">sell</span>
                    <span class="option"> Precios </span>
                </li>
            </a>
            <a href="">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">order_approve</span>
                    <span class="option"> Pedidos </span>
                </li>
            </a>
        </ul>

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        
        <script src="../../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Administrar Inventarios</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input class="control" id="searchNombreProducto" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="buscarPorNombre()">Buscar</button>
                    </div>
                    
                </div>
                <div class="section1__AdmLotes">
                    <button class="section1__AdmLotes__btn" onclick="window.location.href='AdmLotes.php'">Administrar Lotes</button>
                </div>
  
            </div>
        </div>

        <div class="section2">
            <div class="section2_container">
                <?php 
                         // Conexión a la base de datos y obtención de los productos
                        $objc = new ConexionBD();
                        $con = $objc->getConexionBD();
                        $sql = "SELECT p.NombreProducto AS Nombre,SUM(i.Cantidad) AS StockTotal FROM inventario i
                                INNER JOIN producto p ON i.IdProducto = p.IdProducto
                                GROUP BY i.IdProducto;";
                        $rs = mysqli_query($con, $sql);
                ?>
                <table id="InventarioTable" class="section2__table">
                    <thead>
                        <tr>
                            <th class="section2__table_nombre">Nombre</th>
                            <th class="section2__table_stockTotal">Stock Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($inventario = mysqli_fetch_assoc($rs)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($inventario['Nombre']); ?></td>
                                <td class="tdCenter"><?php echo htmlspecialchars($inventario['StockTotal']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>

       $(document).ready(function() {
            $('#InventarioTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
                    "emptyTable": "No se encontraron registros coincidentes",
                    "zeroRecords": "No se encontraron registros coincidentes"
                },
                "dom": 'rtip' // Eliminar el campo de búsqueda global
            });
        });

        function buscarPorNombre() {
            event.preventDefault();
            var nombre = $('#searchNombreProducto').val();
            var table = $('#InventarioTable').DataTable();
            table.columns(0).search(nombre).draw(); // BUSCA LA PRIMERA COLUMNA Q ES DE NOMBRE }:V
        }


</script>
</html>


