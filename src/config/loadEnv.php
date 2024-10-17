<?php
//funcion para leer las claves del .env sin usar composer / dotenv

function loadEnv($path) {
    if (!file_exists($path)) {
        return "Archivo .env no encontrado";
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
       
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Divide en clave y valor
        list($key, $value) = explode('=', $line, 2);

        // Elimina espacios y comillas
        $key = trim($key);
        $value = trim($value, '"\' ');

        // Asigna la variable en $_ENV de forma que funcione tmb al publicarlo sin el .env
       if (!isset($_ENV[$key])) {
            $_ENV[$key] = $value;
        }
       
    }
}


loadEnv(__DIR__ . '/../../.env'); 

