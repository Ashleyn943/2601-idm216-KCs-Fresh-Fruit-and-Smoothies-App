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
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Select</th>
            </tr>
                <?php
                    $result = mysqli_query($connection, "SELECT * FROM idm216_items items INNER JOIN idm216_images item_images ON items.id = item_images.id");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                                 echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                 echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                 echo "<td> $" . htmlspecialchars($row['s_price']) . " | $" . htmlspecialchars($row['m_price']) . " | $" . htmlspecialchars($row['l_price']) . "</td>";
                                 echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                 echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' width='100'></td>";
                                 echo "<td>
                                        <form id='size_form' method='POST' action='submit.php'>
                                            <label for='select_small'>
                                            <input class='size_select' type='radio' name='select[" . htmlspecialchars($row['id'])  . "][]' value='" . htmlspecialchars($row['id']) . "'> Small</label> | 
                                            <label for='select_medium'>
                                            <input class='size_select' type='radio' name='select[" . htmlspecialchars($row['id'])  . "][]' value='" . htmlspecialchars($row['id']) . "'> Medium</label> | 
                                            <label for='select_large'>
                                            <input class='size_select' type='radio' name='select[" . htmlspecialchars($row['id'])  . "][]' value='" . htmlspecialchars($row['id']) . "'> Large</label> 
                                        </form>
                                    </td>";
                                 echo "</tr>";
                        };
                ?>
        </table>
        
        <br><br>
        <input type="submit" form="size_form" value="Order" name="order_button" action="submit.php">

        <input type="submit" value="Reset" name="reset_button" onclick="resetBtn()">

    <script src="javascript/postscript.js"></script>
</body>
</html>