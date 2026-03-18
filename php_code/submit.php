<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>
<body>
    <?php
        require_once('db.php');

        if (isset($_POST['order_button'])) {
            foreach ($_POST['select'] as $item) {
                if ($item == 'small_1') {
                    $price = 4.00;
                    $size = 'small';
                    $id = 1;
                } elseif ($item == 'medium_1') {
                    $price = 5.00;
                    $size = 'medium';
                    $id = 1;
                } elseif ($item == 'large_1') {
                    $price = 6.00;
                    $size = 'large';
                    $id = 1;
                } elseif ($item == 'small_2') {
                    $price = 4.00;
                    $size = 'small';
                    $id = 2;
                } elseif ($item == 'medium_2') {
                    $price = null;
                    $size = 'medium';
                    $id = 2;
                } elseif ($item == 'large_2') {
                    $price = 5.00;
                    $size = 'large';
                    $id = 2;
                } elseif ($item == 'small_3') {
                    $price = 4.00;
                    $size = 'small';
                    $id = 3;
                } elseif ($item == 'medium_3') {
                    $price = 5.00;
                    $size = 'medium';
                    $id = 3;
                } elseif ($item == 'large_3') {
                    $price = 6.00;
                    $size = 'large';
                    $id = 3;
                } elseif ($item == 'small_4') {
                    $price = 4.50;
                    $size = 'small';
                    $id = 4;
                } elseif ($item == 'medium_4') {
                    $price = 5.50;
                    $size = 'medium';
                    $id = 4;
                } elseif ($item == 'large_4') {
                    $price = 6.50;
                    $size = 'large';
                    $id = 4;
                } else {
                    $price = null;
                    $id = null;
                }
                $_SESSION['order'][] = [
                    'item_id'     => $id,
                    'size'        => $size,
                    'item_price'  => floatval($price),
                ];
            }
        };
        
     ?>

    <a href="main.php">Return to Menu</a>

    <h2>Receipt</h2>
        <?php
            echo "<p>Items:</p>";
            echo "<ul>";
            foreach ($_SESSION['order'] as $items) {
                $id = $items['item_id'];
                $stmt = $connection->prepare("SELECT name FROM idm216_items WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo "<li>" . htmlspecialchars($row['name'] ?? []) . " (" . htmlspecialchars($items['size'] ?? []) . ") - $" . number_format($items['item_price'] ?? 0, 2) . "</li>";

                $total += floatval($items['item_price']);
            }

                $tax = $total * 0.08; //given tax rate of 8%
                $total += $tax;

                echo "</ul>";
                echo "<p>Subtotal: $" . number_format($total - $tax, 2) . "</p>";
                echo "<p>Tax (8%): $" . number_format($tax, 2) . "</p>";
                echo "<p>Total: $" . number_format($total, 2) . "</p>";
        ?>
</body>
</html>