<?php
session_start();  

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h3>Your cart is empty.</h3>
        <a href="index.php" class="btn btn-secondary mt-3">Go to Main Page</a> <!-- Button to return to main page -->
    </div>
    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    exit();
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Your Cart</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th> <!-- Column for remove action -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                    <tr>
                        <td><?= $product['name']; ?></td>
                        <td>$<?= number_format($product['price'], 2); ?></td>
                        <td><?= $product['quantity']; ?></td>
                        <td>$<?= number_format($product['price'] * $product['quantity'], 2); ?></td>
                        <td>
                            <form action="remove_from_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total_price += $product['price'] * $product['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total: $<?= number_format($total_price, 2); ?></h4>
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
        <a href="index.php" class="btn btn-secondary">Go to Main Page</a> <!-- Button to return to main page -->
    </div>
        
    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

