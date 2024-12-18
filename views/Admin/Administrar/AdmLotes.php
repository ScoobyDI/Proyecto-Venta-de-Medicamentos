<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Lotes</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link rel="stylesheet" href="../../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../../public/css/AdmLotes.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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

        function abrir(){
            document.getElementById("vent_agregar").style.display="block";
        }

        function cerrar_ventana_agregar(){
            document.getElementById("vent_agregar").style.display = "none";
            location.reload();  // Recarga la página después de cerrar la ventana
        }

        function confirmarCancelar() {
            Swal.fire({
            title: '¿Estás seguro?',
            text: "Se perderán los datos ingresados",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, continuar'
            }).then((result) => {
            if (result.isConfirmed) {
                cerrar_ventana_agregar(); // Cerar la ventana
            }
            });
        }

        function registrarLote() {
            document.form.action = "../../../controller/InventarioControlador.php"; // La ruta a tu controlador PHP
            document.form.op.value = "1";  // Acción para agregar lote
            document.form.method = "GET";
            document.form.submit();
        }

        function eliminarLote(idLote) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "El lote será eliminado permanentemente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir a la URL del controlador con los parámetros necesarios
                    window.location.href = "../../../controller/InventarioControlador.php?op=2&IdLote=" + idLote;
                }
            });
        }
    </script>



</head>

<body>

    <div class='ventana_agregar_lote' id='vent_agregar'>
        <div id="cerrar">
            <a href="javascript:cerrar_ventana_agregar()" class="cerrar_ventana_btn">
            <span class="material-symbols-outlined">close</span>
            </a>
        </div>
        <h1 class="ventana__title">Agregar Lote</h1>
        <div class="ventana__container">
        <form name="form" class="ventana_formulario">
                    <input type="hidden" name="op">
                        <div>
                            <label>Stock del Lote:</label>
                            <input class="input_ventana" type="text" name="StockLote" required>
                        </div>
                        <div>
                            <label>Fecha de Vencimiento:</label>
                            <input class="input_ventana" type="date" id="fecha" name="FechaVencimiento" required>
                            <script>
                                const fechaInput = document.getElementById('fecha');
                                const hoy = new Date();

                                // Formatear la fecha como YYYY-MM-DD
                                const formatoFecha = hoy.toISOString().split('T')[0];

                                // Establecer el mínimo en el input
                                fechaInput.min = formatoFecha;
                            </script>
                        </div>
                        <div>
                            <label>Producto:</label>
                            <select class="input_ventana" name="IdProducto" required>
                                <option value="" disabled selected>Seleccionar Producto</option>
                                <?php
                                    // Conexión a la base de datos
                                    $objc = new ConexionBD();
                                    $con = $objc->getConexionBD();

                                    // Consulta para obtener los productos
                                    $sql = "SELECT IdProducto, NombreProducto FROM producto";
                                    $rs1 = mysqli_query($con, $sql);  // Corregir esta línea

                                    // Verificamos si hay productos disponibles
                                    $productos = [];
                                    while ($producto = mysqli_fetch_assoc($rs1)) {
                                        $productos[] = $producto;
                                    }
                                    // Verificar si hay productos y recorrerlos
                                    if (!empty($productos)) {
                                        foreach ($productos as $producto) {
                                            // El 'value' es el ID del producto, que es lo que se enviará
                                            // El texto que se muestra es el 'NombreProducto'
                                            echo "<option value='" . htmlspecialchars($producto['IdProducto']) . "'>" . htmlspecialchars($producto['NombreProducto']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No hay productos disponibles</option>";
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="form__content__buttons">
                        <button class="form__button__cancel" type="button" onclick="confirmarCancelar()">Cancelar</button>
                            <button class="form__button__anadir" onclick="registrarLote()">Añadir Lote</button>
                        </div>
        </form>                
        </div>
    </div>     

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
            <h1 class="section1__title">Lotes</h1>
            <div class="form-buscar-id">
                        <label>Buscar:</label>
                        <input class="control" id="searchNombreProducto" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="buscarPorNombre()">Buscar</button>
                    </div>
            <div class="section1__content_lote">
                 <div class="section1__options_lote">
                    <button class="section1__addProduct__btn" onclick="abrir()">Agregar Lote</button>
                </div>
            </div>
        </div>

        <div class="section2">
            <table id="LotesTable" class="section2__table">
                       <?php 
                                // Conexión a la base de datos y obtención de los productos
                                $objc = new ConexionBD();
                                $con = $objc->getConexionBD();
                                $sql = "SELECT i.IdLote,i.Cantidad,i.FechaCaducidad,p.NombreProducto FROM inventario i
                                        INNER JOIN producto p ON i.IdProducto = p.IdProducto;";
                                $rs = mysqli_query($con, $sql);
                        ?>
                <thead>
                    <tr>
                        <th class="seccion2_th_basic">Producto</th>
                        <th class="seccion2_th_basic">Stock del Lote</th>        
                        <th class="seccion2_th_basic">Fecha de Vencimiento</th>
                        <th class="seccion2_th_basic">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($lote = mysqli_fetch_assoc($rs)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars(string: $lote['NombreProducto']); ?></td>
                            <td><?php echo htmlspecialchars(string: $lote['Cantidad']); ?></td>                  
                            <td><?php echo htmlspecialchars($lote['FechaCaducidad']); ?></td>
                    
                            <td>
                                <button onclick="eliminarLote(<?php echo $lote['IdLote']; ?>)" class="btn-delete">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>   

    </main>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<script>

       $(document).ready(function() {
            $('#LotesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
                    "emptyTable": "No se encontraron registros coincidentes",
                    "zeroRecords": "No se encontraron registros coincidentes"
                },
                "dom": 'rtip' // Eliminar el campo de búsqueda global
            });
        });

        function buscarPorNombre() {
            event.preventDefault();
            var nombre = $('#searchNombreProducto').val();
            var table = $('#LotesTable').DataTable();
            table.columns(0).search(nombre).draw(); // BUSCA LA PRIMERA COLUMNA Q ES DE NOMBRE }:V
        }


</script>
</html>