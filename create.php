<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "eusedstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect and sanitize input data
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);

    // Move uploaded image to the images folder
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert product into the database
        $sql = "INSERT INTO product_images (product_name, description, price, image_path) 
                VALUES ('$product_name', '$description', '$price', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully.";
            header("Location: index.php"); // Redirect to main page after creation
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Create New Product</h1>
        <form action="create.php" method="post" enctype="multipart/form-data" class="bg-light p-5 border rounded">
            <!-- Product Name -->
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Enter product name" required>
            </div>
            
            <!-- Product Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter product description" required></textarea>
            </div>
            
            <!-- Product Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>
            
            <!-- Product Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (£)</label>
                <input type="number" id="price" name="price" class="form-control" min="0" step="0.01" placeholder="Enter product price" required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between">
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Add Product</button>
                
                <!-- Close Button (Redirect to index.php) -->
                <a href="index.php" class="btn btn-danger">Close</a>
                
                <!-- Cancel Button (Optional link to go back without adding) -->
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>