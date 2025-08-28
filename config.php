<?php
// config.php
// Ajusta estos datos según tu entorno (XAMPP: user=root, pass=)
$DB_HOST = 'localhost';
$DB_NAME = 'sistema_votos';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die("DB Connection failed: " . $e->getMessage());
}

session_start();
// CSRF token básico
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
