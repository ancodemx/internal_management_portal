<?php

namespace app\Core;

class EnvLoader
{
    public static function load(string $path = __DIR__ . '/../../.env'): void
    {

        // Validar si el archivo .env generico existe
        // Este archivo es el que se utiliza para cargar las variables de entorno por defecto
        if (!file_exists($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Procesar cada línea del archivo para obtener las variables de entorno
        self::processEnvLine($lines);


        
        // Definir archivo .env a usar según entorno
        $envFile = match ($_ENV['APP_ENV']) {
            'testing' => '.env.testing',
            'development' => '.env.development',
            default => '.env.production'
        };

        // Validar si el archivo .env definido existe
        $path = __DIR__ . '/../../' . $envFile;
        if (!file_exists($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Limpiar las variables de entorno antes de cargar el nuevo archivo
        $_ENV = [];

        // Procesar cada línea del archivo env definido
        // Obtenemos ahora las variables de entorno del archivo .env definido
        self::processEnvLine($lines);
        
        // Validaciones específicas
        self::validate($_ENV);

    }

    /**
     * Obtiene el valor de una variable de entorno.
     *
     * @param string $key     La clave de la variable de entorno.
     * @param mixed $default  Valor por defecto si la variable no está definida.
     * @return mixed El valor de la variable de entorno o el valor por defecto.
     * Si la variable no está definida, se devuelve el valor por defecto.
     * 
     * Como utilizar:
     * $valor = EnvLoader::get('NOMBRE_VARIABLE_ENV', 'valor_por_defecto');
     * ó
     * $valor = EnvLoader::get('NOMBRE_VARIABLE_ENV');
     */
    public static function get(string $key, $default = null): mixed
    {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }


    public static function processEnvLine(array $lines): void
    {
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) continue;

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }


    /**
     * Validaciones específicas por entorno
     */
    private static function validate(array $env): void
    {
        $dbName = $env['DB_NAME'] ?? null;
        $dbPort = $env['DB_PORT'] ?? null;
        $dbUser = $env['DB_USER'] ?? null;

        if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $dbName)) {
            echo "❌ ERROR: DB_NAME contiene caracteres inválidos.\n";
            exit(1);
        }
        
        if (!is_numeric($dbPort) || (int)$dbPort <= 0) {
            echo "❌ ERROR: DB_PORT debe ser un número válido. Se recibió: $dbPort\n";
            exit(1);
        }

        if ($env['APP_ENV'] === 'testing' && !str_contains($dbName, 'test')) {
            echo "❌ ERROR: En entorno 'testing', DB_NAME debe contener la palabra 'test'.\n";
            exit(1);
        }

        if ($env['APP_ENV'] === 'production' && $dbUser === 'root') {
            echo "⚠️  ADVERTENCIA: No se recomienda usar 'root' como DB_USER en producción.\n";
        }

    }
}
