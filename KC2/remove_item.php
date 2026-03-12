<?php
session_start();

$index = isset($_GET['index']) ? intval($_GET['index']) : -1;

if ($index >= 0 && isset($_SESSION['order'][$index])) {
    array_splice($_SESSION['order'], $index, 1);
}

header('Location: bag.php');
exit;
?>