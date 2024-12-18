
<?php
    // if(!isset($_SESSION["pay"])){
    //   //redirigir a otra vista  
    // }
    require '../../util/config.php';
    require '../../util/ConexionBD.php';

    include_once '../../model/UsuarioDao.php';
    $correo = $_SESSION['CorreoElectronico'];
    $usuario = null;
    $usuarioDao = new usuarioDao();
    $resultado = $usuarioDao->filtrarUsuarioPorCorreo($correo);

    if (!empty($resultado)) {
        $usuario = $resultado[0];
    }


    $db = new ConexionBD();
    $con = $db->conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
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
    <title>Evaluación de Satisfacción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../public/css/asideAndHeader.css">
    <link rel="stylesheet" href="../../public/css/EvaluacionSatisfaccion.css">

</head>
<body>

    <header class="headercatalogo">
        <div class="header_logo">
            <a href="../../index.php"><img src="../../../public/img/logo.png"></a>
        </div>
        <div class="header_perfil"> 
            <a class="Boton"  href="#">
                <span class="material-symbols-outlined iconOption"></span>
                <span class="option"> Mi carrito </span>
                <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
            </a>
            <a class="Boton" href="">
                <span class="material-symbols-outlined iconOption">account_circle</span>
                <span class="option"> Perfil </span>
            </a>
            <?php if(!isset($usuario["IdUsuario"])){?>
            <a class="Boton"  href="../../views/Auth/login.php">
                <span class="material-symbols-outlined iconOption">login</span>
                <span class="option"> Inicar Sesión </span>
            </a>
            <?php }?>
        </div>
    </header>

    <main>
        <div class="container"> 
                <div>
                    <h1 class="section1__title">Evaluación de Satisfacción</h1>
                    <div class="table-responsive">
                    <p class="fs-4 custom-p">Podría contestar el siguiente formulario para conocer su experiencia en la compra de productos por favor.</p>    
                    <form class="formulario" id="formSatisfaction" action="../../controller/EvaluacionSatisfaccionCont.php" name="farmacia_online" method="post">
                        <div>
                            <input readonly type="number" value="<?php echo $usuario["IdUsuario"] ?>" id="inputIdUsuario" name="IdUsuario" class="form-control visually-hidden" aria-describedby="idUsuarioHelpBlock" >
                        <div>    
                        <div class="mb-4 mt-4">
                            <h4>¿Qué tan fácil fue navegar en nuestro sitio web para encontrar los productos que buscabas?</h4>
                            <div class="d-flex">
                                <div class="flex-fill text-center">
                                     <i class="bi bi-emoji-angry-fill iconos icon1" style></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-frown-fill iconos icon2"></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-neutral-fill iconos icon3"></i>    
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-smile-fill iconos icon4"></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-laughing-fill iconos icon5"></i>
                                </div>
                            </div>  
                            <div class="my-1">
                                <div class="d-flex">
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion1" name="calificacion1" value="1">
                                        <label class="form-check-label lab" for="opcion1">Nada</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion2" name="calificacion1" value="2">
                                        <label class="form-check-label lab" for="opcion2">Poco</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion3" name="calificacion1" value="3">
                                        <label class="form-check-label lab" for="opcion3">Medianamente</label>
                                    </div> 
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion4" name="calificacion1" value="4">
                                        <label class="form-check-label lab" for="opcion4">Mucho</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion5" name="calificacion1" value="5">
                                        <label class="form-check-label lab" for="opcion5">Totalmente</label>
                                    </div>
                                </div>
                                <div class="alert alert-danger mt-1 error d-none" id="errorCalificacion1" role="alert">
                                    Este campo es obligatorio!
                                </div>
                            </div>  
                        </div>
                        <div class="mb-4 mt-4">
                            <h4>¿Qué tan seguro(a) te sentiste al realizar tu compra en nuestra botica online?</h4>
                            <div class="d-flex">
                                <div class="flex-fill text-center">
                                     <i class="bi bi-emoji-angry-fill iconos icon1" style></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-frown-fill iconos icon2"></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-neutral-fill iconos icon3"></i>    
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-smile-fill iconos icon4"></i>
                                </div>
                                <div class="flex-fill text-center">
                                    <i class="bi bi-emoji-laughing-fill iconos icon5"></i>
                                </div>
                            </div>
                            <div class="my-1">
                                <div class="d-flex">
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion1cal2" name="calificacion2" value="1">
                                        <label class="form-check-label lab" for="opcion1cal2">Nada</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion2cal2" name="calificacion2" value="2">
                                        <label class="form-check-label lab" for="opcion2cal2">Poco</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion3cal2" name="calificacion2" value="3">
                                        <label class="form-check-label lab" for="opcion3cal2">Medianamente</label>
                                    </div> 
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion4cal2" name="calificacion2" value="4">
                                        <label class="form-check-label lab" for="opcion4cal2">Mucho</label>
                                    </div>
                                    <div class="form-check form-check-inline flex-fill d-flex justify-content-center">
                                        <input class="form-check-input" type="radio" id="opcion5cal2" name="calificacion2" value="5">
                                        <label class="form-check-label lab" for="opcion5cal2">Totalmente</label>
                                    </div>
                                </div>
                                <div class="alert alert-danger mt-1 d-none error" id="errorCalificacion2" role="alert">
                                    Este campo es obligatorio!
                                </div>
                            </div>    
                        </div>
                        <div class="mb-4 mt-3">
                            <label for="sugerencia" class="form-label"><h4>¿Tiene alguna sugerencia para mejorar la página?</h4></label>
                            <textarea class="form-control custom-textarea" id="sugerencia" rows="2"   name="descripcion" placeholder="Escribala aquí"></textarea>
                        </div>
                        <div class="mb-2 mt-4 flex-fill text-center">
                        <button type="button" class="btn btn-danger botones me-3" id="salir">Prefiero no contestar</button>  
                        <button type="submit" class="btn btn-success botones ms-3" name="registro">Enviar</button>
                        </div>
                    </form>
                </div>                             
        </div>
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript">

        document.getElementById("formSatisfaction").addEventListener('submit', validarFormulario)
        document.getElementById("salir").addEventListener('click', salirFormulario)        
        
        // Función para validar los campos del formulario
        function salirFormulario(e){
            e.preventDefault();
            <?php $_SESSION["pay"]=True;
            ?>
            window.location.href="http://localhost:3000/"
        }

        function validarFormulario(e) {
            e.preventDefault();
            
            const idUser = document.getElementById("inputIdUsuario").value;
            const calificacion1 = valueReturn("calificacion1")
            const calificacion2 = valueReturn("calificacion2")            

            if (calificacion1 == null ) {
                document.getElementById("errorCalificacion1").classList.remove('d-none') 
            }else{
                document.getElementById("errorCalificacion1").classList.add('d-none')
            }
            
            if (calificacion2 == null ) {
                document.getElementById("errorCalificacion2").classList.remove('d-none')  
            }else{
                document.getElementById("errorCalificacion2").classList.add('d-none')
            }

            if(idUser == "" || calificacion1 == null || calificacion2 == null ){
                return;
            }else{

                this.submit()
            }
        }

        function valueReturn(selector){
            const calificacion = document.getElementsByName(selector);
            let cal1 = null
            for(let i = 0; i < calificacion.length; i++){
                if(calificacion[i].checked)
                    cal1 = calificacion[i].value
            }
            return cal1
        }
    </script>
</body>
</html>

