<?php
    require 'util/config.php';
    include_once 'util/ConexionBD.php';

    $db2 = new ConexionBD();
    $con2 = $db2->conectar();

    $sqlCategorias = $con2->prepare("
        SELECT 
            c.IdCategoria, 
            c.NombreCategoria, 
            s.IdSubcategoria, 
            s.NombreSubcategoria
        FROM 
            categoria c
        LEFT JOIN 
            subcategoria s 
        ON 
            c.IdCategoria = s.IdCategoria
        WHERE 
            c.EstadoCategoria = 1 AND s.EstadoSubCategoria = 1
    ");
    $sqlCategorias->execute();
    $categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);

    $categoriasAgrupadas = [];
    foreach ($categorias as $row) {
        $categoriasAgrupadas[$row['IdCategoria']]['NombreCategoria'] = $row['NombreCategoria'];
        $categoriasAgrupadas[$row['IdCategoria']]['Subcategorias'][] = [
            'IdSubcategoria' => $row['IdSubcategoria'],
            'NombreSubcategoria' => $row['NombreSubcategoria']
        ];
    }

    $idCategoria = $_GET['cat'] ?? null;
    $idSubcategoria = $_GET['subcat'] ?? null;

    if ($idSubcategoria !== null) {
        $comando = $con2->prepare("SELECT IdProducto, NombreProducto, Precio 
                                FROM producto 
                                WHERE EstadoRegistro = 1 AND IdSubcategoria = ?");
        $comando->execute([$idSubcategoria]);
    } elseif ($idCategoria !== null) {
        $comando = $con2->prepare("SELECT IdProducto, NombreProducto, Precio 
                                FROM producto 
                                WHERE EstadoRegistro = 1 AND id_categoria = ?");
        $comando->execute([$idCategoria]);
    } else {
        $comando = $con2->prepare("SELECT IdProducto, NombreProducto, Precio 
                                FROM producto 
                                WHERE EstadoRegistro = 1");
        $comando->execute();
    }

    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

    include_once 'model/UsuarioDao.php';
        
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
    <link rel="stylesheet" href="public/css/asideAndHeader.css">
    <link rel="stylesheet" href="public/css/Catalogo.css">
</head>

<body>
    <header class="headercatalogo">
        <div class="header_logo">
            <img src="../../../public/img/logo.png">
        </div>
        <div class="header_perfil"> 
            <a class="Boton"  href="views/Client/checkout.php">
                <span class="material-symbols-outlined iconOption">shopping_cart</span>
                <span class="option"> Mi carrito </span>
                <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> <?php echo $usuario ? htmlspecialchars($usuario['Nombres']) : ''; ?> </span>
            </a>
            <a class="Boton"  href="views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option"> Inicar Sesión </span>
            </a>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Categorías
                        </div>
                        <div class="list-group">
                                <a href="index.php" class="list-group-item list-group-item-action ">
                                    Todo
                                </a>
                            <?php foreach ($categoriasAgrupadas as $idCategoria => $categoria) { ?>
                                <!-- Las Categoría -->
                                <a href="#subcat-<?php echo $idCategoria; ?>" 
                                    class="list-group-item list-group-item-action " 
                                    data-bs-toggle="collapse" 
                                    aria-expanded="false">
                                    <?php echo $categoria['NombreCategoria']; ?>
                                </a>

                                <!-- Las Subcategorías -->
                                <div id="subcat-<?php echo $idCategoria; ?>" class="collapse ps-3">
                                    <?php foreach ($categoria['Subcategorias'] as $subcat) { ?>
                                        <a href="index.php?subcat=<?php echo $subcat['IdSubcategoria']; ?>" 
                                        class="list-group-item list-group-item-action">
                                            <?php echo $subcat['NombreSubcategoria']; ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>   
                </div>
                <div class="col-9">
                    <div class="row row-cols-1 roe-cols-sm-2 row-cols-md-3 g-4">
                        <?php foreach($resultado as $row){ ?>
                            <div class="col mb-2">
                                <div class="card shadow-sm h-100">
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
                                                <a href="views/Client/DetallesProducto.php?IdProducto=<?php echo $row['IdProducto']; ?>&token=<?php echo hash_hmac('sha1', $row['IdProducto'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                            </div>
                                            <button class="btnAgregarCarrito btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $row['IdProducto']; ?>,'<?php echo hash_hmac('sha1', $row['IdProducto'], KEY_TOKEN); ?>')">Agregar al carrito</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
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
    </script>
</body>
</html>