<?php
    require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="normalize" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/stylesheet.css">
    <title>KC's Database</title>
</head>
<body>
    <h1>
        KC's Database
    </h1>
    <?php
        $result = mysqli_query($connection, "SELECT * FROM idm216_items");
            echo '<table class="data-table">
                <tr class="data-heading">'; 
                    while ($property = mysqli_fetch_field($result)) {
                        echo '<td>' . htmlspecialchars($property->name) . '</td>'; 
                    }
                echo '</tr>'; 

            
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    foreach ($row as $item) {
                        echo '<td>' . htmlspecialchars($item) . '</td>'; 
                    }
                    echo '</tr>';
                }
                echo "</table>";
    ?>
</body>
</html>