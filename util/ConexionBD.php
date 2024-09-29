<?php
                                                              
class ConexionBD                                                      // Declaración de la clase Conexion_BD
{
    // Declaración de constantes para la conexión a la base de datos
    const servidor = "localhost";                                     // Servidor de la base de datos
    const usuario = "root";                                           // Usuario de la base de datos
    const password = "";                                              // Contraseña del usuario de la base de datos
    const bd = "farmacia_online";                                                 // Nombre de la base de datos

    // Declaración de una propiedad privada para la conexión
    private $cn = null;

    // Método para obtener una conexión a la base de datos
    public function getConexionBD()
    {
        try                                                         // Intentamos establecer una conexión a la base de datos utilizando las constantes definidas
        {  
            $this->cn = mysqli_connect(self::servidor, self::usuario, self::password, self::bd);    //pasa informacion para conectarse a la base de datos
        } 
        catch (Exception $e)                                        // En caso de error en la conexión, no se toma ninguna acción en este ejemplo
        {
        
        }
        return $this->cn;                                           // Devolvemos la conexión (puede ser nula si no se pudo conectar)
    }
}
?>