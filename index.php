
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === "test2@test.com") {
    // Set a cookie for the admin user
    setcookie("is_admin", "true", time() + (86400 * 30), "/"); // Set a cookie for 30 days
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header with Navigation -->
     <?php include 'header.php'; ?>

    <!-- Main Content Area -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar and Main Content -->
                <!-- Sidebar with Categories -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar custom-sidebar">
                <div class="position-sticky">
                    <h5 class="sidebar-heading">Catalog</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">All</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?category=Fridge">Fridges</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?category=Microwave">Microwaves</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?category=Washing Machine">Washing Machines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?category=TV">TVs</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Section for Images -->
            <main class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <div class="row">
                        <?php
                        // Database connection
                    $conn = new mysqli("localhost", "root", "", "eusedstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected category from URL (if any)
$category = isset($_GET['category']) ? $_GET['category'] : '';
$category = $conn->real_escape_string($category);

// Query to get images from database based on category
if (!empty($category)) {
    // Filtering images by product name that matches the selected category
    $sql = "SELECT id, product_name, description, price, image_path FROM product_images WHERE product_name LIKE '%$category%'";
} else {
    // If no category is selected, show all images
    $sql = "SELECT id, product_name, description, price, image_path FROM product_images";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-12 col-sm-6 col-lg-3 mb-4 product-container">'; // Added a new class "product-container"
        echo '<img src="'.$row['image_path'].'" class="img-fluid" alt="'.$row['product_name'].'">';
        echo '<div class="product-details">'; // Added a wrapper for product details
        echo '<h5>'.$row['product_name'].'</h5>';
        echo '<p class="description">'.$row['description'].'</p>'; // Added "description" class
        echo '<p class="price"><strong>Price: £'.$row['price'].'</strong></p>'; // Added "price" class
        echo '<a href="product_details.php?id='.$row['id'].'" class="btn btn-primary">View Details</a>'; // New button
        
        // Add to Basket and Delete buttons inside the same form with flexbox for alignment
        echo '<form action="add_to_basket.php" method="POST" class="d-flex justify-content-between">'; 
        echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
        // Add to Basket Button
        echo '<input type="submit" class="btn btn-success mr-2" value="Add to Basket">';
        // Delete Button
        echo '<form action="delete.php" method="POST" class="d-inline">';
        echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
        echo '<input type="submit" class="btn btn-danger ml-2" value="Delete">';
        echo '</form>';
        echo '</form>';
        echo '</div>'; // Close the product-details div
        echo '</div>'; // Close the product-container div
    }
} else {
    echo "No products found.";
}

$conn->close();
                        ?>
                    </div>
                </div>
                    </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

