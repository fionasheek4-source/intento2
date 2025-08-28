<?php
// functions.php
function is_logged() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged()) {
        header('Location: login.php');
        exit;
    }
}
function e($s){ return htmlspecialchars($s, ENT_QUOTES); }
?>
