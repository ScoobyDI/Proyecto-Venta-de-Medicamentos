<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/AdmProductos.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <?php
        include_once '../../../model/UsuarioDao.php';
        include_once '../../../util/ConexionBD.php';

        session_start();
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; // Almacena la URL actual
        $correo = $_SESSION['CorreoElectronico'];
        $usuario = null;
        $usuarioDao = new usuarioDao();
        $resultado = $usuarioDao->filtrarUsuarioPorCorreo($correo);

        if (!empty($resultado)) {
            $usuario = $resultado[0];
        }

        // Conexión a la base de datos y obtención de los productos
        $objc = new ConexionBD();
        $con = $objc->getConexionBD();
        $sql = "SELECT p.IdProducto, p.NombreProducto, p.DescripcionProducto, p.Precio, s.NombreSubcategoria, p.EstadoRegistro 
        FROM producto p 
        JOIN subcategoria s ON p.IdSubcategoria = s.IdSubcategoria";
        $rs = mysqli_query($con, $sql);
    ?>

    <script>
        function cerrarSesion() {
            window.location.href = "../../../controller/logout.php";
        }
    </script>

</head>

<body>

    <header class="header">
        <img src="../../../public/img/logo.png" alt="Logo">
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
            <h1 class="section1__title">Administrar Productos</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input id="searchProducto" class="control" placeholder="Filtrar por nombre" required>
                        <button class="section1__filter__btn" onclick="filtrarPorNombre()">Buscar</button>
                    </div>
                </div>
                <div class="section1__options">
                    <button class="section1__addProduct__btn" onclick="location.href='../Anadir/AnadirProducto.php'">Nuevo Producto</button>
                </div>
            </div>
        </div>

        <div class="section2">
        <table id="productosTable" class="section2__table">
        <thead>
            <tr>
                <th class="thAling">Id Producto</th>
                <th class="thAling">Nombre</th>
                <th class="thAling">Descripción</th>
                <th class="thAling">Precio</th>
                <th class="thAling">Subcategoría</th>
                <th class="thAling">Editar</th> <!-- Nueva columna -->
                <th class="thAling">Habilitar / Deshabilitar</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            <?php while($producto = mysqli_fetch_assoc($rs)) { ?>
                <tr>
                    <td><?php echo $producto['IdProducto']; ?></td>
                    <td><?php echo htmlspecialchars($producto['NombreProducto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['DescripcionProducto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['Precio']); ?></td>
                    <td><?php echo htmlspecialchars($producto['NombreSubcategoria']); ?></td>
                    <!-- Botón de Editar -->
                    <td>
                        <button onclick="location.href='../Editar/editarProducto.php?idProducto=<?php echo $producto['IdProducto']; ?>'" class="edit-btn">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                    </td>
                    <!-- Botón de Habilitar/Deshabilitar -->
                    <td class="tdCenter">
                        <button class="btnHabDesh <?php echo ($producto['EstadoRegistro'] == 1) ? 'habilitado' : 'deshabilitado'; ?>" 
                                onclick="toggleProductStatus(<?php echo $producto['IdProducto']; ?>, '<?php echo ($producto['EstadoRegistro'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?>')">
                            <span class="material-symbols-outlined">
                                <?php echo ($producto['EstadoRegistro'] == 1) ? 'toggle_on' : 'toggle_off'; ?>
                            </span>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
        </div>
    </main>

    <!-- Scripts de DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#productosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/Spanish.json",
                    "emptyTable": "No se encontraron productos"
                },
                "dom": 'rtip'
            });
        });

        function filtrarPorNombre() {
            var nombreProducto = $('#searchProducto').val();
            var table = $('#productosTable').DataTable();
            table.columns(1).search(nombreProducto).draw(); // Filtra por la columna de Nombre
        }
    </script>
    <script>
    function toggleProductStatus(productId, currentStatus) {
        const newStatus = (currentStatus === 'Habilitado') ? 'deshabilitado' : 'habilitado';
        const xhr = new XMLHttpRequest();
        
        xhr.open("GET", "../../../controller/ProductoControlador.php?op=4&IdProducto=" + productId + "&NuevoEstado=" + newStatus, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload(); // Recargar la página para actualizar la tabla
            }
        };

        xhr.send();
    }
</script>
</body>
</html>