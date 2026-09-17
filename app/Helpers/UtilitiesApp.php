<?php

namespace app\Helpers;

/**
 * Clase UtilitiesApp
 * 
 * Clase que se encarga de contener métodos de lógica interna que pueden ser utilizados en cualquier parte del sistema.
 * Esto con el fin de evitar la duplicidad de código y facilitar el mantenimiento del sistema.
 */

class UtilitiesApp{

    private static $instancia;

    public static function obtenerInstanciaUtilerias() 
    {
        if ( !isset(self::$instancia) ) 
            self::$instancia = new self();
        
        return self::$instancia;
    }

}
