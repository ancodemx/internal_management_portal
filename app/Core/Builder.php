<?php

namespace app\Core;

class Builder
{
    private $model;

    public function __construct(string $className)
    {
        $this->model = new $className();
    }

    /**
     * Construye un modelo a partir de un array y un valor 'ban'.
     *
     * @param array $data El array que contiene los datos para construir el modelo.
     * @param string $banValue El valor para el atributo 'ban' del modelo.
     * @return object El modelo construido.
     */
    public function build_array(array $data, string $banValue)
    {
        // Establece el valor 'ban' en el array.
        $data['ban'] = $banValue;

        // Itera sobre cada elemento del array.
        foreach ($data as $key => $value) {
             // Construye el nombre del método setter correspondiente al elemento actual.
            $setter = 'set' . ucfirst($key);

             // Si el método setter existe en el modelo, lo llama con el valor del elemento actual.
            if (method_exists($this->model, $setter)) {
                call_user_func([$this->model, $setter], $value);
            }
        }

        // Devuelve el modelo construido.
        return $this->model;
    }

    /**
     * Construye un modelo a partir de un DTO y un valor 'ban'.
     *
     * @param object $dto El DTO que contiene los datos para construir el modelo.
     * @param string $banValue El valor para el atributo 'ban' del modelo.
     * @return object El modelo construido.
     */
    public function build_dto($dto, string $banValue)
    {
        // Convierte el DTO en un array.
        $data = get_object_vars($dto);

        // Establece el valor 'ban'.
        $data['ban'] = $banValue;

        // Itera sobre cada elemento del array.
        foreach ($data as $key => $value) {

             // Construye el nombre del método setter correspondiente al elemento actual.
            $setter = 'set' . ucfirst($key);

            // Si el método setter existe en el modelo, lo llama con el valor del elemento actual.
            if (method_exists($this->model, $setter)) {
                call_user_func([$this->model, $setter], $value);
            }
        }

        // Devuelve el modelo construido.
        return $this->model;
    }

}