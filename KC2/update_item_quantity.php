<?php
session_start();

$index    = isset($_GET['index'])    ? intval($_GET['index'])    : -1;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

if ($index >= 0 && isset($_SESSION['order'][$index])) {
    $basePrice = floatval($_SESSION['order'][$index]['base_price'] ?? $_SESSION['order'][$index]['item_price']);
    
    if (!isset($_SESSION['order'][$index]['base_price'])) {
        $_SESSION['order'][$index]['base_price'] = $basePrice;
    }

    $_SESSION['order'][$index]['quantity']   = $quantity;
    $_SESSION['order'][$index]['item_price'] = $basePrice * $quantity;

    echo json_encode(['success' => true, 'new_price' => $_SESSION['order'][$index]['item_price']]);
} else {
    echo json_encode(['success' => false]);
}
?>