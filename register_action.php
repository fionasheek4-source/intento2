<?php
// register_action.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) { die('Token CSRF inválido'); }

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$pass = $_POST['password'];

if (empty($name) || empty($email) || empty($pass)) {
    die('Completa todos los campos.');
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    die('El correo ya está registrado.');
}

$hash = password_hash($pass, PASSWORD_DEFAULT);
$insert = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$insert->execute([$name, $email, $hash]);

header('Location: login.php?registered=1');
exit;
