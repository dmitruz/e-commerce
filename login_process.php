<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "eusedstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['pass'];

    $sql = "SELECT user_id, first_name, last_name, email, pass FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($pass, $row['pass'])) {
            // Store user details in the session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = strtoupper(substr($row['first_name'], 0, 1)) . strtoupper(substr($row['last_name'], 0, 1));
            $_SESSION['user_email'] = $row['email'];  // Store the email for later reference

            // Check if the logged-in user is the admin
            if ($email === "test2@test.com") {
                $_SESSION['is_admin'] = true;

                // Set an "is_admin" cookie that lasts for 30 days
                setcookie("is_admin", "true", time() + (86400 * 30), "/", "", false, true);
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email address.";
    }

    $conn->close();
}
?>
