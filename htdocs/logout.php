<?php
require_once 'config/auth.php';

$auth = new Auth();
$auth->logout();

// Перенаправление на главную страницу
header('Location: index.php');
exit();
?>
