
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
        header("Location: index.php");
        exit;
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
                <span class="option"> Perfil <?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?> </span>
            </a>
            <a class="Boton"  href="../../views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option"> Inicar Sesión </span>
            </a>
        </div>
    </header>

    <main>
        <div class="container">
            <div class = "row">
                <div class="col-6">
                    <h1 class="section1__title">Detalles de Pago</h1>

                    <form action="">
                        <div class="form-container1">
                            <div class="form-container-block">
                                <p class="form-subtitle"> Nombre</p>
                                <input type="text">
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Apellido Paterno</p>
                                <input type="text">
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Apellido Materno</p>
                                <input type="text">
                            </div>    
                        </div>
                        <div class="form-container2">
                            <p class="form-subtitle"> Direccion </p>
                            <input class="form-input-direction" type="text">
                        </div>
                        <div class="form-container3">
                            <div class="form-container-block">
                                <p class="form-subtitle"> Numero de Tarjeta </p>
                                <input class="form-input-numTarj" type="text">
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> Fecha de Vencimiento </p>
                                <input class="form-input-fechaVenc" type="text">
                            </div>
                            <div class="form-container-block">
                                <p class="form-subtitle"> CVV </p>
                                <input class="form-input-codCvv" type="text">
                            </div>
                        </div>
                    </form>
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
            </div> 
        </div>
    </main>

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    
</body>
</html>

