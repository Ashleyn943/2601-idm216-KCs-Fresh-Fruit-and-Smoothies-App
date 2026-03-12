<?php
    session_start();
    require_once('db.php');
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
        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = [];
        }

        if (isset($_POST['order_submit'])) {
            foreach ($_POST['select'] as $item) {
                if ($item == 'small_1') {
                    $price = 4.00;
                    $size = 'Small';
                    $id = 1;
                } elseif ($item == 'medium_1') {
                    $price = 5.00;
                    $size = 'Medium';
                    $id = 1;
                } elseif ($item == 'large_1') {
                    $price = 6.00;
                    $size = 'Large';
                    $id = 1;
                } elseif ($item == 'small_2') {
                    $price = 4.00;
                    $size = 'Small';
                    $id = 2;
                }  elseif ($item == 'large_2') {
                    $price = 5.00;
                    $size = 'Large';
                    $id = 2;
                } elseif ($item == 'small_3') {
                    $price = 4.00;
                    $size = 'Small';
                    $id = 3;
                } elseif ($item == 'medium_3') {
                    $price = 5.00;
                    $size = 'Medium';
                    $id = 3;
                } elseif ($item == 'large_3') {
                    $price = 6.00;
                    $size = 'Large';
                    $id = 3;
                } elseif ($item == 'small_4') {
                    $price = 4.50;
                    $size = 'Small';
                    $id = 4;
                } elseif ($item == 'medium_4') {
                    $price = 5.50;
                    $size = 'Medium';
                    $id = 4;
                } elseif ($item == 'large_4') {
                    $price = 6.50;
                    $size = 'Large';
                    $id = 4;
                } else {
                    $price = null;
                    $id = null;
                }

                if (isset($_POST['pick'])) {
                    $ingredients = implode("*", $_POST['pick']);
                } else {
                    $ingredients = "not available";
                }  

                if(isset($_POST['add' . $id]) && !empty($_POST['add' . $id]) && is_array($_POST['add' . $id])) {
                    foreach ($_POST['add' . $id] as $add_on) {
                        $price += 0.50;
                    } 
                    $add_ons = implode("*", $_POST['add' . $id]);  
                } else {
                    $add_ons = "not available";
                }


                $_SESSION['order'][] = [
                    'item_id' => $id,
                    'size' => $size,
                    'item_price' => floatval($price),
                    'ingredients' => $ingredients ?? [],
                    'add_ons' => $add_ons ?? []
                ];

            }

            
        };
        
     ?>

    <a href="reset.php">Return to Menu</a>
    <h1>ORDER # <?php echo hexdec( uniqid() ); ?></h1>
    <h3>Receipt</h3>
         <?php
            foreach ($_SESSION['order'] as $row) {
                $item_name = $connection->query("SELECT name from idm216_items WHERE id = " . intval($row['item_id']) . "");
                $item_name_row = $item_name->fetch_assoc();
                echo "<ul>";
                echo "<li>" . htmlspecialchars($item_name_row['name'] ?? '') . " (" . htmlspecialchars($row['size']) . ") - $". number_format(floatval($row['item_price']), 2) . "</li>";
                    echo "<ul>";
                        if ($row['item_id'] == 1) {
                            $selected_ingredients = explode("*", $row['ingredients']);
                                    echo "<li>" . htmlspecialchars($selected_ingredients[0]) . "</li>";
                                    echo "<li>" . htmlspecialchars($selected_ingredients[1]) . "</li>";
                                    echo "<li>" . htmlspecialchars($selected_ingredients[2]) . "</li>";
                        }
                            if (!empty($row['add_ons']) && $row['add_ons'] != "not available") {
                                echo "<li> Add-Ons: </li>";
                                echo "<ul>";
                                $add_ons_listed = explode("*", $row['add_ons']);
                                    foreach ($add_ons_listed as $add_on) {
                                        echo "<li>" . htmlspecialchars($add_on) . " - $0.50</li>";
                                    }
                            }
                        echo "</ul>";
                    echo "</ul>";
                echo "</ul>";

                $total += floatval($row['item_price']);
            }
                $tax = $total * 0.08; //given tax rate of 8%
                $total += $tax;

                 echo "<p>Subtotal: $" . number_format($total - $tax, 2) . "</p>";
                 echo "<p>Tax (8%): $" . number_format($tax, 2) . "</p>";
                 echo "<p>Total: $" . number_format($total, 2) . "</p>";
         ?>
    <script src="javascript/postscript.js"></script>
</body>
</html>