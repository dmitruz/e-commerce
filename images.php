<?php
$conn = new mysqli("localhost", "root", "", "image");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error")
}
if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);

    // Check if the uploads folder exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);  // Create uploads folder if it doesn't exist
    }

    // Upload image to the uploads folder
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Save image file path to the database
        $sql = "INSERT INTO product_images (product_name, image_path) VALUES ('$product_name', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded successfully and path saved in the database.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading the image.";
    }
}

$conn->close();
?>