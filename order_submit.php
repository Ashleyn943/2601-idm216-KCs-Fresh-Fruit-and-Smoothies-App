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
                $stmt=$connection->prepare("INSERT INTO idm216_orders (item_id, size, item_price) VALUES (?,?,?)");
                $stmt->bind_param("isd", $id, $size, $price);
                $stmt->execute();
            }

            
        };
        
     ?>

    <a href="main.php">Return to Menu</a>

    <h2>Receipt</h2>
         <?php
            $sql = "SELECT items.name, orders.size, orders.item_price FROM idm216_orders orders INNER JOIN idm216_items items ON orders.item_id = items.id";
            $result = mysqli_query($connection, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                echo "<p>Items:</p>";
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>" . htmlspecialchars($row['name'] ?? '') . " - " . htmlspecialchars($row['size'] ?? '') . " - $" . htmlspecialchars($row['item_price'] ?? '') . "</li>";
                }
                
            }

            foreach ($row['item_price'] as $price) {
                $total += floatval($price);
            }
                $tax = $total * 0.08; //given tax rate of 8%
                $total += $tax;

                echo "</ul>";
                echo "<p>Subtotal: $" . number_format($total - $tax, 2) . "</p>";
                echo "<p>Tax (8%): $" . number_format($tax, 2) . "</p>";
                echo "<p>Total: $" . number_format($total, 2) . "</p>";
         ?>
    <script src="javascript/postscript.js"></script>
</body>
</html>