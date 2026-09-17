<?php

namespace app\Core;

class Validate
{

    public function validate($object, $annotations)
    {
        $errors = [];
        // var_dump($object);
        foreach ($annotations as $property => $rules) {
            $value = $object->$property;

            if (isset($rules['Required']) && empty($value)) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$rules['Name']} es requerido."
                ];
            }

            // boolean, integer, double, string, array, object, NULL, unknown type
            if (isset($rules['Type']) && gettype($value) !== $rules['Type']) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser de tipo {$rules['Type']}."
                ];
            }

            if (isset($rules['Min']) && strlen($value) < $rules['Min']) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser mayor o igual a {$rules['Min']}."
                ];
            }

            if (isset($rules['Max']) && strlen($value) > $rules['Max']) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser menor o igual a {$rules['Max']}."
                ];
            }

            if (isset($rules['Email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser un email válido."
                ];
            }

            if (isset($rules['Numeric']) && !is_numeric($value)) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser un número."
                ];
            }

            if (isset($rules['Alpha']) && !ctype_alpha($value)) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser alfabético."
                ];
            }

            if (isset($rules['AlphaNumeric']) && !ctype_alnum($value)) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser alfanumérico."
                ];
            }

            if (isset($rules['NoSpecialCharacters']) && !empty($value)) {
                if (is_null(json_decode($value))) { // Por si pasamos un string en formato json nos lo deje pasar
                    if (!preg_match('/^[0-9a-zA-Z\-ñÑáéíóúÁÉÍÓÚ@()+.,_ ]+$/', $value)){
                    // if (!preg_match('/^[0-9a-zA-Z\-@()+.,_ ]+$/', $value)){
                        $errors['errors'][] = [
                            "is_error" => true, 
                            "code_error" => 0, 
                            "meta_data" => ['alert_type' => 'warning'], 
                            "http_status_code" => 203, 
                            "message" => "El campo {$property} tiene caracteres especiales no permitidos."
                        ];
                    }
                }
            }

            if (isset($rules['GreaterThan']) && $value <= $rules['GreaterThan']) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser mayor a {$rules['GreaterThan']}."
                ];
            }

            // @In("M", "F")
            /* if (isset($rules['In']) && !in_array($value, $rules['In'])) {
                $errors['errors'][] = [
                    "is_error" => true, 
                    "code_error" => 0, 
                    "meta_data" => ['alert_type' => 'warning'], 
                    "http_status_code" => 203, 
                    "message" => "El campo {$property} debe ser uno de los siguientes valores: " . implode(', ', $rules['In']) . "."
                ];
            } */

            

        }
        // print_r($errors);
        return $errors;
    }

    public function transform($object, $annotations)
    {
        $transformedData = [];

        foreach ($annotations as $property => $rules) {

            $value = $object->$property;

            if (isset($rules['UpperCase'])) {
                $value = mb_strtoupper($value, 'UTF-8');
            }

            if (isset($rules['LowerCase'])) {
                $value = mb_strtolower($value, 'UTF-8');
            }

            if (isset($rules['Trim'])) {
                $value = trim($value ?? '');
            }

            if (isset($rules['Password'])) {
                $value = ( !empty($value) ) ? password_hash($value, PASSWORD_DEFAULT, ['cost' => 12]) : $value ;
            }

            if (isset($rules['RemoveAccents'])) {
                $caracteres = array(
                    'á' => 'a',
                    'é' => 'e',
                    'í' => 'i',
                    'ó' => 'o',
                    'ú' => 'u',
                    'Á' => 'A',
                    'É' => 'E',
                    'Í' => 'I',
                    'Ó' => 'O',
                    'Ú' => 'U',
                    'ñ' => 'n',
                    'Ñ' => 'N'
                    // Agrega más caracteres
                );

                $value = strtr($value, $caracteres);
            }

            if (isset($rules['Slug'])) {
                // Tranformamos todo a minusculas
                $url = strtolower($value);

                //Rememplazamos caracteres especiales latinos
                $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
                $repl = array('a', 'e', 'i', 'o', 'u', 'n');
                $url = str_replace ($find, $repl, $url);

                // Añaadimos los guiones
                $find = array(' ', '&', '\r\n', '\n', '+'); 
                $url = str_replace ($find, '-', $url);

                // Eliminamos y Reemplazamos demás caracteres especiales
                $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
                $repl = array('', '-', '');
                $url = preg_replace ($find, $repl, $url);

                $value = $url;
            }

            if (isset($rules['Type']) && $rules['Type'] == 'integer') {
                $value = (int) $value;
            }

            if (isset($rules['Type']) && $rules['Type'] == 'float') {
                $value = (float) $value;
            }

            if (isset($rules['Type']) && $rules['Type'] == 'double') {
                $value = (double) $value;
            }

            if (isset($rules['Type']) && $rules['Type'] == 'boolean') {
                $value = (bool) $value;
            }

            if (isset($rules['DateFormat']) && $rules['DateFormat'] == 'Y-m-d') {
                // Si viene vacio, se deja en NULL para que se inserte como NULL en la base de datos
                $value = ( !empty($value) ) ? date('Y-m-d', strtotime($value)) : NULL ;
                //$value = date('Y-m-d', strtotime($value));
            }

            if (isset($rules['DateFormat']) && $rules['DateFormat'] == 'd-m-Y') {
                $value = date('d-m-Y', strtotime($value));
            }

            // @Format("currency")
            if (isset($rules['Format']) && $rules['Format'] == 'currency') {
                $value = number_format($value, 2, '.', ',');
            }

            if ( isset($rules['PhoneNumber']) ) {
                // $value = preg_replace('/[^0-9]/', '', $value);
                // Eliminar espacios
                $number_mobile = preg_replace('/\s+/', '', $value);

                // Quitar símbolos y letras, dejar solo los números
                $number_mobile = preg_replace('/[^0-9]/', '', $value);
                
                $value = $number_mobile;
            }

            if ( isset($rules['ArrayToJson']) ) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            
            $transformedData[$property] = $value;
        }

        return $transformedData;
    }

}