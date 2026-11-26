<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME') ?: 'charity_db';
$portValue = getenv('DB_PORT');
$port = $portValue === false ? 3307 : filter_var($portValue, FILTER_VALIDATE_INT);
$sslSetting = getenv('DB_SSL');
$sslEnabled = $sslSetting === false
    ? false
    : filter_var($sslSetting, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

if ($port === false || $port < 1 || $port > 65535) {
    throw new RuntimeException('DB_PORT must be a valid TCP port.');
}

if ($sslEnabled === null) {
    throw new RuntimeException('DB_SSL must be a boolean value.');
}

if ($password === false) {
    $password = '';
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_init();

    if ($sslEnabled) {
        $sslCaFile = getenv('DB_SSL_CA_FILE');
        if ($sslCaFile === false || !is_readable($sslCaFile)) {
            throw new RuntimeException('DB_SSL_CA_FILE must point to a readable Aiven CA certificate.');
        }

        if (!defined('MYSQLI_OPT_SSL_VERIFY_SERVER_CERT')) {
            throw new RuntimeException('This PHP MySQLi build cannot verify the database TLS certificate.');
        }

        $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
        $conn->ssl_set(null, null, $sslCaFile, null, null);
    }

    $flags = $sslEnabled ? MYSQLI_CLIENT_SSL : 0;
    $conn->real_connect($servername, $username, $password, $dbname, $port, null, $flags);
    $conn->set_charset('utf8mb4');
} catch (Throwable $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Database connection failed. Check the server configuration.');
}
?>