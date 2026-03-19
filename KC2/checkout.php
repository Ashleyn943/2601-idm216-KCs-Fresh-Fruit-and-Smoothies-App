<?php
    session_start();
    require_once(__DIR__ . '/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tip'])) {
        $tipValue = $_POST['tip'] === 'custom' ? 0 : floatval($_POST['tip']);
        $_SESSION['tip_value'] = $tipValue;
        echo json_encode(['success' => true, 'tip' => $tipValue]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_summary'])) {
        $_SESSION['summary'] = [
            'subtotal' => floatval($_POST['subtotal']),
            'tax'      => floatval($_POST['tax']),
            'tip'      => floatval($_POST['tip_amount']),
            'total'    => floatval($_POST['total'])
        ];
        exit;
    }

    $tipValue = $_SESSION['tip_value'] ?? 0;
    $subtotal = 0;
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - KC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">

        <!-- Header -->
        <div class="page-header">
            <a href="bag.php" class="back-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1 class="page-title">CHECKOUT</h1>
            <div style="width: 45px;"></div>
        </div>

        <!-- Checkout Form -->
        <div class="checkout-content">

            <!-- Order Summary -->
            <div class="order-summary-section">
                <div class="order-summary">
                    <div class="summary-title">ORDER SUMMARY</div>
                        <div class="summary-item" style="display: block;">
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
                                        
                                        $subtotal += floatval($row['item_price']) * intval($row['quantity']);
                                    }
                                ?>
                        </div>
            
                    <hr class="summary-divider">
                        <?php
                            $tip = $tipValue / 100 * $subtotal;
                            $tax = $subtotal * 0.08; //given tax rate of 8%
                            $total = $subtotal + $tax + $tip;
                        ?>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="summary-subtotal" data-subtotal="<?php echo $subtotal; ?>">
                            $<?php echo number_format($subtotal, 2); ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span>Tax</span>
                        <span>
                            $<?php echo number_format($tax, 2); ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span>Tip</span>
                        <span id="summary-tip">
                            $<?php echo number_format($tip, 2); ?>
                        </span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span id="summary-total">
                            $<?php echo number_format($total, 2); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pick-up Time -->
            <div class="form-section">
                <label class="form-label">PICK-UP TIME</label>
                <div class="radio-group">
                    <label class="radio-option" id="asapOption">
                        <input type="radio" name="pickup-time" class="radio-input" value="asap" required>
                        <div>
                            <div class="radio-label">ASAP (10-15 minutes)</div>
                        </div>
                        <div class="radio-circle"></div>
                    </label>
                    <label class="radio-option" id="laterOption">
                        <input type="radio" name="pickup-time" class="radio-input" value="later">
                        <div>
                            <div class="radio-label">Schedule for later</div>
                            <div class="radio-sublabel" id="scheduledTimeDisplay">Choose a time</div>
                        </div>
                        <div class="radio-circle"></div>
                    </label>
                </div>
            </div>

            <!-- Pick-up Name -->
            <div class="form-section">
                <label class="form-label">PICK-UP NAME</label>
                <input type="text" class="text-input" id="pickupNameInput" placeholder="Name here" required>
            </div>

            <!-- Tip -->
            <div class="form-section">
                <label class="form-label">LEAVE A TIP FOR KC!</label>
                <div class="tip-buttons">
                        <label class="tip-button">
                            <input type="checkbox" name="tip" class="tip-input" id="custom" value="custom">
                            Custom
                        </label>
                        <label class="tip-button">
                            <input type="checkbox" name="tip" class="tip-input" value="15">
                            15%
                        </label>
                        <label class="tip-button">
                            <input type="checkbox" name="tip" class="tip-input" value="20">
                            20%
                        </label>
                </div>
            </div>

            <div>
                <p id="tips" style="display:none"></p>
            </div>

            <!-- Payment Method -->
            <div class="form-section">
                <label class="form-label">PAYMENT METHOD</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="payment" class="radio-input" value="credit" disabled>
                        <div class="payment-option">
                            <img src="checkout_images/credit-card.png" alt="Credit Card" class="payment-icon-img">
                            <div class="radio-label">Credit Card</div>
                        </div>
                        <div class="radio-circle"></div>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="payment" class="radio-input" value="apple">
                        <div class="payment-option">
                            <img src="checkout_images/apple-pay.png" alt="Apple Pay" class="payment-icon-img">
                            <div class="radio-label">Apple Pay</div>
                        </div>
                        <div class="radio-circle"></div>
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="payment" class="radio-input" value="venmo" disabled>
                        <div class="payment-option">
                            <img src="checkout_images/venmo.png" alt="Venmo" class="payment-icon-img">
                            <div class="radio-label">Venmo</div>
                        </div>
                        <div class="radio-circle"></div>
                    </label>
                </div>
            </div>

            <!-- Confirm Button -->
            <div class="checkout-button-section">
                <button id="confirm-pay-btn" class="btn btn-primary btn-full" disabled>Confirm and Pay</button>
            </div>
        </div>
    </div>

    <!-- Time Selection Modal -->
    <div class="modal-overlay" id="timeModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">×</button>
            <h2 class="modal-title">Schedule for later</h2>
            <div class="modal-location">
                <svg class="location-icon" viewBox="0 0 24 24" width="16" height="16">
                    <path fill="#e07856" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                <span>33rd St. & Lancaster Walk</span>
            </div>
            <div class="time-options">
                <label class="time-option">
                    <input type="radio" name="time-slot" class="time-radio" value="11:30 AM">
                    <span class="time-circle"></span>
                    <span class="time-label">11:30 AM</span>
                </label>
                <label class="time-option">
                    <input type="radio" name="time-slot" class="time-radio" value="11:45 AM">
                    <span class="time-circle"></span>
                    <span class="time-label">11:45 AM</span>
                </label>
                <label class="time-option">
                    <input type="radio" name="time-slot" class="time-radio" value="12:00 PM">
                    <span class="time-circle"></span>
                    <span class="time-label">12:00 PM</span>
                </label>
                <label class="time-option">
                    <input type="radio" name="time-slot" class="time-radio" value="12:15 PM">
                    <span class="time-circle"></span>
                    <span class="time-label">12:15 PM</span>
                </label>
                <label class="time-option">
                    <input type="radio" name="time-slot" class="time-radio" value="12:30 PM">
                    <span class="time-circle"></span>
                    <span class="time-label">12:30 PM</span>
                </label>
            </div>
            <button class="btn btn-primary btn-full" id="confirmTime">Confirm</button>
        </div>
    </div>

    <!-- Apple Pay Modal -->
    <div class="modal-overlay" id="applePayModal">
        <div class="applepay-modal">
            <div class="applepay-header">
                <img src="checkout_images/apple-vector.svg" alt="Apple Pay" class="applepay-logo">
                <span class="applepay-text">Pay</span>
            </div>
            <div class="payment-card-section">
                <div class="payment-card">
                    <img src="checkout_images/visa-logo.png" alt="Visa" class="card-logo">
                    <div class="card-info">
                        <div class="card-name">VISA...</div>
                        <div class="card-number">xxxxxxxxx</div>
                    </div>
                    <div class="card-last-four">xxxx 1234</div>
                    <span class="chevron-right">›</span>
                </div>
            </div>
            <div class="change-payment-button">
                <span>Change Payment Method</span>
                <span class="chevron-right">›</span>
            </div>
            <div class="payment-total-section">
                <div class="payment-merchant">Pay KC's Fresh Fruit & Smoothies</div>
                <div class="payment-amount"><?php echo '$' . number_format($total, 2); ?></div>
                <span class="chevron-right">›</span>
            </div>
            <div class="confirm-section" id="applePayConfirm">
                <img src="checkout_images/confirm-button.png" alt="Confirm" class="confirm-icon">
                <div class="confirm-text">Confirm with Side Button</div>
            </div>
        </div>
    </div>

    <script src="app.js"></script>
    <script>
        document.querySelectorAll('input[name="tip"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    //Unselecting tip/Reset tip to 0 
                    const formData = new FormData();
                    formData.append('tip', 0);
                    fetch('', { method: 'POST', body: formData })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('tips').textContent = '';
                                document.getElementById('tips').dataset.tip = '';
                                const subtotal = parseFloat(document.getElementById('summary-subtotal').dataset.subtotal);
                                const tax = subtotal * 0.08;
                                document.getElementById('summary-tip').textContent = '$0.00';
                                document.getElementById('summary-total').textContent = '$' + (subtotal + tax).toFixed(2);
                            }
                        });
                    return;
                }

                let tipValue = this.value;
                    if (tipValue === 'custom') {
                        const current = document.getElementById('tips').dataset.tip || '';
                        const input = prompt("Enter your custom tip percentage: %", current);

                        if (input === null) {
                            this.checked = false;
                            return;
                        }

                        const parsed = parseFloat(input);
                            if (isNaN(parsed) || parsed < 0) {
                            alert("Please enter a valid tip percentage.");
                            this.checked = false;
                            return;
                        }

                        tipValue = parsed;

                        this.closest('label').childNodes[1].textContent = ` Custom (${parsed}%)`;
                        }
                        
                        const formData = new FormData();
                            
                        formData.append('tip', tipValue);

                        fetch('', { method: 'POST', body: formData })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('tips').textContent = `Tip applied: ${data.tip}%`;
                                    document.getElementById('tips').dataset.tip = data.tip; // store for pre-fill

                                    const subtotal = parseFloat(document.getElementById('summary-subtotal').dataset.subtotal);
                                    const tax      = subtotal * 0.08;
                                    const tip      = subtotal * (data.tip / 100);
                                    const total    = subtotal + tax + tip;

                                    document.getElementById('summary-tip').textContent   = '$' + tip.toFixed(2);
                                    document.getElementById('summary-total').textContent = '$' + total.toFixed(2);

                                }
                            });
            });
        });

        document.getElementById('confirm-pay-btn').addEventListener('click', function () {
            const subtotal = parseFloat(document.getElementById('summary-subtotal').dataset.subtotal) || 0;
            const tax      = subtotal * 0.08;
            const tipText  = document.getElementById('summary-tip').textContent.replace('$', '').trim();
            const tip      = parseFloat(tipText) || 0;
            const total    = parseFloat(document.getElementById('summary-total').textContent.replace('$', '').trim()) || 0;

            console.log('Saving:', subtotal, tax, tip, total);

            const summaryData = new FormData();
            summaryData.append('save_summary', true);
            summaryData.append('subtotal', subtotal.toFixed(2));
            summaryData.append('tax',      tax.toFixed(2));
            summaryData.append('tip_amount',      tip.toFixed(2));
            summaryData.append('total',    total.toFixed(2));

            fetch('', { method: 'POST', body: summaryData })
                .then(() => {
                    window.location.href = 'confirmation.php';
                })
                .catch(() => {
                    window.location.href = 'confirmation.php'; // redirect even if save fails
                });
        });
    </script>
</body>
</html>
