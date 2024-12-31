<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InicioAdmin</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/perfilAdmin.css">

    <?php
        include_once '../../model/UsuarioDao.php';
        session_start();
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
            window.location.href = "../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }
    </script>
</head>

<body>

    <header class="header">
        <img src="../../public/img/logo.png">
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
                    <a href="Administrar/AdmUsuarios.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">groups</span>
                            <span class="option"> Adm. Usuarios </span>
                        </li>
                    </a>
                    <a href="Administrar/AdmPerfiles.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">assignment_ind</span>
                            <span class="option"> Adm. Perfiles </span>
                        </li>
                    </a>
                    <a href="Administrar/AdmDistritos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">location_city</span>
                            <span class="option"> Adm. Distritos </span>
                        </li>
                    </a>
                    <a href="Administrar/AdmProductos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">medication</span>
                            <span class="option"> Adm. Productos </span>
                        </li>
                    </a>
                    <a href="Administrar/AdmCategorias.php">
                        <li class="aside__list__inside">
                        <span class="material-symbols-outlined iconOption">category</span>
                            <span class="option"> Adm. Categorías </span>
                        </li>
                    </a>
                </ul>
            </li>
            <a href="Administrar/AdmInventario.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">inventory</span>
                    <span class="option"> Stock de Productos </span>
                </li>
            </a>
            
        </ul>
        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        <script src="../../public/js/aside.js"></script>
    </aside>
    
    <main class="main">
        <div class="section1">
            <div class="section1__container__title">
                <h1 class="section1__title">Perfil del Usuario</h1>
            </div>
            <div class="section1__container__datos">
                <table class="section1__datos">
                    <tr>
                        <th>Nombres</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido Paterno</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['ApellidoPaterno']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido Materno</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['ApellidoMaterno']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>DNI</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['DNI']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['Telefono']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['Direccion']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Tipo de Usuario</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['NombrePerfil']) : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Correo Registrado</th>
                        <td><?php echo $usuario ? htmlspecialchars($usuario['CorreoElectronico']) : ''; ?></td>
                    </tr>
                </table>
            </div>
            <div class="section1__container__button">
                <!--CAMBIO-->
                <?php $link = "Editar/EditarInfoPropUser.php?idUsuario=" . $usuario['IdUsuario'];?>
                <button onclick="location.href='<?php echo $link ?>'" class="section1__button__actDatos">Actualizar Datos</button>
                <!--FIN DEL CAMBIO-->
            </div>
        </div>
    </main>
</body>
</html>