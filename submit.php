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

        if (isset($_POST['select'])) {
            $total = 0;

            foreach ($_POST['select'] as $size) {
                $total += floatval($size);
            }
                $tax = $total * 0.08; //given tax rate of 8%
                $total += $tax;
        }

        
    ?>

    <a href="main.php">Return to Menu</a>

    <h2>Receipt</h2>
        <?php
            if (isset($_POST['select'])) {
                echo "<p>Items:</p>";
                echo "<ul>";
                foreach ($_POST['select'] as $items) {
                    $id = array_search($items, $_POST['select']);
                    $result = mysqli_query($connection, "SELECT items.name FROM idm216_items items WHERE items.id = $id");
                    $row = mysqli_fetch_assoc($result);
                        echo "<li>" . htmlspecialchars($row['name'] ?? []) . " - $" . htmlspecialchars($items ?? []) . "</li>";
                }
                echo "</ul>";
            }
                echo "<p>Subtotal: $" . number_format($total - $tax, 2) . "</p>";
                echo "<p>Tax (8%): $" . number_format($tax, 2) . "</p>";
                echo "<p>Total: $" . number_format($total, 2) . "</p>";
        ?>
</body>
</html>