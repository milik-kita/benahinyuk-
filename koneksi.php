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

// Allow DATABASE_URL (e.g. mysql://user:pass@host:3306/dbname) to override individual vars
$databaseUrl = env('DATABASE_URL', null);
if ($databaseUrl) {
    $parts = parse_url($databaseUrl);
    if ($parts !== false) {
        $urlUser = isset($parts['user']) ? $parts['user'] : null;
        $urlPass = isset($parts['pass']) ? $parts['pass'] : null;
        $urlHost = isset($parts['host']) ? $parts['host'] : null;
        $urlPort = isset($parts['port']) ? $parts['port'] : null;
        $urlPath = isset($parts['path']) ? ltrim($parts['path'], '/') : null;

        if ($urlUser) {
            putenv("DB_USER={$urlUser}"); $_ENV['DB_USER'] = $urlUser;
        }
        if ($urlPass) {
            putenv("DB_PASS={$urlPass}"); $_ENV['DB_PASS'] = $urlPass;
        }
        if ($urlHost) {
            putenv("DB_HOST={$urlHost}"); $_ENV['DB_HOST'] = $urlHost;
        }
        if ($urlPort) {
            putenv("DB_PORT={$urlPort}"); $_ENV['DB_PORT'] = $urlPort;
        }
        if ($urlPath) {
            putenv("DB_NAME={$urlPath}"); $_ENV['DB_NAME'] = $urlPath;
        }
    }
}

$host = env('DB_HOST', '172.20.0.8');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', 'Oc7CnZR8k3TU5Mb7dobFGz0Tyy4WMppNKkcKpSMyg9dsni3sSvle8oHi3LIlgTnk');
$db   = env('DB_NAME', 'benahinyuk');
$port = env('DB_PORT', 3306);
$socket = env('DB_SOCKET', null);

// If DB_SOCKET is provided, prefer connecting via socket.
if ($socket) {
    $conn = mysqli_connect($host, $user, $pass, $db, null, $socket);
} else {
    // Connecting to 'localhost' uses a Unix socket by default in libmysqlclient.
    // If MySQL isn't available via socket (common in Docker containers),
    // force TCP by using 127.0.0.1 or by providing a remote host.
    $hostToUse = ($host === 'localhost') ? '127.0.0.1' : $host;
    $conn = mysqli_connect($hostToUse, $user, $pass, $db, (int)$port);
}

if (!$conn) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}
?>
