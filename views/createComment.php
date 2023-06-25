<?php

// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

    header("Location: userLogin.php");
    exit;

}

// Include the CommentManager class and establish a database connection
require_once '../classes/Comment.php';

$hostname = 'mysql';
$port = 3306; 
$database_username = 'your_username';
$database_password = 'your_password';
$database = 'your_database';

$conn = new mysqli($hostname, $database_username, $database_password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$commentManager = new Comment($conn);

// Get the post ID, user name, and comment body from the AJAX request
$postID = $_POST['post_id'];
$userName = $_POST['user_name'];
$commentBody = $_POST['comment_body'];

// Insert the comment into the database
$result = $commentManager->createComment($postID, $userName, $commentBody);

if ($result) {
    // Comment added successfully
    echo 'success';
} else {
    // Failed to add comment
    echo 'error';
}
