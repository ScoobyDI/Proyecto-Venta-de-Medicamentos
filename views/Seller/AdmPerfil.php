<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/AdmPerfil.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <?php
        include_once '../../model/UsuarioDao.php';
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

        function toggleUserStatus(userId, currentStatus) {
            const newStatus = (currentStatus === 'Habilitado') ? 'deshabilitado' : 'habilitado'; // Cambio de estado
            const xhr = new XMLHttpRequest();
            
            // Corregir la URL concatenando los parámetros
            xhr.open("GET", "../../controller/UsuarioControlador.php?op=4&IdUsuario=" + userId + "&NuevoEstado=" + newStatus, true);
    
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
        <div class="header_logo">
            <img src="../../public/img/logo.png">
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
            
            <a href="ListaClientes.php">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">groups</span>
                    <span class="option"> Adm. Clientes </span>
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
                <?php $link = "EditarPerfil.php?idUsuario=" . $usuario['IdUsuario'];?>
                <button onclick="location.href='<?php echo $link ?>'" class="section1__button__actDatos">Actualizar Datos</button>
                <!--FIN DEL CAMBIO-->
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