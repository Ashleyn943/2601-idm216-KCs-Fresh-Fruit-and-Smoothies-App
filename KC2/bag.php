<?php
    session_start();
    require_once('db.php'); 

    var_dump($_POST['quantity']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bag - KC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">

        <!-- Header -->
        <div class="page-header">
            <div style="width: 45px;"></div>
            <h1 class="page-title">YOUR BAG</h1>
            <div style="width: 45px;"></div>
        </div>

        <!-- Bag Content -->
        <div class="bag-content">

            <?php
                if (!empty($_SESSION['order'])) {
                //Items in Bag
                echo "<div class='bagItemsContainer'>";
                    foreach ($_SESSION['order'] as $index => $row) {
                        echo "<div class='bag-item' data-index='" . intval($index) . "'>";
                            echo "<div class='bag-item-image'>";
                                switch ($row['item_id']) {
                                    case 1:
                                        echo '<img src="Smoothie_images/custom.png" alt="Berry Blast">';
                                        break;
                                    case 2:
                                        echo '<img src="Smoothie_images/fruitCup.png" alt="Tropical Twist">';
                                        break;
                                    case 3:
                                        echo '<img src="Smoothie_images/pb_banana.png" alt="Green Machine">';
                                        break;
                                    case 4:
                                        echo '<img src="Smoothie_images/taro.png" alt="Citrus Burst">';
                                        break;
                                }
                            echo "</div>";
                            echo "<div class='bag-item-details'>";
                                echo "<div class='bag-item-header'>";
                                    $item_name = $connection->query("SELECT name from idm216_items WHERE id = " . intval($row['item_id']) . "");
                                    $item_name_row = $item_name->fetch_assoc();
                                    $lineTotal = floatval($row['item_price']) * intval($row['quantity']);
                                        echo "<span class='bag-item-name'>" . htmlspecialchars($item_name_row['name'] ?? '') . "</span>";
                                        echo "<span class='bag-item-price' id='price-" . intval($index) . "'>$" . number_format($lineTotal, 2) . "</span>";
                                echo "</div>";

                                echo "<div class='order-details'>";
                                    echo "<div class='detail-section'>";
                                        echo "<span class='detail-badge detail-size'>"; 
                                            if (htmlspecialchars($row['size']) == "small_1" || htmlspecialchars($row['size']) == "small_2" || htmlspecialchars($row['size']) == "small_3" || htmlspecialchars($row['size']) == "small_4") {
                                                echo "Small";
                                            } elseif (htmlspecialchars($row['size']) == "medium_1" || htmlspecialchars($row['size']) == "medium_3" || htmlspecialchars($row['size']) == "medium_4") {
                                                echo "Medium";
                                            } elseif (htmlspecialchars($row['size']) == "large_1" || htmlspecialchars($row['size']) == "large_2" || htmlspecialchars($row['size']) == "large_3" || htmlspecialchars($row['size']) == "large_4") {
                                                    echo "Large";
                                            }
                                        "</span>";
                                    echo "</div>";
                                    
                                    if ($row['item_id'] == 1) {
                                        $selected_ingredients = explode("*", $row['ingredients']);
                                        echo "<div class='detail-section'>";
                                            echo "<span class='detail-badge detail-ingredient'>";
                                                echo "<img 
                                                        src='";
                                                            switch ($selected_ingredients[0]) {
                                                                case 'Banana':
                                                                    echo "ingredients/banana.png";
                                                                    break;
                                                                case 'Kale':
                                                                    echo "ingredients/kale.png";
                                                                    break;
                                                                case 'Mango':
                                                                    echo "ingredients/mango.png";
                                                                    break;
                                                                case 'Mixed Berry':
                                                                    echo "ingredients/mixberries.png";
                                                                    break;
                                                                case 'Pineapple':
                                                                    echo "ingredients/pineapple.png";
                                                                    break;
                                                                case 'Spinach':
                                                                    echo "ingredients/spinach.png";
                                                                    break;
                                                                case 'Strawberry':
                                                                    echo "ingredients/strawberry.png";
                                                                    break;
                                                            };
                                                    echo "' alt='" . htmlspecialchars($selected_ingredients[0]) . "' class='detail-icon'>";
                                                echo htmlspecialchars($selected_ingredients[0]);
                                            echo "</span>";

                                            echo "<span class='detail-badge detail-ingredient'>";
                                                echo "<img 
                                                        src='";
                                                            switch ($selected_ingredients[1]) {
                                                                case 'Banana':
                                                                    echo "ingredients/banana.png";
                                                                    break;
                                                                case 'Kale':
                                                                    echo "ingredients/kale.png";
                                                                    break;
                                                                case 'Mango':
                                                                    echo "ingredients/mango.png";
                                                                    break;
                                                                case 'Mixed Berry':
                                                                    echo "ingredients/mixberries.png";
                                                                    break;
                                                                case 'Pineapple':
                                                                    echo "ingredients/pineapple.png";
                                                                    break;
                                                                case 'Spinach':
                                                                    echo "ingredients/spinach.png";
                                                                    break;
                                                                case 'Strawberry':
                                                                    echo "ingredients/strawberry.png";
                                                                    break;
                                                            };
                                                echo "' alt='" . htmlspecialchars($selected_ingredients[1]) . "' class='detail-icon'>";
                                                echo htmlspecialchars($selected_ingredients[1]);
                                            echo "</span>";

                                            echo "<span class='detail-badge detail-ingredient'>";
                                                echo "<img 
                                                        src='";
                                                            switch ($selected_ingredients[2]) {
                                                                case 'Banana':
                                                                    echo "ingredients/banana.png";
                                                                    break;
                                                                case 'Kale':
                                                                    echo "ingredients/kale.png";
                                                                    break;
                                                                case 'Mango':
                                                                    echo "ingredients/mango.png";
                                                                    break;
                                                                case 'Mixed Berry':
                                                                    echo "ingredients/mixberries.png";
                                                                    break;
                                                                case 'Pineapple':
                                                                    echo "ingredients/pineapple.png";
                                                                    break;
                                                                case 'Spinach':
                                                                    echo "ingredients/spinach.png";
                                                                    break;
                                                                case 'Strawberry':
                                                                    echo "ingredients/strawberry.png";
                                                                    break;
                                                            };
                                                echo "' alt='" . htmlspecialchars($selected_ingredients[2]) . "' class='detail-icon'>";
                                                echo htmlspecialchars($selected_ingredients[2]);
                                            echo "</span>";
                                        echo "</div>";
                                    }

                                    if (!empty($row['add_ons']) && $row['add_ons'] != "not available") {
                                        $add_on_listeed = explode("*", $row['add_ons']);
                                        echo "<div class='detail-section'>";
                                            foreach ($add_on_listeed as $add_on) {
                                                echo "<span class='detail-badge detail-addon'>" . htmlspecialchars($add_on) . " (+$0.50)</span>";
                                            }
                                        echo "</div>";
                                    }
                                echo "</div>";

                                echo "<div class='bag-item-actions'>";
                                    echo "<a href='edit_item.php?id=" . intval($row['item_id']) . "&edit=" . intval($index) . "'' class='bag-action-link'>Edit</a>";
                                    echo "<a href='#' class='bag-action-link removeBtn' data-index='" . intval($index) . "'>Remove</a>";
                                    echo "<div class='bag-quantity-controls' data-index='" . intval($index) . "' data-base-price='" . floatval($row['item_price']) . "'>";
                                        echo "<button type='button' class='quantity-button minus'>−</button>";
                                        echo "<span class='quantity'>" . intval($row['quantity']) . "</span>";
                                        echo "<button type='button' class='quantity-button plus'>+</button>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";                
                        }
            echo "</div>";

            echo "<div class='bag-subtotal'>";
                echo "<span>Subtotal</span>";
                echo "<span class='bag-subtotal-amount'>";
                        $subtotal = 0;
                        foreach ($_SESSION['order'] as $row) {
                            $subtotal += floatval($row['item_price']) * intval($row['quantity']);
                        }
                        echo "$" . number_format($subtotal, 2);
                echo "</span>";
            echo "</div>";

            //Buttons 
            echo "<div class='bag-action-buttons'>";
                echo "<a href='index.php' class='btn btn-secondary'>Add more items</a>";
                echo "<a href='checkout.php' class='btn btn-primary'>Checkout</a>";
            echo "</div>";
        } else {
            echo "<div class='bagItemsContainer'>";
                echo "<div class='empty-bag'>";
                    echo "<div class='empty-bag-icon-svg'>";
                        echo "<svg width='120' height='120' viewBox='0 0 200 200' fill='none' xmlns='http://www.w3.org/2000/svg'>";
                            // Bag body 
                            echo "<path d='M40 75 L160 75 L170 180 L30 180 Z' 
                                stroke='#ddd' 
                                stroke-width='7' 
                                fill='none' 
                                stroke-linejoin='round'/>";
                            
                            //Single handle
                            echo "<path d='M65 75 C65 45, 135 45, 135 75'
                                stroke='#ddd' 
                                stroke-width='7' 
                                fill='none' 
                                stroke-linecap='round'/>";
                        echo"</svg>";
                    echo"</div>";
                        echo "<h2 class='empty-bag-title'>Your Bag is Empty</h2>";
                        echo "<p class='empty-bag-message'>Order some delicious smoothies!</p>";
                        echo "<a href='index.php' class='empty-bag-button'>Start Ordering</a>";
                echo "</div>";
            echo "</div>";
        }
        
        ?>
        </div>
        <!-- Navigation Bar -->
        <div class="nav-bar">
            <a href="index.php" class="nav-item">Order</a>
            <a href="bag.php" class="nav-item active">Bag</a>
            <div class="nav-item history">History</div>
        </div>
    </div>

    <!-- Remove Confirmation Modal -->
    <div class="modal-overlay-centered" id="removeModal">
        <div class="confirm-modal">
            <h2 class="confirm-title">Remove Item?</h2>
            <p class="confirm-message">Are you sure you want to remove this item from your bag?</p>
            <div class="confirm-buttons">
                <button class="btn btn-secondary" id="cancelRemove">Cancel</button>
                <button class="btn btn-primary" id="confirmRemove">Remove</button>
            </div>
        </div>
    </div>

    <script src="app.js"></script>
</body>
</html>
