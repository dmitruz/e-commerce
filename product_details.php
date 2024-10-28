<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "eusedstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id == 0) {
    echo "Invalid product ID.";
    exit();
}

// Fetch product details from database
// Fetch product details from database, including the id field
$sql = "SELECT id, product_name, description, price, image_path FROM product_images WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <?php include 'header.php'; ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Display the product image -->
                <img src="<?= $product['image_path']; ?>" class="img-product" alt="<?= $product['product_name']; ?>">
            </div>
            <div class="col-md-6">
                <h2><?= $product['product_name']; ?></h2>
                <p><?= $product['description']; ?></p>
                <p><strong>Price: £<?= $product['price']; ?></strong></p>
                
                <!-- Add to Basket button -->
      <form action="add_to_basket.php" method="POST" class="d-flex justify-content-between">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <input type="submit" class="btn btn-success mr-2" value="Add to Basket">
</form>

                <!-- Close button to go back to product list -->
                <a href="index.php" class="btn btn-secondary mt-3">Close</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>