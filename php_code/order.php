<?php
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
            <th>Add Ons</th>
            <th>Select</th>
        </tr>

        <!-- added add on and ingredients -->
        <?php
        $result = mysqli_query($connection, "SELECT * FROM idm216_items items INNER JOIN idm216_images item_images ON items.id = item_images.id");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
            echo "<td>";
            if ($row['id'] == 1) {
                echo "<form id='ingredients' method='POST' action='receipt.php'>
                                            <label for='select_small'>
                                            <input class='" . htmlspecialchars($row['id']) . "' type='checkbox' name='select[" . htmlspecialchars($row['id']) . "]' value='strawberry_" . "'> Strawberry </label> | 
                                            <label for='select_medium'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='pineapple_" . "'> Pineapple </label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='mixed_" . "'> Mixed Berry </label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='mango_" . "'> Mango </label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='banana_" . "'> Banana </label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='kale_" . "'> Kale </label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='spinich_" . "'> Spinich </label>";
            }
            echo "</td>";
            echo "<td> $" . htmlspecialchars($row['s_price'] ?? '') . " | $" . htmlspecialchars($row['m_price'] ?? '') . " | $" . htmlspecialchars($row['l_price'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' width='100'></td>";
            echo "<td>";
            if ($row['id'] != 2) {
                echo "<form id='add_on' method='POST' action='receipt.php'>
                                            <label for='select_yogurt'>
                                            <input class='" . htmlspecialchars($row['id']) . "' type='checkbox' name='select[" . htmlspecialchars($row['id']) . "]' value='yogurt_" . htmlspecialchars($row['price_change']) . "'> Yogurt </label> | 
                                            <label for='select_whey'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='checkbox' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='whey_" . htmlspecialchars($row['price_change'] ?? '') . "'> Whey Protein </label>";
            }
            echo "</td>";
            echo "<td>
                                        <form id='size_form' method='POST' action='receipt.php'>
                                            <label for='select_small'>
                                            <input class='" . htmlspecialchars($row['id']) . "' type='radio' name='select[" . htmlspecialchars($row['id']) . "]' value='" . htmlspecialchars($row['s_price']) . "'> Small</label> | 
                                            <label for='select_medium'>
                                            <input class='" . htmlspecialchars($row['id'] ?? '') . "' type='radio' name='select[" . htmlspecialchars($row['id'] ?? '') . "]' value='" . htmlspecialchars($row['m_price'] ?? '') . "'> Medium</label> | 
                                            <label for='select_large'>
                                            <input class='" . htmlspecialchars($row['id']) . "' type='radio' name='select[" . htmlspecialchars($row['id']) . "]' value='" . htmlspecialchars($row['l_price']) . "'> Large</label> 
                                    </td>";
            echo "</tr>";
        };
        ?>
    </table>

    <br><br>
    <input type="submit" value="Order" name="order_button">
    </form>

    <input type="submit" value="Reset" name="reset_button" onclick="resetBtn()">


    <script src="javascript/postscript.js"></script>
</body>

</html>