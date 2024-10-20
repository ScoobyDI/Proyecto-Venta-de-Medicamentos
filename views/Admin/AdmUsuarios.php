<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/AdmUsuarios.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
</head>
    <?php
        session_start();
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI']; // Almacena la URL actual
    ?>
<body>
    <header class="header">
        <img src="../../public/img/logo.png">
    </header>
    <aside class="aside" id="aside">
        <div class="aside__head">
            <div class="aside__head__profile">
                <img class="aside__head__profile__Userlogo" src="../../public/img/LogoPrueba.jpg" alt="logoUser">
                <p class="aside__head__nameUser">User</p>
            </div>
            <span class="material-symbols-outlined logMenu" id="menu">menu</span>
        </div>
            
        <ul class="aside__list">
            <a href="perfilAdmin.php">
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
                    <a href="">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">medication</span>
                            <span class="option"> Adm. Productos </span>
                        </li>
                    </a>
                    <a href="">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">category</span>
                            <span class="option"> Adm. Categorías </span>
                        </li>
                    </a>
                </ul>
            </li>
            <a href="">
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
        <script src="../../public/js/aside.js"></script>
    </aside>
    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Administrar Usuarios</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input class="control" id="searchIdUsuario" placeholder="Filtrar por ID" required>
                        <button class="section1__filter__btn" onclick="buscarPorId()">Buscar</button>
                    </div>
                </div>
                <div class="section1__addUser">
                    <button class="section1__addUser__btn" id="btnAddUser" onclick="location.href='CrearUsuario.php'">Nuevo Usuario</button>
                </div>
            </div>
        </div>

        <div class="section2">
            <?php
                include_once '../../util/ConexionBD.php';
                $objc = new ConexionBD();
                $con = $objc->getConexionBD();
                $sql = "SELECT IdUsuario, Nombres, CONCAT(ApellidoPaterno, ' ', ApellidoMaterno) AS Apellidos, Telefono, CorreoElectronico, EstadoRegistro FROM usuario";
                $rs = mysqli_query($con, $sql);
            ?>
            <table id="usuariosTable" class="section2__table">
                <thead>
                    <tr>
                        <th class="section2__table__idUser">Id Usuario</th>
                        <th class="section2__table__nombres">Nombres</th>
                        <th class="section2__table__apellidos">Apellidos</th>
                        <th class="section2__table__celular">Celular</th>
                        <th class="section2__table__correo">Correo Electrónico</th>
                        <th class="section2__table__tipoUsuario">Tipo de Usuario</th>
                        <th class="section2__table__estadoRegistro">Estado Registro</th>
                        <th class="section2__table__editar">Editar</th>
                        <th class="section2__table__eliminar">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($resultado = mysqli_fetch_array($rs)){
                    ?>
                    <tr>
                        <td><?php echo $resultado['IdUsuario'] ?></td> <?php $link = "editarUsuario.php?idUsuario=" . $resultado['IdUsuario'];?>
                        <td><?php echo $resultado['Nombres'] ?></td>
                        <td><?php echo $resultado['Apellidos'] ?></td>
                        <td><?php echo $resultado['Telefono'] ?></td>
                        <td><?php echo $resultado['CorreoElectronico'] ?></td>
                        <td></td>
                        <td><?php echo $resultado['EstadoRegistro'] ?></td>
                        <td><img src="../../public/img/btnEditar.png" onclick="location.href='<?php echo $link ?>'" height="28px" alt="bntEditar"></td>
                        <td><img src="../../public/img/BtnEliminar.png" height="30px" alt="btnEliminar"></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
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