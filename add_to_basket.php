<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
} else {
    echo "Product ID not received.";
    exit();
}

// Initialize cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "eusedstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details from the product_images table
$sql = "SELECT id, product_name, price FROM product_images WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if product exists in the product_images table
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Check if product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If it exists, increase the quantity
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        // Add new product to the cart
        $_SESSION['cart'][$product_id] = [
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    }

    // Optionally, add the product to the `products` table for future reference
    $sql_insert = "INSERT INTO products (product_name, price) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sd", $product['product_name'], $product['price']);
    $stmt_insert->execute();
    $stmt_insert->close();

} else {
    echo "Product not found in product_images table.";
    exit();
}

$stmt->close();
$conn->close();

// Redirect to the index page or the cart
header("Location: index.php");
exit();
?>


