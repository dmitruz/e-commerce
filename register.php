<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "eusedstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Sanitize user input
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['pass']);

    // Check if the email already exists
    $sql_check = "SELECT email FROM users WHERE email='$email'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Email exists
        echo "This email is already registered. Please <a href='login.php'>log in</a> instead.";
    } else {
        // Hash the password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // SQL query to insert the user
        $sql = "INSERT INTO users (first_name, last_name, email, pass, reg_date)
                VALUES ('$first_name', '$last_name', '$email', '$hashed_pass', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Log the user in by storing the user information in the session
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_name'] = $first_name . ' ' . $last_name;

            // Redirect to the homepage
            header("Location: index.php");
            exit();  // Stop further execution after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>