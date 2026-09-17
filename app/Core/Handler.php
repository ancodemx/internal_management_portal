<?php

namespace app\Core;

use app\Core\AnnotationReader;
use app\Core\Validate;

class Handler
{
    // private $usuarioCreateDto;
    private $dto;

    /* public function __construct(string $dtoClassName)
    {
        $this->dto = new $dtoClassName();
    } */
    public function __construct( string $dtoClassName )
    {
        $this->dto = new $dtoClassName();
    }


    /**
     * Maneja los datos de entrada, los transforma y valida según las anotaciones del DTO.
     *
     * @param array $data Los datos de entrada a manejar.
     * @return mixed Los errores de validación si los hay, o el DTO transformado y validado si no hay errores.
     */
    public function handle_mixed( $data )
    {
        // Convierte las claves del array de entrada de snake_case a camelCase.
        // Esto es necesario para que el DTO pueda asignar los valores correctamente y llevar una convención de nombres.
        $data = $this->arrayKeysToCamelCase($data);

        // Asigna los datos de entrada al DTO.
        foreach ($data as $key => $value) {
            if (property_exists($this->dto, $key)) {
                $this->dto->$key = $value;
            }
        }

        // Crea un nuevo lector de anotaciones y obtiene las anotaciones del DTO.
        $reader = new AnnotationReader();
        $annotations = $reader->getAnnotations($this->dto);

        // Crea un nuevo validador.
        $validator = new Validate();

        // Transforma los datos del DTO según las anotaciones.
        $transformedData = $validator->transform($this->dto, $annotations);
        
        // Asigna los datos transformados al DTO.
        foreach ($transformedData as $key => $value) {
            $this->dto->$key = $value;
        }

        // Valida los datos del DTO según las anotaciones.
        $errors = $validator->validate($this->dto, $annotations);

        // Si hay errores de validación, los devuelve en array.
        if (!empty($errors)) 
            return $errors;
        // Si no hay errores de validación, devuelve el DTO.
        else
            return $this->dto;
    }


    /**
     * Maneja un solo valor de entrada, lo transforma y valida según las anotaciones del DTO.
     * 
     * @param string $key La clave del valor de entrada.
     * @param mixed $value El valor de entrada.
     * 
     * @return mixed Los errores de validación si los hay, o el DTO transformado y validado si no hay errores.
     */
    public function handle_single_value($key, $value)
    {
        // print_r($this->dto);
        // Convierte la clave de entrada de snake_case a camelCase.
        $key = $this->snakeToCamelCase($key);

        // Asigna el valor de entrada al DTO si la propiedad existe.
        if (property_exists($this->dto, $key)) {
            $this->dto->$key = $value;
        }

        // Crea un nuevo lector de anotaciones y obtiene las anotaciones del DTO.
        $reader = new AnnotationReader();
        $annotations = $reader->getAnnotations($this->dto);

        // Crea un nuevo validador.
        $validator = new Validate();

        // Transforma los datos del DTO según las anotaciones.
        $transformedData = $validator->transform($this->dto, $annotations);

        // Asigna los datos transformados al DTO.
        foreach ($transformedData as $key => $value) {
            $this->dto->$key = $value;
        }

        // Valida los datos del DTO según las anotaciones.
        $errors = $validator->validate($this->dto, $annotations);

        // Si hay errores de validación, los devuelve en array.
        if (!empty($errors)) 
            return $errors;
        // Si no hay errores de validación, devuelve el DTO.
        else
            return $this->dto;
    }

    // Función auxiliar para convertir snake_case a camelCase.
    private function snakeToCamelCase($string)
    {
        $str = str_replace('_', '', ucwords($string, '_'));
        $str = lcfirst($str);
        return $str;
    }


    /**
     * Maneja los datos de entrada, los transforma y valida según las anotaciones del DTO.
     *
     * @param array $data Los datos de entrada a manejar.
     * @param string $returnAs El tipo de dato a devolver: "array" para devolver un array, "dto" para devolver el DTO.
     * @param string $typeKey El tipo de clave a manejar: "snake_case" para snake_case, "camelCase" para camelCase.
     */
    public function handle_tranformation($data, $returnAs = "array", $typeKey = "snake_case")
    {
        // Convierte las claves del array de entrada.
        // Esto es necesario para que el DTO pueda asignar los valores correctamente y llevar una convención de nombres.
        switch ($typeKey) {
            case "snake_case":
                $data = $this->arrayKeysToSnakeCase($data);
                break;
            case "camel_case":
                $data = $this->arrayKeysToCamelCase($data);
                break;
            default:
                break;
        }

        // Asigna los datos de entrada al DTO.
        // Si no existe una clave en el DTO, se ignora.
        foreach ($data as $key => $value) {
            if (property_exists($this->dto, $key)) {
                $this->dto->$key = $value;
            }
        }

        // Crea un nuevo lector de anotaciones y obtiene las anotaciones del DTO.
        $reader = new AnnotationReader();
        $annotations = $reader->getAnnotations($this->dto);

        // Crea un nuevo validador.
        $validator = new Validate();

        // Transforma los datos del DTO según las anotaciones.
        $transformedData = $validator->transform($this->dto, $annotations);

        // Asigna los datos transformados al DTO.
        foreach ($transformedData as $key => $value) {
            $this->dto->$key = $value;
        }

        if ($returnAs == "dto") {
            return $this->dto;
        } else {
            // Convertir el DTO a un array
            $dtoAsArray = get_object_vars($this->dto);
            
            // Devuelve el array.
            return $dtoAsArray;
        }
    }


    /**
     * Maneja los datos de entrada y los valida según las anotaciones del DTO.
     *
     * @param array $data Los datos de entrada a manejar.
     * @return array Los errores de validación si los hay, o un array vacío si no hay errores.
     */
    public function handle_validate($data)
    {
        // Convierte las claves del array de entrada de snake_case a camelCase.
        // Esto es necesario para que el DTO pueda asignar los valores correctamente y llevar una convención de nombres.
        $data = $this->arrayKeysToCamelCase($data);

        // Asigna los datos de entrada al DTO.
        /* foreach ($data as $key => $value) {
            $this->dto->$key = $value;
        } */
        foreach ($data as $key => $value) {
            if (property_exists($this->dto, $key)) {
                $this->dto->$key = $value;
            }
        }

        // Crea un nuevo lector de anotaciones y obtiene las anotaciones del DTO.
        $reader = new AnnotationReader();
        $annotations = $reader->getAnnotations($this->dto);

        // Crea un nuevo validador.
        $validator = new Validate();

        // Valida los datos del DTO según las anotaciones.
        $errors = $validator->validate($this->dto, $annotations);

        // Si hay errores de validación, los devuelve en array.
        if (!empty($errors)) 
            return $errors;
        // Si no hay errores de validación, devuelve un array vacío.
        else
            return [];
    }


    /**
     * Convierte las claves de un array de snake_case a camelCase.
     * esta función es recursiva.
     *
     * @param array $array El array a convertir.
     * @return array El array convertido.
     */
    public function arrayKeysToCamelCase( array $array ) : array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = $this->snakeToCamel($key);
            if (is_array($value)) {
                $result[$camelCaseKey] = $this->arrayKeysToCamelCase($value);
            } else {
                $result[$camelCaseKey] = $value;
            }
        }
        return $result;
    }

    public static function snakeToCamel($string) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }


    /**
     * Convierte las claves de un array de camelCase a snake_case.
     * esta función es recursiva.
     *
     * @param array $array El array a convertir.
     * @return array El array convertido.
     */
    public function arrayKeysToSnakeCase( array $array ) : array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $snakeCaseKey = $this->camelToSnake($key);
            if (is_array($value)) {
                $result[$snakeCaseKey] = $this->arrayKeysToSnakeCase($value);
            } else {
                $result[$snakeCaseKey] = $value;
            }
        }
        return $result;
    }

    public static function camelToSnake($string) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }


}