<?php

namespace app\Utils;

use app\Exceptions\ResponseException;

class TransformUtils {

    public static function objectToArray(object $object): array 
    {
        return json_decode(json_encode($object, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function arrayToObject(array $array): object 
    {
        return json_decode(json_encode($array, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);
    }

    public static function jsonToArray(string $json): array 
    {
        try {

            // Si viene vacio
            if (empty($json)) {
                return [];
            }

            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($decoded))
                throw new ResponseException("JSON no representa un array.", 0, ["alert_type" => "error"], 400, false);
            
            return $decoded;

        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al convertir JSON a array: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
        
    }

    public static function jsonToObject(string $json): object 
    {
        try {
            $decoded = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
            
            if (!is_object($decoded))
                // ResponseException::statusResponse("JSON no representa un objeto.", 0, ["alert_type" => "error"], 400, false);
                throw new ResponseException("JSON no representa un objeto.", 0, ["alert_type" => "error"], 400, false);

            return $decoded;
        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al convertir JSON a objeto: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    }

    public static function arrayToJson(array $array, bool $pretty = false): string 
    {
        try {
            return json_encode($array, $pretty ? JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR : JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al convertir array a JSON: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    }

    public static function objectToJson(object $object, bool $pretty = false): string 
    {
        try {
            return json_encode($object, $pretty ? JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR : JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al convertir objeto a JSON: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    }

    /**
     * Convierte un array a una clase personalizada (tipo cast)
     * Esto es útil para transformar datos de un array a un objeto con propiedades específicas.
     * Ejemplo:
     *   $data = ['id' => 1, 'name' => 'John Doe'];
     *   $user = TransformUtils::castToClass(User::class, $data);
     * 
     * @param string $className
     * @param array $data
     * @return object
     */
    public static function castToClass(string $className, array $data): object 
    {
        try {
            if (!class_exists($className))
                throw new ResponseException("La clase '$className' no existe.", 0, ["alert_type" => "error"], 400, false);

            $object = new $className();
            foreach ($data as $key => $value) {
                if (property_exists($object, $key)) {
                    $object->$key = $value;
                }
            }
            return $object;
        }catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al convertir array a clase '$className': " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    }

    /**
     * Convertir los valores numericos de un array a enteros.
     * Esto es útil para asegurar que los valores numéricos se manejen como enteros en lugar de flotantes o cadenas.
     * Ejemplo:
     *   $data = ['1', '2.5', '3'];
     *   $result = TransformUtils::convertNumericValuesToInt($data);
     *   // $result será [1, 2, 3]
     * 
     * @param array $data
     * @return array
     */
    public static function convertNumericValuesToInt(array $data): array 
    {
        try {
            /* foreach ($data as $key => $value) {
                if (is_numeric($value)) {
                    $data[$key] = (int)$value;
                } elseif (is_array($value)) {
                    $data[$key] = self::convertNumericValuesToInt($value);
                }
            } */
            return array_map(function($value) {
                return is_numeric($value) ? (int)$value : $value;
            }, $data);

            // return $data;
        } catch (\Throwable $e) {
            throw new ResponseException("Error al convertir valores numéricos a enteros: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    }

    /**
     * Decodifica recursivamente un JSON en un array.
     * Esto es útil para manejar datos JSON anidados de manera más sencilla.
     * Ejemplo:
     *   $data = '{"user": {"id": 1, "name": "John"}}';
     *   $result = TransformUtils::recursiveJsonDecode($data);
     *   // $result será ['user' => ['id' => 1, 'name' => 'John']]
     */
    public static function recursiveJsonDecode($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::recursiveJsonDecode($value);
            }
            return $data;
        } elseif (is_string($data)) {
            $decoded = json_decode($data, true);
            // Si es un JSON válido y decodifica a array, lo reemplaza
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return self::recursiveJsonDecode($decoded);
            }
            return $data;
        } else {
            return $data;
        }
    }

    /**
     * Formatea una fecha de un formato a otro.
     * Esto es útil para estandarizar las fechas en la aplicación.
     * Ejemplo:
     *  $date = '23/03/2026';
     *  $formatted = TransformUtils::DateToFormatdmY($date, 'Y-m-d', 'd/m/Y');
     */
    public static function DateToFormatdmY(string $date, string $to_format, string $from_format = 'Y-m-d'): string 
    {
        try {
            $dateTime = \DateTime::createFromFormat($from_format, $date);
            if (!$dateTime) {
                throw new ResponseException("Fecha no válida: '$date'. Formato esperado: '$from_format'.", 0, ["alert_type" => "error"], 400, false);
            }
            return $dateTime->format($to_format);
        } catch (\Throwable $e) {
            if ($e instanceof ResponseException)
                throw $e;
            else
                throw new ResponseException("Error al formatear la fecha: " . $e->getMessage(), 0, ["alert_type" => "error"], 400, false);
        }
    
        
    }
}