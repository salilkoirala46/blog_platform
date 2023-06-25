<?php

// Check if the form is submitted
if (isset($_POST['registration'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Connect to the database
    $host = 'mysql';
    $database_username = 'your_username';
    $database_password = 'your_password';
    $database = 'your_database';

    $conn = new mysqli($host, $database_username, $database_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";



    if ($conn->query($sql) === TRUE) {
        
        $message = "User registered successfully";
        header("Location: index.php?message=" . urlencode($message));
    
    } else {
        
        $error = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: index.php?error=" . urlencode($error));
        exit;

    }

    // Close the database connection
    $conn->close();
}
?>
