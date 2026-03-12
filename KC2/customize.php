<?php
session_start();
require_once('db.php');

$id = intval($_GET['id']);

if (!isset($_SESSION['order'])) {
    $_SESSION['order'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select'])) {
    $size = isset($_POST['select']) ? $_POST['select'] : null;
        switch ($size) {
            case 'small_' . $id:
                $stmt = $connection->prepare("SELECT s_price FROM idm216_prices WHERE item_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $price_row = $result->fetch_assoc();
                $priceValue = $price_row['s_price'];
                break;
            case 'medium_' . $id:
                $stmt = $connection->prepare("SELECT m_price FROM idm216_prices WHERE item_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $price_row = $result->fetch_assoc();
                $priceValue = $price_row['m_price'];
                break;
            case 'large_' . $id:
                $stmt = $connection->prepare("SELECT l_price FROM idm216_prices WHERE item_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $price_row = $result->fetch_assoc();
                $priceValue = $price_row['l_price'];
                break;
            default:
                $priceValue = null;
        }
    if ($id === 1) {
        $ingredients = isset($_POST['pick']) ? implode("*", $_POST['pick']) : null;
    } else {
        $ingredients = "not available";
    }
    
    if ($id != 2) {
        $add_on_price = 0;
        if (isset($_POST['add' . $id])) {
            $add_ons = implode("*", $_POST['add' . $id]);
            $add_on_count = count($_POST['add' . $id]);
            $add_on_price = $add_on_count * 0.50;
        }
    } else {
        $add_on_price = 0;
        $add_ons = "not available";
    }

    $quantity = max(1, intval($_POST['quantity'] ?? 1));

    for ($i = 0; $i < $quantity; $i++) {
            $_SESSION['order'][] = [
                'item_id'     => $id,
                'size'        => $size,
                'item_price'  => floatval($priceValue + $add_on_price),
                'ingredients' => $ingredients,
                'add_ons'     => $add_ons
            ];
        }

    if (isset($_POST['order_submit'])) {
        header("Location: checkout.php");
        exit();
    } elseif (isset($_POST['add_to_bag'])) {
        header("Location: bag.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Smoothie - KC</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="background">
        <div class="container customization">
            <?php
            $result = mysqli_query($connection, "SELECT * 
                                                FROM idm216_items items 
                                                INNER JOIN idm216_images item_images ON items.id = item_images.id 
                                                INNER JOIN idm216_prices ip ON items.id = ip.item_id  
                                                WHERE items.id = $id");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <!-- Header -->
                <div class="header customize-header">
                    <a href="index.php" class="back-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <h1 class="page-title"><?php echo htmlspecialchars($row['name']); ?></h1>
                </div>
                <!-- Smoothie Image -->
                <div class="smoothie-display">
                    <?php
                    switch ($row['id']) {
                        case 1:
                            echo '<img src="Smoothie_images/customCROP.png" alt="Custom Smoothie">';
                            break;
                        case 2:
                            echo '<img src="Smoothie_images/fruit_saladCROP.png" alt="Fruit Salad">';
                            break;
                        case 3:
                            echo '<img src="Smoothie_images/pb_bananaCROP.png" alt="PB Banana Smoothie">';
                            break;
                        case 4:
                            echo '<img src="Smoothie_images/taroCROP.png" alt="Taro Smoothie">';
                            break;
                    }
                    ?>
                </div>
                <!-- Customization Form -->
                <div class="customization-panel">
                    <!-- Size Selection -->
                    <section class="section">
                        <h2 class="section-title">Size</h2>
                        <form method='POST' action='customize.php?id=<?php echo htmlspecialchars($row['id']); ?>'>
                            <div class="size-options">
                                <label class="size-button">
                                    <input type="radio" name="select" class="size-radio" value="small_<?php echo htmlspecialchars($row['id']); ?>">
                                    <img src="size_images/size-small.png" alt="Small" class="size-cup-image small">
                                    <span class="size-label">Small</span>
                                    <span class="size-price"><?php echo htmlspecialchars($row['s_price']); ?></span>
                                </label>
                                <?php if ($row['m_price'] !== null): ?>
                                    <label class="size-button">
                                        <input type="radio" name="select" class="size-radio" value="medium_<?php echo htmlspecialchars($row['id']); ?>">
                                        <img src="size_images/size-medium.png" alt="Medium" class="size-cup-image medium">
                                        <span class="size-label">Medium</span>
                                        <span class="size-price"><?php echo htmlspecialchars($row['m_price']); ?></span>
                                    </label>
                                <?php
                                endif;
                                ?>
                                <label class="size-button">
                                    <input type="radio" name="select" class="size-radio" value="large_<?php echo htmlspecialchars($row['id']); ?>">
                                    <img src="size_images/size-large.png" alt="Large" class="size-cup-image large">
                                    <span class="size-label">Large</span>
                                    <span class="size-price"><?php echo htmlspecialchars($row['l_price']); ?></span>
                                </label>
                            </div>
                        
                    </section>
                    <!-- Ingredients Selection -->
                    <?php if ($row['id'] == 1): ?>
                        <section class="section">
                            <h2 class="section-title">Ingredients</h2>
                            <p class="section-subtitle">Select up to 3</p>
                                <div class="ingredients-grid">
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Mixed Berry">
                                        <img src="ingredients/mixberries.png" alt="Mixed Berry">
                                        <span>Mixed Berry</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Pineapple">
                                        <img src="ingredients/pineapple.png" alt="Pineapple">
                                        <span>Pineapple</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Strawberry">
                                        <img src="ingredients/strawberry.png" alt="Strawberry">
                                        <span>Strawberry</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Mango">
                                        <img src="ingredients/mango.png" alt="Mango">
                                        <span>Mango</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Banana">
                                        <img src="ingredients/banana.png" alt="Banana">
                                        <span>Banana</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Spinach">
                                        <img src="ingredients/spinach.png" alt="Spinach">
                                        <span>Spinach</span>
                                    </label>
                                    <label class="ingredient-button">
                                        <input type="checkbox" class="ingredient-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="pick[]" value="Kale">
                                        <img src="ingredients/kale.png" alt="Kale">
                                        <span>Kale</span>
                                    </label>
                                </div>
                        </section>
                    <?php
                    endif;
                    ?>
                    <!-- Add-Ons -->
                    <?php if ($row['id'] != 2): ?>
                        <section class="section">
                            <h2 class="section-title">Add-Ons</h2>
                            <p class="section-subtitle">Optional</p>
                                <div class="addons-list">
                                    <label class="addon-item">
                                        <input type="checkbox" class="addon-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="add<?php echo htmlspecialchars($row['id']);?>[]" value="Yogurt">
                                        <div class="addon-info">
                                            <span class="addon-name">Yogurt</span>
                                            <span class="addon-price">+$0.50</span>
                                        </div>
                                        <span class="custom-checkbox"></span>
                                    </label>
                                    <label class="addon-item">
                                        <input type="checkbox" class="addon-checkbox <?php echo htmlspecialchars($row['id']); ?>" name="add<?php echo htmlspecialchars($row['id']);?>[]" value="Whey Protein">
                                        <div class="addon-info">
                                            <span class="addon-name">Whey Protein</span>
                                            <span class="addon-price">+$0.50</span>
                                        </div>
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </div>
                        </section>
                    <?php
                    endif;
                    ?>
                    <!-- Price and Actions -->
                    <div class="bottom-section">
                        <div class="price-quantity">
                            <span class="total-price">$0.00</span>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-button minus">−</button>
                                <span class="quantity">1</span>
                                <button type="button" class="quantity-button plus">+</button>
                            </div>
                            <input type="hidden" name="quantity" id="quantity-input" value="1">
                        </div>
                        <div class="action-buttons">
                            <input type="submit" name="add_to_bag" value="Add to Bag" class="btn btn-secondary"></input>
                            <input type="submit" name="order_submit" value="Checkout" class="btn btn-primary"></input>
                        </div>
                    </div>
                </div>
                        </form>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="app.js"></script>
</body>

</html>