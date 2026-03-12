<?php
session_start();
require_once('db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id         = intval($_GET['id']);
$edit_index = intval($_GET['edit']);

// Redirect if invalid index
if (!isset($_SESSION['order'][$edit_index])) {
    header('Location: bag.php');
    exit();
}

$existing            = $_SESSION['order'][$edit_index];
$prefill_size        = $existing['size'] ?? '';
$prefill_ingredients = isset($existing['ingredients']) && $existing['ingredients'] !== 'not available'
    ? explode('*', $existing['ingredients'])
    : [];
$prefill_addons      = isset($existing['add_ons']) && $existing['add_ons'] !== 'not available'
    ? explode('*', $existing['add_ons'])
    : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select'])) {
    $size = $_POST['select'];

    switch ($size) {
        case 'small_' . $id:
            $stmt = $connection->prepare("SELECT s_price FROM idm216_prices WHERE item_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $priceValue = $stmt->get_result()->fetch_assoc()['s_price'];
            break;
        case 'medium_' . $id:
            $stmt = $connection->prepare("SELECT m_price FROM idm216_prices WHERE item_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $priceValue = $stmt->get_result()->fetch_assoc()['m_price'];
            break;
        case 'large_' . $id:
            $stmt = $connection->prepare("SELECT l_price FROM idm216_prices WHERE item_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $priceValue = $stmt->get_result()->fetch_assoc()['l_price'];
            break;
        default:
            $priceValue = 0;
    }

    $ingredients = ($id === 1)
        ? (isset($_POST['pick']) ? implode("*", $_POST['pick']) : 'not available')
        : 'not available';

    $add_on_price = 0;
    $add_ons      = "not available";
    if ($id != 2 && isset($_POST['add' . $id])) {
        $add_ons      = implode("*", $_POST['add' . $id]);
        $add_on_price = count($_POST['add' . $id]) * 0.50;
    }

    // Overwrite the existing item
    $_SESSION['order'][$edit_index] = [
        'item_id'     => $id,
        'size'        => $size,
        'item_price'  => floatval($priceValue + $add_on_price),
        'base_price'  => floatval($priceValue + $add_on_price),
        'ingredients' => $ingredients,
        'add_ons'     => $add_ons,
        'quantity'    => intval($existing['quantity'] ?? 1)
    ];

    header('Location: bag.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - KC</title>
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
                    <a href="bag.php" class="back-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <h1 class="page-title">Edit <?php echo htmlspecialchars($row['name']); ?></h1>
                </div>

                <!-- Smoothie Image -->
                <div class="smoothie-display">
                    <?php
                    switch ($row['id']) {
                        case 1: echo '<img src="Smoothie_images/customCROP.png" alt="Custom Smoothie">'; break;
                        case 2: echo '<img src="Smoothie_images/fruit_saladCROP.png" alt="Fruit Salad">'; break;
                        case 3: echo '<img src="Smoothie_images/pb_bananaCROP.png" alt="PB Banana Smoothie">'; break;
                        case 4: echo '<img src="Smoothie_images/taroCROP.png" alt="Taro Smoothie">'; break;
                    }
                    ?>
                </div>

                <!-- Customization Form -->
                <div class="customization-panel">
                    <form method='POST' action='edit_item.php?id=<?php echo $row['id']; ?>&edit=<?php echo $edit_index; ?>'>

                        <!-- Size Selection -->
                        <section class="section">
                            <h2 class="section-title">Size</h2>
                            <div class="size-options">
                                <label class="size-button">
                                    <input type="radio" name="select" class="size-radio" 
                                        value="small_<?php echo $row['id']; ?>"
                                        <?php echo ($prefill_size === 'small_' . $row['id']) ? 'checked' : ''; ?>>
                                    <img src="size_images/size-small.png" alt="Small" class="size-cup-image small">
                                    <span class="size-label">Small</span>
                                    <span class="size-price"><?php echo $row['s_price']; ?></span>
                                </label>
                                <?php if ($row['m_price'] !== null): ?>
                                    <label class="size-button">
                                        <input type="radio" name="select" class="size-radio" 
                                            value="medium_<?php echo $row['id']; ?>"
                                            <?php echo ($prefill_size === 'medium_' . $row['id']) ? 'checked' : ''; ?>>
                                        <img src="size_images/size-medium.png" alt="Medium" class="size-cup-image medium">
                                        <span class="size-label">Medium</span>
                                        <span class="size-price"><?php echo $row['m_price']; ?></span>
                                    </label>
                                <?php endif; ?>
                                <label class="size-button">
                                    <input type="radio" name="select" class="size-radio" 
                                        value="large_<?php echo $row['id']; ?>"
                                        <?php echo ($prefill_size === 'large_' . $row['id']) ? 'checked' : ''; ?>>
                                    <img src="size_images/size-large.png" alt="Large" class="size-cup-image large">
                                    <span class="size-label">Large</span>
                                    <span class="size-price"><?php echo $row['l_price']; ?></span>
                                </label>
                            </div>
                        </section>

                        <!-- Ingredients (Custom Smoothie only) -->
                        <?php if ($row['id'] == 1): ?>
                            <section class="section">
                                <h2 class="section-title">Ingredients</h2>
                                <p class="section-subtitle">Select up to 3</p>
                                <div class="ingredients-grid">
                                    <?php
                                    $ingredients_list = [
                                        'Mixed Berry' => 'mixberries',
                                        'Pineapple'   => 'pineapple',
                                        'Strawberry'  => 'strawberry',
                                        'Mango'       => 'mango',
                                        'Banana'      => 'banana',
                                        'Spinach'     => 'spinach',
                                        'Kale'        => 'kale'
                                    ];
                                    foreach ($ingredients_list as $name => $img): ?>
                                        <label class="ingredient-button">
                                            <input type="checkbox" class="ingredient-checkbox" name="pick[]" value="<?php echo $name; ?>"
                                                <?php echo in_array($name, $prefill_ingredients) ? 'checked' : ''; ?>>
                                            <img src="ingredients/<?php echo $img; ?>.png" alt="<?php echo $name; ?>">
                                            <span><?php echo $name; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Add-Ons -->
                        <?php if ($row['id'] != 2): ?>
                            <section class="section">
                                <h2 class="section-title">Add-Ons</h2>
                                <p class="section-subtitle">Optional</p>
                                <div class="addons-list">
                                    <label class="addon-item">
                                        <input type="checkbox" class="addon-checkbox" 
                                            name="add<?php echo $row['id']; ?>[]" value="Yogurt"
                                            <?php echo in_array('Yogurt', $prefill_addons) ? 'checked' : ''; ?>>
                                        <div class="addon-info">
                                            <span class="addon-name">Yogurt</span>
                                            <span class="addon-price">+$0.50</span>
                                        </div>
                                        <span class="custom-checkbox"></span>
                                    </label>
                                    <label class="addon-item">
                                        <input type="checkbox" class="addon-checkbox" 
                                            name="add<?php echo $row['id']; ?>[]" value="Whey Protein"
                                            <?php echo in_array('Whey Protein', $prefill_addons) ? 'checked' : ''; ?>>
                                        <div class="addon-info">
                                            <span class="addon-name">Whey Protein</span>
                                            <span class="addon-price">+$0.50</span>
                                        </div>
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Price and Actions -->
                        <div class="bottom-section">
                            <div class="price-quantity">
                                <span class="total-price">$0.00</span>
                            </div>
                            <div class="action-buttons">
                                <a href="bag.php" class="btn btn-secondary">Cancel</a>
                                <input type="submit" name="save_changes" value="Save Changes" class="btn btn-primary">
                            </div>
                        </div>

                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>