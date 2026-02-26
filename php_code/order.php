<?php
    session_start();
    require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="normalize" href="css/normalize.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Main Menu</title>
</head>
<body>
    <h1>KC's Menu</h1>

        <table id="menu">
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Ingredients</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Select Size</th>
                <th>Add-Ons</th>
            </tr>
                <?php
                    $result = mysqli_query($connection, "SELECT * FROM idm216_items items INNER JOIN idm216_images item_images ON items.id = item_images.id INNER JOIN idm216_prices ip ON items.id = ip.item_id");
                        while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
                                    echo "<td>";
                                        if ($row['id'] == 1) {
                                            echo "<form id='ingredients' method='POST' action='order_submit.php'>
                                                <label for='select_small'>
                                                <input class='" . htmlspecialchars($row['id']) . "' type='checkbox' name='pick[]' value='Strawberry'> Strawberry </label> | 
                                                <label for='select_medium'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Pineapple'> Pineapple </label> | 
                                                <label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Mixed Berry'> Mixed Berry </label> | 
                                                <label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Mango'> Mango </label> | 
                                                <label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Banana'> Banana </label> | 
                                                <label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Kale'> Kale </label> | 
                                                <label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='pick[]' value='Spinich'> Spinich </label>";
                                        }
                                    echo "</td>";
                                    echo "<td> $" . htmlspecialchars($row['s_price'] ?? '') . " | ";
                                    if ($row['m_price'] !== null){
                                        echo "$" . htmlspecialchars($row['m_price'] ?? '') . " | ";
                                    };
                                    echo "$" . htmlspecialchars($row['l_price'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                    echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' width='100'></td>";
                                    echo "<td>
                                            <form id='size_form' method='POST' action='order_submit.php'>
                                                <label for='select_small'>
                                                <input class='" . htmlspecialchars($row['id']) . "' type='radio' name='select[" . htmlspecialchars($row['id']) . "]' value='small_" . htmlspecialchars($row['id']) . "'> Small</label> |"; 
                                    if ($row['m_price'] !== null) {
                                    echo        "<label for='select_medium'>
                                                <input class='" . htmlspecialchars($row['id']) . "' type='radio' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='medium_" . htmlspecialchars($row['id'] ?? '') . "'> Medium</label> |";
                                    };
                                    echo        "<label for='select_large'>
                                                <input class='" . htmlspecialchars($row['id']) . "' type='radio' name='select[" . htmlspecialchars($row['id']) . "]' value='large_" . htmlspecialchars($row['id']) . "'> Large</label> 
                                        </td>";
                                    echo "<td>";
                                        if ($row['id'] != 2) {
                                            echo "<form id='add_on' method='POST' action='order_submit.php'>
                                                <label for='select_yogurt'>
                                                <input class='" . htmlspecialchars($row['id']) . "' type='checkbox' name='add" . htmlspecialchars($row['id']) . "[]' value='Yogurt'> Yogurt (+$0.50) </label> <br><br>

                                                <label for='select_whey'>
                                                <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='add" . htmlspecialchars($row['id'] ?? '') . "[]' value='Whey Protein'> Whey Protein (+$0.50) </label>";
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                        };
                ?>
        </table>
        
        <br><br>

        <input type="submit" value="Order" name="order_submit">
        </form>
        </form>
        </form>

        <input type="submit" value="Reset" name="reset_button" onclick="resetBtn()">

    <script src="javascript/postscript.js"></script>
</body>
</html>