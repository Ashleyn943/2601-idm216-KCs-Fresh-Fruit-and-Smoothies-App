<?php
require_once 'config.php';

$sql = "SELECT * FROM recipedata";      // selects all data from recipedata
$result = $connection->query($sql);     // forms connection from config.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database</title>
</head>

<body>
    <h1>KC's Database</h1>
    <table>
        <tr>
            <th></th>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
</body>

</html>