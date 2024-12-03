<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/EditarDisPerCatSubPro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        include_once '../../../model/UsuarioDao.php';
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
        function actualizarProducto() {
            if (!document.form.reportValidity()) {
                return;
            }
            document.form.action = "../../../controller/ProductoControlador.php";
            document.form.op.value = "3";
            document.form.method = "GET";
            document.form.submit();
        }

        function confirmarCancelar() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se perderán los datos que haya actualizado",
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
        include_once '../../../util/ConexionBD.php';

        // Obtener el idProducto desde la URL
        $idProducto = isset($_GET['idProducto']) ? $_GET['idProducto'] : '';

        $producto = null;
        if ($idProducto) {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
            $sql = "SELECT * FROM producto WHERE IdProducto = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idProducto);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_assoc();
            $producto = $resultado;
            $stmt->close();
        }

        // Obtener todas las subcategorías para el select
        $subcategorias = [];
        $sqlSubcategorias = "SELECT IdSubcategoria, NombreSubcategoria FROM subcategoria";
        $resultSubcategorias = $con->query($sqlSubcategorias);
        while ($row = $resultSubcategorias->fetch_assoc()) {
            $subcategorias[] = $row;
        }
        $con->close();
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

        <div class="aside__down">
            <button class="aside__btnLogOut" onclick="cerrarSesion()">Cerrar Sesión</button>
        </div>
        
        <script src="../../../public/js/aside.js"></script>
    </aside>

    
    <main class="main">
        <div class="section1">
            <h1 class="section1__title">Actualizar Producto</h1>
            <div class="form__container">
                <form name="form" class="section1__form_producto">
                    <input type="hidden" name="op">
                    <div>
                        <label>ID:</label>
                        <input readonly class="control form_id" type="text" name="IdProducto" value="<?php echo $producto ? htmlspecialchars($producto['IdProducto']) : ''; ?>" required>
                        
                        <label>Nombre del producto:</label>
                        <input class="control form__" type="text" name="NombreProducto" value="<?php echo $producto ? htmlspecialchars($producto['NombreProducto']) : ''; ?>" required>
                        
                        <label>Descripción:</label>
                        <input class="control form__" type="text" name="DescripcionProducto" value="<?php echo $producto ? htmlspecialchars($producto['DescripcionProducto']) : ''; ?>" required>

                        <label>Subcategoría:</label>
                        <select class="control form__" name="IdSubcategoria" required>
                            <option value="">Seleccione una subcategoría</option>
                            <?php foreach ($subcategorias as $subcategoria) { ?>
                                <option value="<?php echo $subcategoria['IdSubcategoria']; ?>" <?php echo ($producto && $producto['IdSubcategoria'] == $subcategoria['IdSubcategoria']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($subcategoria['NombreSubcategoria']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        
                        <label>Precio:</label>
                        <input class="control form__" type="text" name="Precio" value="<?php echo $producto ? htmlspecialchars($producto['Precio']) : ''; ?>" required>
                        
                        <label>Fecha de Vencimiento:</label>
                        <input class="control form__" type="date" name="FechaVencimiento" value="<?php echo $producto ? htmlspecialchars($producto['FechaVencimiento']) : ''; ?>" required>
                    </div>
                    <div class="form__content__buttons">
                        <button class="form__button__cancel" type="button" onclick="confirmarCancelar()">Cancelar</button>
                        <button class="form__button__update" onclick="actualizarProducto()">Actualizar</button>  
                    </div>   
                </form>      
            </div>
        </div>
    </main>
</body>
</html>