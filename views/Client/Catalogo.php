<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/Catalogo.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">


    <?php
        include_once '../../model/UsuarioDao.php';
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
            window.location.href = "../../controller/logout.php"; // Cambia la ruta según tu estructura de carpetas
        }

        function showSubcategories(id) {
    document.getElementById(id).style.display = 'block';
}

function hideSubcategories(id) {
    document.getElementById(id).style.display = 'none';
}



    </script>

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

        <a class="Boton" href="perfilAdmin.php">
            <span class="material-symbols-outlined iconOption">account_circle</span>
            <span class="option"> Perfil </span>
        </a>
        <div class="Boton">
        <span class="material-symbols-outlined iconOption">login</span>
            <span class="option"> Inicar Sesión </span>
        </div>
    </div>
    </header>

    <aside class="aside-filter">
    <h3 class="aside_filter_titlo">Buscar por Categoría</h3>
    <!-- Contenedor de categorías visible siempre -->

    <div class="categories-container" id="categoriesContainer">
        <ul class="category-list">
            <li class="category-item" onmouseover="showSubcategories('subcat1')" onmouseout="hideSubcategories('subcat1')">
                Medicinas
                <div class="subcategories-popup" id="subcat1">
                    <ul>
                    <li>Fiebre y Dolor General</li>
                    <li>Gripe, Tos y Congestion</li>
                    <li>Botiquin</li>
                    </ul>
                </div>
            </li>
            <li class="category-item" onmouseover="showSubcategories('subcat2')" onmouseout="hideSubcategories('subcat2')">
                	Dispositivos médicos
                <div class="subcategories-popup" id="subcat2">
                    <ul>
                        <li>Termometro Digital</li>
                        <li>Bisturíes</li>
                        <li>Vacunas</li>
                    </ul>
                </div>
            </li>
            <li class="category-item" onmouseover="showSubcategories('subcat3')" onmouseout="hideSubcategories('subcat3')">
            Cuidado Personal
                <div class="subcategories-popup" id="subcat3">
                    <ul>
                        <li>Exfoliantes </li>
                        <li>Shampoo y acondicionador</li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
    <main class="main">
        <div class="section1">
            <div class="section1__content">
                <div class="section1__filter">
                    <div class="form-buscar-id">
                        <label></label>
                        <input class="control" placeholder="Filtrar" required>
                        <button class="section1__filter__btn" onclick="">
                        <span class="material-symbols-outlined iconOption" id="section1__filter__btn_symbol">search</span>    
                          Buscar</button>
                    </div>
                </div>
            </div>
        </div>

    <div class="section2">
    <div class="product-grid">
     
        <div class="product-card">
            <img src="https://via.placeholder.com/150" alt="Saxenda">
            <h3>Nombre</h3>
            <p>Descripción</p>
            <span class="price">s/</span>
            <button class="add-btn">Agregar</button>
        </div>
        
        <div class="product-card">
            <img src="https://via.placeholder.com/150" alt="Pregabalina">
            <h3>Nombre</h3>
            <p>Descripción</p>
            <span class="price">s/</span>
            <button class="add-btn">Agregar</button>
        </div>

        <div class="product-card">
            <img src="https://via.placeholder.com/150" alt="Epoetina Alfa">
            <h3>Nombre</h3>
            <p>Descripción</p>
            <span class="price">s/</span>
            <button class="add-btn">Agregar</button>
        </div>
    </div>
</div>

    </main>
</body>
</html>