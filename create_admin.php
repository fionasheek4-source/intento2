<?php
// create_admin.php (BORRAR luego de usar)
require 'config.php';
$username = 'admin';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)")->execute([$username, $hash]);
echo "Admin creado: $username / $password";
