<?php

namespace app\Core;

use app\Core\ConexionBD; 
use ReflectionClass;

class EntityModel
{
    protected $conexion;

    protected $bd = '';
    protected $table = '';

    public function __construct()
    {
    	// inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::get_instance();
    }


    public function get( $array_params = [], $onlyOne = false )
    {
        $params = $this->convertArrayParamsToString($array_params);

        $query = "CALL {$this->bd}.sp_get_{$this->table}($params)";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());

        $respuesta = $onlyOne ? $this->conexion->fetch_assoc($consulta) : $this->conexion->fetch_array($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }
    /* public function get(array $array_params = [], bool $onlyOne = false)
    {
        $procedureName = "{$this->bd}.sp_get_{$this->table}";
        $placeholders = '';
        $types = '';
        $values = [];

        if (!empty($array_params)) {
            // Genera los placeholders y tipos para bind_param
            $placeholders = implode(',', array_fill(0, count($array_params), '?'));
            foreach ($array_params as $param) {
                // Ajusta el tipo según tus necesidades (s=string, i=int, d=double, b=blob)
                $types .= is_int($param) ? 'i' : 's';
                $values[] = $param;
            }
            $query = "CALL $procedureName($placeholders)";
            $stmt = $this->conexion->prepare($query);
            if ($stmt === false) {
                throw new \RuntimeException("Error en prepare: " . $this->conexion->error);
            }
            $stmt->bind_param($types, ...$values);
            $stmt->execute();
            $result = $stmt->get_result();
            $respuesta = $onlyOne ? $result->fetch_assoc() : $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $this->conexion->next_result();
            return $respuesta;
        } else {
            // Sin parámetros, ejecuta directo
            $query = "CALL $procedureName()";
            $consulta = $this->conexion->query($query) or die($this->conexion->error());
            $respuesta = $onlyOne ? $this->conexion->fetch_assoc($consulta) : $this->conexion->fetch_array($consulta);
            $this->conexion->next_result();
            return $respuesta;
        }
    } */


    public function executeBasedFunction( string $functionName, array $array_params = [] )
    {
        $params = $this->convertArrayParamsToString($array_params);

        $query = "SELECT {$this->bd}.{$functionName}($params) AS RESPONSE";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->fetch_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function executeBasedProcedure( $procedureName, $array_params = [], $onlyOne = false)
    {
        $params = $this->convertArrayParamsToString($array_params);

        $query = "CALL {$this->bd}.{$procedureName}($params)"; 

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());

        $respuesta = $onlyOne ? $this->conexion->fetch_assoc($consulta) : $this->conexion->fetch_array($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function getAll( $data )
    {
        
    }


    public function save()
    {
        $params = $this->getAccessibleAttributeValuesAsString();

        $query = "CALL {$this->bd}.sp_save_{$this->table}($params)";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->fetch_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function getMatchingAttributeValuesFromDto($dtoClassName)
    {
        $dto = new $dtoClassName();

        // Crea un objeto ReflectionClass para el UsuarioModel.
        $reflectionClass = new ReflectionClass($this);

        // Obtiene todas las propiedades del UsuarioModel.
        $properties = $reflectionClass->getProperties();

        // Inicializa un array vacío para almacenar los valores de los atributos.
        $attributeValues = [];

        // Itera sobre cada propiedad.
        foreach ($properties as $property) {
            // Hace que la propiedad sea accesible.
            $property->setAccessible(true);

            // Obtiene el nombre de la propiedad.
            $name = $property->getName();

            // Si el DTO no tiene un atributo con este nombre, salta a la siguiente iteración.
            if (!property_exists($dto, $name)) {
                continue;
            }

            // Obtiene el valor de la propiedad.
            $value = $property->getValue($this);

            // Almacena el valor de la propiedad en el array.
            $attributeValues[$name] = $value;
        }

        // Devuelve el array de valores de los atributos.
        return $attributeValues;
    }



    /**
    * Convierte un array de parámetros en una cadena, donde cada elemento está separado por comas y rodeado por comillas simples.
    *
    * @param array $array_params El array de parámetros a convertir.
    * @return string La cadena de parámetros convertida.
    */
    private function convertArrayParamsToString( $array_params )
    {
        // Unimos los elementos del array en una cadena, separándolos con comas y rodeándolos con comillas simples.

        // Devuelve la cadena de parámetros.
        return ( empty($array_params) ) ? null : "'" . implode("', '", $array_params) . "'";
    }



    /**
    * Obtiene los atributos de la clase actual que tienen un método setter correspondiente.
    *
    * @return string Una cadena con los valores de los atributos, separados por comas y rodeados por comillas simples.
    */
    private function getAccessibleAttributeValuesAsString()
    {
        // Crea un objeto ReflectionClass para la clase actual.
        $reflectionClass = new ReflectionClass($this);

        // Obtiene todas las propiedades de la clase.
        $atributos = $reflectionClass->getProperties();

         // Filtra las propiedades para obtener solo las que tienen un método setter correspondiente en la clase actual y no son protected.
        $attrs = array_filter($atributos, function($property) {
            $nombre = $property->getName();
            $metodo_verificar = 'set' . ucfirst($nombre);

            $clase_original = $property->getDeclaringClass()->getName();
            $clase_actual = get_class($this);

            $es_protected = $property->isProtected();

            return 
                $clase_original == $clase_actual &&
                !$es_protected && 
                method_exists($this, $metodo_verificar);
        });

        // Obtiene los valores de las propiedades filtradas.
        foreach ($attrs as $property) {
            $nombre = $property->getName();
            $metodo = 'get' . ucfirst($nombre);

            $params[] = $this->$metodo();
        }

        // Crea una cadena con tantos '?' como parámetros haya
        // separados por comas y rodeados por comillas simples.
        $placeholders = implode("','", $params );

        return "'" . $placeholders . "'";
    }

}