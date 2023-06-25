<?php

if (isset($_POST['login'])) {

    $username = $_POST['username'];
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

    // Retrieve user from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            
            session_start();
            $_SESSION['loggedin'] = true;
            
            $msg = "You are logged in sucessfully";
            header("Location: views/dashboard.php?msg=" . urlencode($msg));
            exit;

        } else {

            $error = "Invalid username or password";
            header("Location: index.php?error=" . urlencode($error));

        }
    } else {

        $error = "Invalid username or password";
        header("Location: index.php?error=" . urlencode($error));

    }

    // Close the database connection
    $conn->close();
}
?>

