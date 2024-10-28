<?php
// Check if a product ID is provided via POST
if (isset($_POST['product_id'])) {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "eusedstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the product ID and sanitize it
    $product_id = $conn->real_escape_string($_POST['product_id']);

    // Delete the product from the database
    $sql = "DELETE FROM product_images WHERE id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully.";
        // Redirect to index.php after deletion
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No product ID specified.";
}
?>