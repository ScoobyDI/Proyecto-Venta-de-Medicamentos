<?php
    require '../../util/config.php';
    require '../../util/ConexionBD.php';
    $db = new ConexionBD();
    $con = $db->conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

    // print_r($_SESSION);

    $lista_carrito = [];

    if($productos != null){
        foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT IdProducto, NombreProducto, Precio, $cantidad AS cantidad FROM producto WHERE IdProducto=? AND EstadoRegistro=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
    else {
        header("Location: ../../index.php");
        exit;
    }

    include_once '../../model/UsuarioDao.php';
        
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Iniciar sesión solo si no está iniciada
    }
    // Verificar si la sesión está iniciada
    if (isset($_SESSION['CorreoElectronico']) && !empty($_SESSION['CorreoElectronico'])) {
        // Si la sesión está iniciada, obtener el correo electrónico y buscar el usuario
        $correo = $_SESSION['CorreoElectronico'];
        $usuario = null;
        $usuarioDao = new usuarioDao();
        $resultado2 = $usuarioDao->filtrarUsuarioPorCorreo($correo);

        if (!empty($resultado2)) {
            $usuario = $resultado2[0];
        }
    } else {
        // Si no hay sesión iniciada, seguir en la misma página (index.php)
        // No es necesario hacer nada, el flujo continúa normalmente en index.php
        $usuario = null;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/pago.css">

    <script>
    function cerrarSesion() {
        // Mostrar alerta de confirmación
        if (confirm("¡Atención! Si cierras sesión, perderás los productos del carrito. ¿Estás seguro de que deseas continuar?")) {
            // Redirigir a la página de cierre de sesión
            window.location.href = "../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        } else {
            // Si el usuario cancela, no hacer nada
            return false;
        }
    }
</script>
</head>
<body>
    <header class="headercatalogo">
        <div class="header_logo">
            <a href="../../index.php"><img src="../../../public/img/logo.png"></a>
        </div>
        <div class="header_perfil"> 
            <a class="Boton"  href="#">
                <span class="material-symbols-outlined iconOption">shopping_cart</span>
                <span class="option"> Mi carrito </span>
            </a>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> <?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?> </span>
            </a>
            <a class="Boton"  href="../../index.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option" onclick="cerrarSesion()">Cerrar sesión</span>
            </a>
        </div>
    </header>
    <main>
        <div class="container">
            <div class = "row">
                <div class="col-6">
                    <h1 class="section1__title">Detalles de Pago</h1>

                    <form action="../../controller/procesarPago.php" method="POST">
                        <div class="form-container1">
                            <div class="form-container-block">
                                <p class="form-subtitle"> Nombre</p>
                                <input type="text" name="Nombres" value="<?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?>" >
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Apellido Paterno</p>
                                <input type="text" name="ApellPat" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoPaterno']) : ''; ?>" >
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Apellido Materno</p>
                                <input type="text" name="ApellMat" value="<?php echo $usuario ? htmlspecialchars($usuario['ApellidoMaterno']) : ''; ?>" >
                            </div>    
                        </div>
                        <div class="form-container2">
                            <p class="form-subtitle"> Direccion </p>
                            <input class="form-input-direction" name="Direccion" type="text" value="<?php echo $usuario ? htmlspecialchars($usuario['Direccion']) : ''; ?>" >
                        </div>
                        <div class="form-container3">
                            <div class="form-container-block">
                                <p class="form-subtitle"> Numero de Tarjeta </p>
                                <input class="form-input-numTarj" name="Tarjeta" type="text" maxlength="16" pattern="\d{16}" title="El número de tarjeta debe tener 16 dígitos" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Fecha de Vencimiento </p>
                                <input class="form-input-fechaVenc" type="text" id="fechaVenc" maxlength="5" pattern="\d{2}/\d{2}" title="El formato debe ser MM/YY" placeholder="MM/YY" required>
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> CVV </p>
                                <input class="form-input-codCvv" type="text" maxlength="3" pattern="\d{3}" title="El CVV debe tener 3 dígitos" placeholder="123" required>
                            </div>
                        </div>

                        
                    
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Productos</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php 
                                    if($lista_carrito == null){
                                        echo '<tr><td colspan="5" class="text-center" ><b>Lista vacia</b></tr>';
                                    } else {
                                    
                                        $total = 0;
                                        foreach($lista_carrito as $producto){
                                        $_id = $producto['IdProducto'];
                                        $nombre = $producto['NombreProducto'];
                                        $precio = $producto['Precio'];
                                        $cantidad = $producto['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total += $subtotal;
                                ?>
                                <tr>
                                    <td> <?php echo $nombre?> </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?> </div>
                                    </td>
                                </tr>

                                    <?php } ?>
                                <tr>
                                    <td colspan="2">
                                        <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                    </td>      
                                </tr>         
                            </tbody>     
                            <?php } ?>  
                        </table>
                    </div>     
                </div>

                    <input type="hidden" name="IdUsuario" value="<?php echo $usuario ? htmlspecialchars($usuario['IdUsuario']) : ''; ?>">
                    <input type="hidden" name="Total" class="prueba" value="<?php echo $total; ?>">
                    <input type="hidden" name="CorreoElectronico" value="<?php echo $usuario ? htmlspecialchars($usuario['CorreoElectronico']) : ''; ?>">
                        
                        <div class="form-container-button">
                            <button class="btnConfirmarPago">
                                Pagar
                            </button>
                        </div>
                </form>
            </div> 
        </div>
    </main>

    <script>
    // Función para formatear la fecha de vencimiento con "/" y dos dígitos para el año
    document.getElementById('fechaVenc').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Elimina cualquier carácter no numérico
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4); // Añade "/" después de los 2 primeros dígitos
        }
        e.target.value = value; // Asigna el valor formateado al campo
    });
</script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    
</body>
</html>