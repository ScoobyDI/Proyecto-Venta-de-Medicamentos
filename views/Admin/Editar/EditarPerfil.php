<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/EditarDisPerCatSubPro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function actualizarPerfil() {
            if (!document.form.reportValidity()) {
                return;
            }
            document.form.action = "../../../controller/PerfilControlador.php";
            document.form.op.value = "3";
            document.form.method = "GET";
            document.form.submit();
        }
        function confirmarCancelar() {
            Swal.fire({
            title: '¿Estás seguro?',
            text: "Se perderán los datos que halla actualizado",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, continuar'
            }).then((result) => {
            if (result.isConfirmed) {
                history.back(); // Redirige a la página anterior si confirma
            }
            });
        }

        function cerrarSesion() {
            window.location.href = "../../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }
    </script>
    <?php
        include_once '../../../model/PerfilDao.php';

        // Obtener el idUsuario desde la URL
        $id_Perfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : '';

        $perfil = null;
        if ($id_Perfil) {
            $PerfilDao = new PerfilDao();
            $resultado = $PerfilDao->filtrarPerfilPorId($id_Perfil);
        
            if (!empty($resultado)) {
                $perfil = $resultado[0];
            }
        }
    ?>

</head>

<body>
    
    <header class="header">
        <img src="../../../public/img/logo.png">
    </header>
    
    <aside class="aside" id="aside">
        <div class="aside__head">
            <div class="aside__head__profile">
                <img class="aside__head__profile__Userlogo" src="../../../public/img/LogoPrueba.jpg" alt="logoUser">
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
                    <a href="../Administrar/AdmUsuarios.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">groups</span>
                            <span class="option"> Adm. Usuarios </span>
                        </li>
                    </a>
                    <a href="../Administrar/AdmPerfiles.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">assignment_ind</span>
                            <span class="option"> Adm. Perfiles </span>
                        </li>
                    </a>
                    <a href="../Administrar/AdmDistritos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">location_city</span>
                            <span class="option"> Adm. Distritos </span>
                        </li>
                    </a>
                    <a href="../Administrar/AdmProductos.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption">medication</span>
                            <span class="option"> Adm. Productos </span>
                        </li>
                    </a>
                    <a href="../Administrar/AdmCategorias.php">
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
            
        </ul>

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>

        <script src="../../../public/js/aside.js"></script>
    </aside>

    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Actualizar Perfil</h1>
            <div class="form__container">
            <form name="form" class="section1__form">
                <input type="hidden" name="op">
                    <div>
                    <label>ID:</label>
                    <input readonly class="control form__" type="text" name="id_Perfil" value="<?php echo $perfil ? htmlspecialchars($perfil['IdPerfil']) : ''; ?>">
                    <label>Nombre del perfil:</label>
                        <input class="control form__" type="text" name="nombre_Perfil" value="<?php echo $perfil ? htmlspecialchars($perfil['Nombre']) : ''; ?>">
                        <label>Descripción:</label>
                        <input class="control form__" type="text" name="descripcion_Perfil" value="<?php echo $perfil ? htmlspecialchars($perfil['Descripcion']) : ''; ?>">
                    </div>
                    <div class="form__content__buttons">
                        <button class="form__button__cancel" type="button" onclick="confirmarCancelar()">Cancelar</button>
                        <button class="form__button__update" onclick="actualizarPerfil()">Actualizar</button>  
                    </div>   
            </form>      
        </div>
    </main>
</body>
</html>