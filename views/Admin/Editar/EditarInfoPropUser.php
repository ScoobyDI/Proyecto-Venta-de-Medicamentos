
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/EditarInfoPropUser.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        function actualizarDatosPersonales() {
            if (!document.form.reportValidity()) {
                return;
            }
            if (document.form.Contrasena.value != document.form.Contrasena2.value) {
                alert("Las contraseñas no son iguales");
                return;
            }

            document.form.action = "../../../controller/UsuarioControlador.php";
            document.form.op.value = "5";
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
        include_once '../../../model/UsuarioDao.php';

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

    <?php
        include_once '../../../util/ConexionBD.php';
        $objc = new ConexionBD();
        $con = $objc->getConexionBD();
        $sql = "SELECT * FROM distrito";
        $rs = mysqli_query($con,$sql);
    ?>

    <?php
        include_once '../../../util/ConexionBD.php';
        $objc = new ConexionBD();
        $con = $objc->getConexionBD();
        $sql2 = "SELECT * FROM perfiles";
        $rs2 = mysqli_query($con,$sql2);
    ?>
    
</head>

<body>

    <header class="header">
        <img src="../../../public/img/logo.png">
    </header>

    <aside class="aside" id="aside">
        <div class="aside__head">
            <div class="aside__head__profile">
                <img class="aside__head__profile__Userlogo " src="../../../public/img/LogoPrueba.jpg" alt="logoUser">
                <p class="aside__head__nameUser">User</p>
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
        
        <script src="../../../public/js/aside.js"></script>

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        <script src="../../public/js/aside.js"></script>
    </aside>

    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Actualizar Datos de Usuario</h1>
            <div class="form__container">
                <form name="form" class="section1__form">
                    <input type="hidden" name="op">
                    <div>
                        <label>Nombres</label>
                            <input class="control form__nombres" type="text" name="Nombres" value="<?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?>">
                        <label>Apellido Paterno</label>
                            <input class="control form__apellPater" type="text" name="ApellidoPaterno" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoPaterno']) : ''; ?>">
                        <label>Apellido Materno</label>
                            <input class="control form__apellMater" type="text" name="ApellidoMaterno" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoMaterno']) : ''; ?>">
                        <label>DNI</label>
                            <input class="control form__dni" type="text" name="DNI" value="<?php echo $usuario ? htmlspecialchars($usuario['DNI']) : ''; ?>">
                        <label>Fecha Nacimiento</label>
                            <input class="control form__fechaNacim" type="date" name="FechaNacimiento" value="<?php echo $usuario ? htmlspecialchars($usuario['FechaNacimiento']) : ''; ?>">
                        
                        <label>Teléfono</label>
                            <input class="control form__telefono" type="text" name="Telefono" value="<?php echo $usuario ? htmlspecialchars($usuario['Telefono']) : ''; ?>">
                        <label>Correo</label>
                            <input class="control form__email" type="email" name="Correo" value="<?php echo $usuario ? htmlspecialchars($usuario['CorreoElectronico']) : ''; ?>">
                        <label>Distrito</label>
                            <select class="control form__district" name="Distrito" required>
                                <option value="" selected>Seleccione un distrito</option>
                                <?php 
                                    while($row = mysqli_fetch_array($rs))
                                    {
                                    $id = $row['IdDistrito'];
                                    $nombre = $row['NombreDistrito'];
                    
                                    // Verificar si este es el distrito seleccionado del usuario
                                    if ($usuario['IdDistrito'] == $id) {
                                    echo "<option value='$id' selected>$nombre</option>"; // Marcar como seleccionado
                                    } else {
                                    echo "<option value='$id'>$nombre</option>"; // No seleccionado
                                    }
                                    }
                                ?>
                            </select>  
                        <label>Dirección</label>
                            <input class="control form__adress" type="text" name="Direccion" value="<?php echo $usuario ? htmlspecialchars($usuario['Direccion']) : ''; ?>" required>

                        <label>Contraseña</label>
                            <input class="control form__password" type="password" name="Contrasena" value="<?php echo $usuario ? htmlspecialchars($usuario['Contrasena']) : ''; ?>">
                        
                        <label>Confirmar Contraseña</label>
                            <input class="control form__password" type="password" name="Contrasena2" value="<?php echo $usuario ? htmlspecialchars($usuario['Contrasena']) : ''; ?>">
                    </div>

                    <div class="form__content__buttons">
                        <button class="form__button__cancel" type="button" onclick="confirmarCancelar()">Cancelar</button>
                        <button class="form__button__update" onclick="actualizarDatosPersonales()">Actualizar</button>  
                    </div>  
                </form>
            </div>
        </div>
    </main>
</body>
</html>