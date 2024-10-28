<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = intval($_POST['quantity']);

        // Check if the cart session exists and the product is in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // If the quantity is greater than 0, update it. Otherwise, remove the item from the cart.
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
}

// Redirect back to the cart page
header("Location: cart.php");
