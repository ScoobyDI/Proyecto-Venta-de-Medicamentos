
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/EditarUsuario.css">
</head>


<body>
    <?php
    include_once '../../model/UsuarioDao.php';

    // Obtener el idUsuario desde la URL
    $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';

    $usuario = null;
    if ($idUsuario) {
        $usuarioDao = new UsuarioDao();
        $resultado = $usuarioDao->filtrarUsuarioPorId($idUsuario);
    
        if (!empty($resultado)) {
            $usuario = $resultado[0];
        }
    }
    ?>

    <header class="header">
        <img src="../../public/img/logo.png">
    </header>
    <aside class="aside" id="aside">
        <div class="aside__head">
            <div class="aside__head__profile">
                <img class="aside__head__profile__Userlogo " src="../../public/img/LogoPrueba.jpg" alt="logoUser">
                <p class="aside__head__nameUser">User</p>
            </div>
            <span class="material-symbols-outlined logMenu" id="menu">menu</span>
        </div>
            
        <ul class="aside__list">
            <a href="perfilAdmin.html">
                <li class="aside__list__options">
                    <span class="material-symbols-outlined iconOption">account_circle</span>
                    <span class="option"> Perfil </span>
                </li>
            </a>
            <li class="aside__list__options__dropdown">
                <div class="aside__list__button ">
                    <span class="material-symbols-outlined iconOption"> manufacturing </span>
                    <span class="option"> Administrar </span>
                    <span class="material-symbols-outlined list__arrow ">keyboard_arrow_down</span>
                </div>
                <ul class="aside__list__show">
                    <a href="AdmUsuarios.php">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption ">groups</span>
                            <span class="option"> Adm. Usuarios </span>
                        </li>
                    </a>
                    <a href="">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption ">medication</span>
                            <span class="option"> Adm. Productos </span>
                        </li>
                    </a>
                    <a href="">
                        <li class="aside__list__inside">
                            <span class="material-symbols-outlined iconOption ">category</span>
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
            <h1 class="section1__title">Actualizar Usuario</h1>
            <form class="section1__form">
                <hr>
                <div class="form__group">
                    <div class="form__description">
                        <legend>Datos Personales</legend>
                    </div>
                    <div class="form__content">
                        <label>ID</label>
                        <input class="control form_id" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['IdUsuario']) : ''; ?>" disabled>
                        <label>Nombres</label>
                        <input class="control form__nombres" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?>">
                        <label>Apellido Paterno</label>
                        <input class="control form__apellPater" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoPaterno']) : ''; ?>">
                        <label>Apellido Materno</label>
                        <input class="control form__apellMater" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoMaterno']) : ''; ?>">
                        <label>DNI</label>
                        <input class="control form__dni" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['DNI']) : ''; ?>">
                    </div>
                </div>
                <hr>
                <div class="form__group">
                    <div class="form__description">
                        <legend>Información del contacto</legend>
                    </div>
                    <div class="form__content">
                        <label>Teléfono</label>
                        <input class="control form__telefono" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['Telefono']) : ''; ?>">
                        <label>Correo</label>
                        <input class="control form__email" type="email" value="<?php echo $usuario ? htmlspecialchars($usuario['CorreoElectronico']) : ''; ?>">
                        <label>Dirección</label>
                        <input class="control form__adress" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['Direccion']) : ''; ?>">
                    </div>
                </div>
                <hr>
                <div class="form__group">
                    <div class="form__description">
                        <legend>Cambiar Contraseña</legend>
                    </div>
                    <div class="form__content">
                    <label>Contraseña</label>
                        <input class="control form__password" type="password" value="<?php echo $usuario ? htmlspecialchars($usuario['Contrasena']) : ''; ?>">
                        <label>Confirmar Contraseña</label>
                        <input class="control form__password" type="password" value="<?php echo $usuario ? htmlspecialchars($usuario['Contrasena']) : ''; ?>">
                    </div>
                </div>
                <hr>
                    <div class="form__content__buttons">
                        <button class="form__button__update" onclick="">Actualizar</button>   
                    </div>
            </form>
            <div class="form__content__buttons">
                <button class="form__button__cancel" onclick="location.href='AdmUsuarios.php'">Cancelar</button>
            </div>
        </div>
    </main>
</body>
</html>