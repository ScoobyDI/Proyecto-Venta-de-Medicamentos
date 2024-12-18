<?php
    require '../util/config.php';
    require '../util/ConexionBD.php';
    
    $url = "http://localhost:3000/";

    if(isset($_POST["IdUsuario"]) && isset($_POST['calificacion1']) && isset($_POST['calificacion2'])){
        $IdUsuario=$_POST['IdUsuario'];  
        $calificacion1=$_POST['calificacion1'];      
        $calificacion2=$_POST['calificacion2'];
        $descripcion=$_POST['descripcion']; 
        
        $db = new ConexionBD();
        $con = $db->conectar();
        $insertarDatos = "INSERT INTO satisfaccion_cliente (IdUsuario, calificacion1, calificacion2, descripcion) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($insertarDatos);
        $ejecutarInsertar = $stmt->execute([$IdUsuario, $calificacion1, $calificacion2, $descripcion]); 
          
        if ($ejecutarInsertar) {
            $_SESSION["pay"] = True;
            header("Location:".$url."");
        } else {
            header("Location: ".$url."views/Client/EvaluacionSatisfaccion.php");
        }    
    }
          