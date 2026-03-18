<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KC's Home - Fresh Fruit and Smoothies</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container index">
        <!-- Header -->
        <div class="header">
            <div class="welcome-text">
                <p>Welcome back, Guest</p>
                <h1>What are you craving today?</h1>
                <div class="location">
                    <svg class="location-icon" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                    <span>33rd St. & Lancaster Walk</span>
                </div>
            </div>
            <div class="profile-icon">
                <img src="person-profile.jpeg" alt="person icon">
            </div>
        </div>

        <!-- Order Badge -->
        <!-- <a href="confirmation.html" class="order-badge">ORDER #42</a> -->

        <!-- Products Grid -->
        <div class="products">
            <?php
            $result = mysqli_query($connection, "SELECT * FROM idm216_items items INNER JOIN idm216_images item_images ON items.id = item_images.id INNER JOIN idm216_prices ip ON items.id = ip.item_id");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <a href="customize.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="product-card">
                    <div class="product-card-inner">
                        <?php
                        switch ($row['id']) {
                            case 1:
                                echo '<span class="badge most-popular">Most Popular</span>';
                                break;
                            case 2:
                                // do nothing
                                break;
                            case 3:
                                echo '<span class="badge campus-pick">Campus Pick</span>';
                                break;
                            case 4:
                                echo '<span class="badge exclusive">Exclusive</span>';
                                break;
                        }
                        ?>
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                    </div>
                    <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                </a>
            <?php
            }
            ?>
        </div>

        <!-- Navigation Bar -->
        <?php include 'nav.php'; ?>
    </div>

    <script src="app.js"></script>
</body>

</html>