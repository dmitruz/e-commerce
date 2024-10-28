<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "eusedstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve all products
$sql = "SELECT * FROM product_images";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Product List</h1>
    <a href="create.php" class="btn btn-dark mb-3">Add New Product</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['product_name']; ?></td>
                        <td><?= $row['description']; ?></td>
                        <td><?= $row['price']; ?></td>
                        <td><img src="<?= $row['image_path']; ?>" width="100" height="100" alt="<?= $row['product_name']; ?>"></td>
                        <td>
                            <a href="update.php?id=<?= $row['id']; ?>" class="btn btn-primary">Update</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>