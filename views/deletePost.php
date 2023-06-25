<?php

// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

    header("Location: userLogin.php");
    exit;
}

require_once '../classes/Post.php';
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

// Create an instance of the PostManager class
$post = new Post($conn);

// delete all posts from the database
if ($post->deletePost($_GET['id'])){

    $msg="Post delete successfully.";
    header("Location: dashboard.php?message=" . urlencode($msg));

} else {

    $error="Failed to delete post.";
    header("Location: dashboard.php?error=" . urlencode($error));

}

?>