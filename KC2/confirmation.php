<?php
    session_start();
    require_once(__DIR__ . '/db.php');

    $summary = $_SESSION['summary'] ?? [
        'subtotal' => 0,
        'tax'      => 0,
        'tip'      => 0,
        'total'    => 0
    ];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - KC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="confirmation-content">
            <h1 class="confirmation-title">ORDER CONFIRMED</h1>
            <p class="confirmation-subtitle">Preparing your order...</p>

            <!-- Order Number -->
            <div class="order-number">
                <div class="order-number-label">Order #42</div>
            </div>

            <div class="receipt">
                <div class="receipt-header">
                    <div class="check-icon">✓</div>
                    <div class="location-name">KC's</div>
                    <div class="ready-time">Ready by: ASAP (10-15 minutes)</div>
                    <div class="pickup-name">Pick up name: Guest</div>
                </div>

                <hr class="receipt-divider">

                <div class="receipt-item" style="display: block;">
                        <div>
                            <?php
                                foreach ($_SESSION['order'] as $row) {
                                    $item_name = $connection->query("SELECT name from idm216_items WHERE id = " . intval($row['item_id']) . "");
                                    $item_name_row = $item_name->fetch_assoc();
                                    echo "<div style='display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;'>";
                                        echo "<div style='flex: 1;'>";
                                            echo "<div class='summary-item-name' style='font-weight: 600; margin-bottom: 4px;'>" 
                                                . htmlspecialchars($item_name_row['name'] ?? '') . " - "
                                                . htmlspecialchars($row['quantity']) . "x" .
                                            "</div>";
                                            echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; line-height: 1.4;'>" ; 
                                                if (htmlspecialchars($row['size']) == "small_1" || htmlspecialchars($row['size']) == "small_2" || htmlspecialchars($row['size']) == "small_3" || htmlspecialchars($row['size']) == "small_4") {
                                                    echo "Small";
                                                } elseif (htmlspecialchars($row['size']) == "medium_1" || htmlspecialchars($row['size']) == "medium_3" || htmlspecialchars($row['size']) == "medium_4") {
                                                    echo "Medium";
                                                } elseif (htmlspecialchars($row['size']) == "large_1" || htmlspecialchars($row['size']) == "large_2" || htmlspecialchars($row['size']) == "large_3" || htmlspecialchars($row['size']) == "large_4") {
                                                    echo "Large";
                                                }
                                            "</div>";

                                            if ($row['item_id'] == 1) {
                                                $selected_ingredients = explode("*", $row['ingredients']);
                                                    echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; line-height: 1.4;'>" 
                                                        . htmlspecialchars($selected_ingredients[0]) . ", "
                                                        . htmlspecialchars($selected_ingredients[1]) . ", " 
                                                        . htmlspecialchars($selected_ingredients[2]) . 
                                                    "</div>";
                                            };

                                            if (!empty($row['add_ons']) && $row['add_ons'] != "not available") {
                                                $add_ons_listed = explode("*", $row['add_ons']);
                                                echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; line-height: 1.4;'>
                                                    Add Ons:
                                                </div>";
                                                    foreach ($add_ons_listed as $add_on) {
                                                        echo "<div class='order-details-checkout' style='margin-left: 15px; font-size: 13px; color: #666; line-height: 1.4;'>";
                                                            echo htmlspecialchars($add_on);
                                                                if ($row['quantity'] > 1) {
                                                                    echo " (per smoothie) ";
                                                                };
                                                        echo "</div>";
                                                    }
                                            };
                                        echo "</div>";
                                        echo "</div>";

                                        if (!empty($row['add_ons']) && $row['add_ons'] != "not available" && $row['item_id'] !== 2) {
                                            $item_price = $row['item_price'] - (count(explode("*", $row['add_ons'])) * 0.50);
                                            $add_on_listeed = explode("*", $row['add_ons']);
                                            $quantity_price = $item_price * intval($row['quantity']);
                                                echo "<div>";
                                                    echo "<div style='font-weight: 600; margin-left: 15px; margin-bottom: 4px; white-space: nowrap;'> $" 
                                                        . number_format(floatval($quantity_price), 2) . 
                                                    "</div>";
                                                    echo "<div class='order-details-checkout' style='line-height: 1.4;'>";
                                                        echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; margin-left: 15px; line-height: 1.4;'>&nbsp;</div>";

                                                        if ($row['item_id'] == 1) {
                                                            echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; margin-left: 15px; line-height: 1.4;'>&nbsp;</div>";
                                                        }

                                                        echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; margin-left: 15px; line-height: 1.4;'>&nbsp;</div>";
                                                        echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; margin-left: 15px; line-height: 1.4;'>&nbsp;</div>";
                                                        
                                                        foreach ($add_on_listeed as $add_on){
                                                            echo "<div class='order-details-checkout' style='font-size: 13px; color: #666; margin-left: 15px; line-height: 1.4;'>";
                                                                $total_add_on_price = 0.50;
                                                                $addon_quantity = $total_add_on_price * intval($row['quantity']);
                                                                echo "+ " . number_format(floatval($addon_quantity), 2);
                                                            echo "</div>";
                                                        }
                                                    echo "</div>";
                                                echo "</div>";
                                        } else {
                                            $quantity_price = $row['item_price'] * intval($row['quantity']);
                                            echo "<div style='font-weight: 600; margin-left: 15px; white-space: nowrap;'> $" 
                                                . number_format(floatval($quantity_price), 2) . 
                                            "</div>";
                                        }

                                    echo "</div>";
                                        
                                    }
                                ?>
                        </div>
                    </div>

                <hr class="receipt-divider">

                <div class="receipt-item">
                    <span>Subtotal</span>
                    <span>$<?php echo number_format($summary['subtotal'], 2); ?></span>
                </div>
                <div class="receipt-item">
                    <span>Tax</span>
                    <span>$<?php echo number_format($summary['tax'], 2); ?></span>
                </div>
                <div class="receipt-item">
                    <span>Tip</span>
                    <span>$<?php echo number_format($summary['tip'], 2); ?></span>
                </div>

                <hr class="receipt-divider">

                <div class="receipt-total">
                    <span>Total</span>
                    <span>$<?php echo number_format($summary['total'], 2); ?></span>
                </div>
            </div>

            <!-- Return Button -->
            <div class="return-button-container">
                <a href="home2.php" class="btn btn-primary">Return to Home</a>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>
