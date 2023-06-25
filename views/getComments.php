<?php

// Include the CommentManager class and establish a database connection
require_once '../classes/Comment.php';

$hostname = 'mysql';
$port = 3306; 
$username = 'your_username';
$password = 'your_password';
$database = 'your_database';

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$commentManager = new Comment($conn);

// Get the post ID from the AJAX request
$postID = $_GET['post_id'];

// Retrieve the comments for the post from the database
$comments = $commentManager->getCommentsByPostID($postID);

echo '<h2>Comments</h2>';
if (!empty($comments)) {
    // Loop through the comments and generate HTML output
    foreach ($comments as $comment) {
        $userName = $comment['user_name'];
        $commentBody = $comment['body'];
        $createdAt = $comment['created_at'];

        // Generate HTML output for each comment
        echo '<div class="comment">';
        echo '<strong>' . $userName . '</strong>';
        echo '<p>' . $commentBody . '</p>';
        echo '<span>' . $createdAt . '</span>';
        echo '</div>';
    }
} else {
    // No comments found for the post
    echo '<p>No comments found.</p>';
}
