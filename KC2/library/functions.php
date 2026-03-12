<?php

    if (!isset($_SESSION['order'])) {
        $_SESSION['order'] = [];
    }

    if (isset($_POST['order_submit']) || isset($_POST['add_to_bag'])) {
        foreach ($_POST['select'] as $item) {
            if ($item == 'small_1') {
                $price = 4.00;
                $size = 'Small';
                $id = 1;
            } elseif ($item == 'medium_1') {
                $price = 5.00;
                $size = 'Medium';
                $id = 1;
            } elseif ($item == 'large_1') {
                $price = 6.00;
                $size = 'Large';
                $id = 1;
            } elseif ($item == 'small_2') {
                $price = 4.00;
                $size = 'Small';
                $id = 2;
            } elseif ($item == 'large_2') {
                $price = 5.00;
                $size = 'Large';
                $id = 2;
            } elseif ($item == 'small_3') {
                $price = 4.00;
                $size = 'Small';
                $id = 3;
            } elseif ($item == 'medium_3') {
                $price = 5.00;
                $size = 'Medium';
                $id = 3;
            } elseif ($item == 'large_3') {
                $price = 6.00;
                $size = 'Large';
                $id = 3;
            } elseif ($item == 'small_4') {
                $price = 4.50;
                $size = 'Small';
                $id = 4;
            } elseif ($item == 'medium_4') {
                $price = 5.50;
                $size = 'Medium';
                $id = 4;
            } elseif ($item == 'large_4') {
                $price = 6.50;
                $size = 'Large';
                $id = 4;
            } else {
                $price = null;
                $id = null;
            }

                if (isset($_POST['pick'])) {
                    $ingredients = implode("*", $_POST['pick']);
                } else {
                    $ingredients = "not available";
                }  

                if(isset($_POST['add' . $id]) && !empty($_POST['add' . $id]) && is_array($_POST['add' . $id])) {
                    foreach ($_POST['add' . $id] as $add_on) {
                        $price += 0.50;
                    } 
                    $add_ons = implode("*", $_POST['add' . $id]);  
                } else {
                    $add_ons = "not available";
                }


                $_SESSION['order'][] = [
                    'item_id' => $id,
                    'size' => $size,
                    'item_price' => floatval($price),
                    'ingredients' => $ingredients ?? [],
                    'add_ons' => $add_ons ?? []
                ];

            }

            if (isset($_POST['order_submit'])) {
                header("Location: checkout.php");
                exit();
            } elseif (isset($_POST['add_to_bag'])) {
                header("Location: bag.php");
                exit();
            }
        };

?>