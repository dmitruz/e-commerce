<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="5;url=index.php">
</head>
<body>
<?php

session_start();

  $conn = new mysqli("localhost", "root", "", "eusedstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// Check if the cart is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in the session
    $total_price = 0;

    // Calculate total price
    foreach ($_SESSION['cart'] as $product) {
        $total_price += $product['price'] * $product['quantity'];
    }

    // Insert the order into the 'orders' table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, total_amount, order_status) VALUES (?, NOW(), ?, 'Pending')");
    $stmt->bind_param("id", $user_id, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the generated order ID
    $stmt->close();

    // Insert each cart item into the 'order_items' table
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $stmt->bind_param("iisid", $order_id, $product_id, $product['name'], $product['quantity'], $product['price']);
        $stmt->execute();
    }
    $stmt->close();

    // Clear the shopping cart
    unset($_SESSION['cart']);

    // Display the order confirmation
    echo "<div class='container text-center mt-5'>";
    echo "<h3>Thank you for your order!</h3>";
    echo "<p>Your Order Number is <strong>#" . $order_id . "</strong></p>";
    echo "<a href='index.php' class='btn btn-primary mt-3'>Go to Main Page</a>";
    echo "</div>";
} else {
    echo "<div class='container text-center mt-5'><p>Your cart is empty.</p></div>";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>