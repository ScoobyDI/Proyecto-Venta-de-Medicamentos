<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categorías</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/AdmCategoriasSubcategorias.css">
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
        // categorias
        function toggleUserStatus(categoriaId, currentStatus) {
            const newStatus = (currentStatus === 'Habilitado') ? 'deshabilitado' : 'habilitado'; // Cambio de estado
            const xhr = new XMLHttpRequest();
            
            // Corregir la URL concatenando los parámetros
            xhr.open("GET", "../../../controller/CategoriaControlador.php?op=5&IdCategoria=" + categoriaId + "&NuevoEstado=" + newStatus, true);
    
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload(); // Recargar la página para actualizar la tabla
                }
            };

            xhr.send();
        }

        function toggleUserStatus2(subcategoriaId, currentStatus) {
            const newStatus = (currentStatus === 'Habilitado') ? 'deshabilitado' : 'habilitado'; // Cambio de estado
            const xhr = new XMLHttpRequest();
            
            // Corregir la URL concatenando los parámetros
            xhr.open("GET", "../../../controller/CategoriaControlador.php?op=6&IdSubCategoria=" + subcategoriaId + "&NuevoEstado=" + newStatus, true);
    
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload(); // Recargar la página para actualizar la tabla
                }
            };

            xhr.send();
        }
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
        
        </ul>

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        
        <script src="../../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">

        <div class="section1">
            <h1 class="section1__title">Administrar Categorías</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input class="control" id="searchIdUsuario" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="">Buscar</button>
                    </div>
                </div>
                <div class="section1__options">
                    <button class="section1__addCategoria__btn" onclick="location.href='../Anadir/AnadirCategoria.php'">Nueva Categoría</button>
                </div>
            </div>
        </div>

        <div class="section2">

            <?php
                include_once '../../../util/ConexionBD.php';
                $objc = new ConexionBD();
                $con = $objc->getConexionBD();
                $sql =  "SELECT IdCategoria, NombreCategoria, DescripcionCategoria, EstadoCategoria FROM categoria";
                $rs = mysqli_query($con, $sql);
            ?>

            <table id="categoriaTable" class="section2__table">
                <thead>
                    <tr>
                        <th class="section2__table__nombre">Nombre</th>
                        <th class="section2__table__descrip">Descripcion</th>
                        <th class="section2__table__estadoCat">Estado Categoria</th>
                        <th class="section2__table__edit">Editar</th>
                        <th class="section2__table__deshabilitar">Deshabilitar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($resultado = mysqli_fetch_array($rs)){
                    ?>
                    <tr>
                        
                        <?php $link = "../Editar/editarCategoria.php?idCategoria=" . $resultado['IdCategoria'];?>

                        <td><?php echo $resultado['NombreCategoria'] ?></td>
                        <td><?php echo $resultado['DescripcionCategoria'] ?></td>
                        <td><?php echo ($resultado['EstadoCategoria'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?></td>
                        <td>
                            <button onclick="location.href='<?php echo $link ?>'" class="edit-btn">
                            <span class="material-symbols-outlined">edit</span>
                            </button>
                        </td>
                        <td>
                            <button class="btnHabDesh <?php echo ($resultado['EstadoCategoria'] == 1) ? 'habilitado' : 'deshabilitado'; ?> " 
                            onclick="toggleUserStatus(<?php echo $resultado['IdCategoria']; ?>, '<?php echo ($resultado['EstadoCategoria'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?>')">
                                <span class="material-symbols-outlined">
                                <?php echo ($resultado['EstadoCategoria'] == 1) ? 'toggle_on' : 'toggle_off'; ?>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>        
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#categoriaTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/Spanish.json",
                        "emptyTable": "No se encontraron registros coincidentes",
                        "zeroRecords": "No se encontraron registros coincidentes",
                        "info": "" ,     // Oculta la información de "Showing X to Y of Z entries"
                        "paging": true     // Mantiene la paginación visible
                    },
                    "dom": 'rtip' // Eliminar el campo de búsqueda global
                });
            });
        </script>

        <div class="section1">
            <h1 class="section1__title">Administrar Subcategorías</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <!---->
                        <input class="control" id="searchIdUsuario" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="">Buscar</button>
                    </div>
                </div>
                <div class="section1__options">
                    <button class="section1__addSubcategoria__btn" onclick="location.href='../Anadir/AnadirSubcategoria.php'">Nueva Subcategoría</button>
                </div>
            </div>
        </div>

        <div class="section2">
            <?php
                include_once '../../../util/ConexionBD.php';
                $objc = new ConexionBD();
                $con = $objc->getConexionBD();
                $sql2 = "SELECT u.IdCategoria, u.IdSubCategoria, u.NombreSubcategoria, u.EstadoSubCategoria, c.NombreCategoria
                FROM subcategoria u INNER JOIN categoria c ON u.IdCategoria = c.IdCategoria";
                $rs2 = mysqli_query($con, $sql2);
            ?>
            <table id="subcategoriasTable" class="section2__table">
                <thead>
                    <tr>
                        <th class="">Categoría</th>
                        <th class="">Subcategoría</th>
                        <th class="">Estado Sub Categoría</th>
                        <th class="section2__table__edit">Editar</th>
                        <th class="section2__table__deshabilitar">Deshabilitar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($resultado2 = mysqli_fetch_array($rs2)){
                    ?>
                    <tr>

                        <?php $link2 = "../Editar/editarSubCategoria.php?idSubCategoria=" . $resultado2['IdSubCategoria'];?>

                        <td><?php echo $resultado2['NombreCategoria'] ?></td>
                        <td><?php echo $resultado2['NombreSubcategoria'] ?></td>
                        <td><?php echo ($resultado2['EstadoSubCategoria'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?></td>
                        <td>
                            <button onclick="location.href='<?php echo $link ?>'" class="edit-btn">
                            <span class="material-symbols-outlined">edit</span>
                            </button>
                        </td>
                        <td>
                            <button class="btnHabDesh <?php echo ($resultado2['EstadoSubCategoria'] == 1) ? 'habilitado' : 'deshabilitado'; ?> " 
                            onclick="toggleUserStatus2(<?php echo $resultado2['IdSubCategoria']; ?>, '<?php echo ($resultado2['EstadoSubCategoria'] == 1) ? 'Habilitado' : 'Deshabilitado'; ?>')">
                                <span class="material-symbols-outlined">
                                <?php echo ($resultado2['EstadoSubCategoria'] == 1) ? 'toggle_on' : 'toggle_off'; ?>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>       
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#subcategoriasTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/Spanish.json",
                        "emptyTable": "No se encontraron registros coincidentes",
                        "zeroRecords": "No se encontraron registros coincidentes",
                        "info": "" ,     // Oculta la información de "Showing X to Y of Z entries"
                        "paging": true     // Mantiene la paginación visible
                    },
                    "dom": 'rtip' // Eliminar el campo de búsqueda global
                });
                
            });
        </script>

    </main>
</body>
</html>