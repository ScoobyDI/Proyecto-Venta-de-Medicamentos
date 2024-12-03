
<?php
    include_once 'util/ConexionBD.php';
    $objc = new ConexionBD();
    $con = $objc->getConexionBD();
    $sql = "SELECT IdProducto, NombreProducto, Precio FROM producto WHERE EstadoRegistro=1";

    $stmt = mysqli_prepare($con, $sql); // Usamos mysqli_prepare para preparar la consulta
    mysqli_stmt_execute($stmt); // Ejecutamos la consulta
    $result = mysqli_stmt_get_result($stmt); // Obtenemos el resultado de la ejecución

    if ($result) {
        // Obtener todos los resultados como un array asociativo
        $resultado = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $resultado = []; // Si no hay resultados, asignamos un array vacío
    }
?>

<?php
    session_start();
    $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];       // Almacena la URL actual
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="public/css/asideAndHeader.css">
    <link rel="stylesheet" href="public/css/Catalogo.css">
</head>
<body>

    <header class="headercatalogo">
        <div class="header_logo">
            <img src="../../../public/img/logo.png">
        </div>
        <div class="header_perfil"> 
            <div class="Boton">
                <span class="material-symbols-outlined iconOption">shopping_cart</span>
                <span class="option"> Mi carrito </span>
            </div>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> Perfil </span>
            </a>
            <a class="Boton"  href="views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option"> Inicar Sesión </span>
            </a>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($resultado as $row){ ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                            $id = $row['IdProducto'];
                            $imagen = "public/img/productos/" .$id. "/principal.jpg";

                            if (!file_exists($imagen)){
                                $imagen = "public/img/imgProductNoFound.jpg";
                            }
                        ?>
                        <img class="imgProductCatalog" src="<?php echo $imagen; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['NombreProducto']; ?></h5>
                            <p class="card-text">S/. <?php echo $row['Precio']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary">Detalles</a>
                                </div>
                                <a href="#" class="btn btn-success">Agregar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>
</html>

