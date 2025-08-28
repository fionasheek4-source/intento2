<?php
// admin/login_action.php
require '../config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
$username = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();
if (!$admin || !password_verify($pass, $admin['password'])) {
    die('Credenciales admin inválidas');
}
session_regenerate_id(true);
$_SESSION['admin_id'] = $admin['id'];
header('Location: dashboard.php');
exit;
