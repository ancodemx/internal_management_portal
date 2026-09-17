<?php

namespace app\Core;

class ConexionBD{

    private static $instancia;

	private $BD = DB_NAME;
	private $usuario = DB_USER;
	private $pass = DB_PASSWORD;
	private $servidor = DB_HOST;
    private $puerto = DB_PORT;
	private $conectarBD;


	public function __construct() 
    {
        //incializamos conexion en el constractor
        $this->conectarBD = mysqli_connect($this->servidor, $this->usuario, $this->pass, $this->BD, $this->puerto); 
		$this->conectarBD->set_charset("utf8");

        // Imprimir información de conexión (opcional)
        //echo "Conexión exitosa: " . mysqli_get_host_info($this->conectarBD);
	}


    /*
    *Con esta implementación, todas las instancias de los modelos compartirán la misma conexión a la base de datos a través de ConexionBD. 
    *La primera vez que se invoque obtenerInstancia(), se creará la conexión y en las siguientes invocaciones se retornará la instancia existente.
    *Esto asegurará que solo haya una conexión activa a la base de datos en todo momento, evitando la creación de múltiples conexiones innecesarias.
    */
    public static function get_instance() 
    {
        if ( !isset(self::$instancia) )
            self::$instancia = new self();
        
        return self::$instancia;
    }


    public function get_connection()
    {
        return $this->conectarBD;
    }


    public function prepare($query)
    {
        return $this->conectarBD->prepare($query);
    }


	public function query($setQuery) 
    {
        $query = mysqli_query($this->conectarBD, $setQuery);
        return $query;      
    }


    public function multi_query($setQuery) 
    {
        $query = mysqli_multi_query($this->conectarBD, $setQuery);
        return $query;      
    }


    public function number_of_records($consulta)
    {
        return mysqli_num_rows($consulta);
    }


    public function fetch_assoc($setFetch) 
    {
        $row = mysqli_fetch_assoc($setFetch);
        return $row;  
    }


    public function fetch_array($setFetch) 
    {
        $res = array();
        while($row = mysqli_fetch_assoc($setFetch)){
            array_push($res, $row);
        }
        return $res;  
    }


    public function real_escape_string($valor) 
    {
        $campo = mysqli_real_escape_string($this->conectarBD, $valor); 
        return $campo;
    }


    public function error() 
    {
        $error = mysqli_error($this->conectarBD);
        return $error;
    }


    public function free_result($result) 
    {
        $res = mysqli_free_result($result);
        return $res;
    }


    public function next_result() 
    {
        $res = mysqli_next_result($this->conectarBD);
        return $res;
    }


    public function store_result() 
    {
        $res = mysqli_store_result($this->conectarBD);
        return $res;
    }
    

    public function close_conexion() 
    {
        $res = mysqli_close($this->conectarBD);
        return $res;
    }

}

//Inicializamos Fecha y Hora local
//date_default_timezone_set('America/Mazatlan');


/*

Desarrollar un TaskManager que permita gestionar tareas de forma eficiente, incluyendo la creación, actualización y eliminación de tareas.
Iniciar como MVP.

Usuarios y Perfiles:
- Los usuarios podrán registrarse y autenticarse en el sistema.
- Los perfiles de usuario incluirán roles y permisos para acceder a diferentes funcionalidades del TaskManager.
- Implementar un sistema de autenticación JWT para asegurar las rutas y proteger los datos del usuario.
- Los usuarios podrán crear, actualizar y eliminar sus propios perfiles.
- Implementar un sistema de autorización basado en roles para controlar el acceso a las funcionalidades del TaskManager.
- Los perfiles de usuario podrán tener diferentes niveles de acceso, como administrador, editor y lector.

Creacion de Proyectos y Tareas:
- Los usuarios podrán crear proyectos y asignarles tareas.
- Cada proyecto podrá tener múltiples tareas asociadas.
- Las tareas podrán tener diferentes estados, como pendiente, en progreso y completada.
- Implementar un sistema de notificaciones para informar a los usuarios sobre cambios en sus tareas y proyectos.
- Los usuarios podrán asignar tareas a otros usuarios y establecer fechas de vencimiento.
- Implementar un sistema de comentarios para que los usuarios puedan discutir sobre las tareas y proyectos.
- Los usuarios podrán adjuntar archivos a las tareas y proyectos.
- Implementar un sistema de búsqueda y filtrado para que los usuarios puedan encontrar fácilmente tareas y proyectos.
- Los usuarios podrán marcar tareas como favoritas para acceder rápidamente a ellas.
- Implementar un sistema de etiquetas para categorizar tareas y proyectos.
- Los usuarios podrán establecer prioridades para las tareas y proyectos.
- Temporizador o seguimiento de tiempo (para saber cuánto toma una tarea).
- Recordatorios automáticos para tareas próximas a vencer.
- crear Subtareas o checklist dentro de una tarea.









*/
