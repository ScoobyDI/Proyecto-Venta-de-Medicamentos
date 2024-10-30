<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Perfiles</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/AdmPerfiles.css">
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

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>

        <script src="../../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Administrar Perfiles</h1>
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input class="control" id="searchIdUsuario" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="">Buscar</button>
                    </div>
                </div>
                <div class="section1__options">
                    <button class="section1__addPerfil__btn" onclick="location.href='../Anadir/AnadirPerfil.php'">Nuevo Perfil</button>
                </div>
            </div>
        </div>

        <div class="section2">
            <?php
                include_once '../../../util/ConexionBD.php';
                $objc = new ConexionBD();
                $con = $objc->getConexionBD();
                $sql =  "SELECT IdPerfil, Nombre, Descripcion, EstadoRegistro FROM perfiles";
                $rs = mysqli_query($con, $sql);
            ?>
            <table id="perfilesTable" class="section2__table">
                <thead>
                    <tr>
                        <th class="section2__table__id">Id Perfil</th>
                        <th class="section2__table__nombre">Nombres</th>
                        <th class="section2__table__descripcion">Descripción</th>
                        <th class="section2__table__descripcion">Estado de Registro</th>
                        <th class="section2__table__edit">Editar</th>
                        <th class="section2__table__deshabilitar">Deshabilitar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php 
                            while($resultado = mysqli_fetch_array($rs)){
                        ?>
                        <tr>
                            <td><?php echo $resultado['IdPerfil'] ?></td>
                            <td><?php echo $resultado['Nombre'] ?></td>
                            <td><?php echo $resultado['Descripcion'] ?></td>
                            <td><?php echo $resultado['EstadoRegistro'] ?></td>
                            <td><img src="../../../public/img/btnEditar.png" class="imgBtnActualizar" onclick="location.href='<?php echo $link ?>'"  alt="bntEditar"></td>
                            <td><button class="btnHabDesh"><span class="material-symbols-outlined">radio_button_checked</span></button></td>
                        </tr>
                        <?php }?>
                    </tr>
                </tbody>
            </table>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
        
        </div>
    </main>
</body>
</html>