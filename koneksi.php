<?php
/**
 * Load .env file into $_ENV and putenv (simple parser, no external deps).
 */
function load_dotenv($path = __DIR__ . '/.env')
{
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (!strpos($line, '=')) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Remove surrounding quotes
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
            (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }

        // Export to environment
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }

    return true;
}

function env($key, $default = null)
{
    $val = getenv($key);
    if ($val === false || $val === null) {
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }
        return $default;
    }
    return $val;
}

// Try to load .env from project root
load_dotenv(__DIR__ . '/.env');

// Database configuration using environment variables (fallback to previous defaults)
$host = env('DB_HOST', 'localhost');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', '');
$db   = env('DB_NAME', 'benahinyuk');

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}
?>