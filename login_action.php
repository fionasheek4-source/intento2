<?php
// login_action.php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) { die('CSRF inválido'); }

$email = $_POST['email'];
$pass = $_POST['password'];

$stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($pass, $user['password'])) {
    die('Credenciales inválidas.');
}

// login
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
header('Location: vote.php');
exit;
