
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
    <link rel="stylesheet" href="../../public/css/Carrito.css">
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
                <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> Perfil </span>
            </a>
            <a class="Boton"  href="../../views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option"> Inicar Sesión </span>
            </a>
        </div>
    </header>

    <main>
        
        <div class="container">
            <h1 class="section1__title">Carrito</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
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
                            <td> <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> </td>
                            <td>
                                <input type="number" min="1"  max="10" class="form-control input-table" 
                                value="<?php echo $cantidad?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizarCantidad(this.value,<?php echo $_id?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?> </div>
                            </td>
                            <td>
                                <a id="eliminar" class=" btnEliminarProduct btn btn-warning btn-sm"  data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" 
                                data-bs-target="#eliminaModal"><span class="material-symbols-outlined">delete_forever</span>Eliminar</a>
                            </td>
                        </tr>

                            <?php } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                            </td>      
                        </tr>
                                      
                    </tbody>     
                    <?php } ?>  

                </table>
            </div>  

            <?php if($lista_carrito != null){ ?>
                <div class="row">
                    <div class="pay">
                        <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn-elimina" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event){
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })
            

        function actualizarCantidad(cantidad, id){
            let url = '../../controller/actualizarCarrito.php'
            let formData = new FormData()
            formData.append('action','agregar')
            formData.append('id',id)
            formData.append('cantidad',cantidad)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){

                    let divsubtotal = document.getElementById('subtotal_'+ id) 
                    divsubtotal.innerHTML = data.sub 

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')
                    console.log('Subtotales:', list);
                    
                    for (let i = 0; i < list.length; i++) {
                        // Eliminar "S/" y las comas
                        total += parseFloat(list[i].innerHTML.replace(/S\/|[,]/g, ''));
                    }

                    // Formatear el total a moneda con dos decimales
                    total = new Intl.NumberFormat('es-PE', { // 'es-PE' es el código de idioma para Perú
                        style: 'currency',
                        currency: 'PEN', // El código de moneda para soles peruanos
                        minimumFractionDigits: 2
                    }).format(total);

                    // Mostrar el total en el elemento con id "total"
                    document.getElementById('total').innerHTML =  total;
                    
                }
            })
        }

        function eliminar(){

            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = '../../controller/actualizarCarrito.php'
            let formData = new FormData()
            formData.append('action','eliminar')
            formData.append('id',id)


            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    location.reload()
                    
                }
            })
        }

        
    </script>
    
</body>
</html>

