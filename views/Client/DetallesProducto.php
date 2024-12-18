<?php
    require '../../util/config.php';
    include_once '../../util/ConexionBD.php';
    $objc = new ConexionBD();
    $con = $objc->getConexionBD();

    $id = isset($_GET['IdProducto']) ? $_GET['IdProducto'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';


    if ($id == '' || $token == '') {
        echo 'Error al procesar la petición';
        exit;
    }else{
        $token_tmp = hash_hmac('sha1',$id, KEY_TOKEN);
        if($token == $token_tmp){

                    // Verificar si el producto está activo
        $sql = "SELECT COUNT(IdProducto) FROM producto WHERE IdProducto = ? AND EstadoRegistro = 1";
        $stmt = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($stmt, 'i', $id); // Vinculamos el parámetro
        mysqli_stmt_execute($stmt); // Ejecutamos la consulta
        mysqli_stmt_bind_result($stmt, $count); // Obtenemos el resultado

        mysqli_stmt_fetch($stmt); // Recuperamos el valor
        mysqli_stmt_close($stmt); // Cerramos el statement

        if ($count > 0) {
            // Si el producto está activo, obtenemos los detalles
            $sql = "SELECT NombreProducto, DescripcionProducto, Precio FROM producto WHERE IdProducto = ? AND EstadoRegistro = 1 LIMIT 1";
            $stmt = mysqli_prepare($con, $sql);

            mysqli_stmt_bind_param($stmt, 'i', $id); // Vinculamos el parámetro
            mysqli_stmt_execute($stmt); // Ejecutamos la consulta
            $result = mysqli_stmt_get_result($stmt); // Obtenemos el resultado

            if ($row = mysqli_fetch_assoc($result)) {
                $nombre = $row['NombreProducto'];
                $descripcion = $row['DescripcionProducto'];
                $precio = $row['Precio'];
                $dir_images = '../../public/img/productos/' . $id . '/';

                $rutaImg = $dir_images . 'principal.jpg';
                
                if (!file_exists($rutaImg)){
                    $rutaImg = '../../public/img/imgProductNoFound.jpg';
                }

                $imagenes = array();
                    if(file_exists($dir_images))
                    {
                    $dir = dir($dir_images);

                    while (($archivo = $dir->read()) != false){
                        if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                            $imagenes[] = $dir_images . $archivo;
                        }
                    }
                    $dir->close();
                }
            }

            mysqli_stmt_close($stmt); // Cerramos el statement
        } else {
            $nombre = $descripcion = $precio = null; // No hay producto activo
        }

        }else{
            echo 'Error al procesar la petición';
            exit;
        }
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
    <link rel="stylesheet" href="../../public/css/DetallesProducto.css">

    <script>
        function cerrarSesion() {
            window.location.href = "../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }
    </script>
</head>
<body>

    <header class="headercatalogo">
        <div class="header_logo">
            <a href="../../index.php"> <img src="../../../public/img/logo.png"></a>
        </div>
        <div class="header_perfil"> 
            <a class="Boton"  href="checkout.php">
                <span class="material-symbols-outlined iconOption">shopping_cart</span>
                <span class="option"> Mi carrito </span>
                <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> 
                    <?php 
                        // Verifica si el usuario está logueado
                        if ($usuario) {
                            echo htmlspecialchars($usuario['Nombres']); // Muestra el nombre del usuario
                        } else {
                            echo 'Cuenta'; // Muestra "Cuenta" si no hay sesión iniciada
                        }
                    ?> 
                </span>
            </a>
            <?php if ($usuario): ?>
            <!-- Si el usuario está logueado, muestra "Cerrar sesión" -->
            <a class="Boton" href="../../index.php">
                <span class="material-symbols-outlined iconOption">logout</span>
                <span class="option" onclick="cerrarSesion()">Cerrar sesión</span>
            </a>
            <?php else: ?>
            <!-- Si no está logueado, muestra "Iniciar sesión" -->
            <a class="Boton" href="../../views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option">Iniciar sesión</span>
            </a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="ContainerImg">

                <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="1000">
                            <img class="imgDescripProduct" src="<?php echo $rutaImg; ?>">
                        </div>
                        <?php foreach($imagenes as $img){ ?>
                            <div class="carousel-item">
                                <img class="imgDescripProduct" src="<?php echo $img; ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="ContainerDescription">
                <h2 class="nombreProducto"><?php echo $nombre; ?></h2>
                <h2 class="precioProducto"><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>
                <div class="ContainerButtons">
                    <button class="btnComprar btn btn-primary" type="button" onclick="comprarAhora(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Comprar ahora</button>
                    <button class="btnAgregarCarrito btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>,'<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token){
            let url = '../../controller/CarritoCompraControlador.php'
            let formData = new FormData()
            formData.append('id',id)
            formData.append('token',token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }

        function comprarAhora(id, token) {
        // Reutiliza la lógica de addProducto
        let url = '../../controller/CarritoCompraControlador.php';
        let formData = new FormData();
        formData.append('id', id);
        formData.append('token', token);

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                // Actualiza el contador del carrito
                let elemento = document.getElementById("num_cart");
                elemento.innerHTML = data.numero;

                // Redirige a la página de detalles de compra
                window.location.href = "checkout.php";
            } else {
                alert("Error al agregar el producto al carrito.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
    </script>
</body>
</html>