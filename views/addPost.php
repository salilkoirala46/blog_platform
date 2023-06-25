<?php
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

if (isset($_POST['add_post'])) {

    $title = $_POST['title'];
    $body = $_POST['body'];

    // Create an instance of the PostManager class
    $post = new Post($conn);

    // Insert the post into the database
    $postId = $post->createPost($title, $body);

    if ($postId) {

        $msg="Post created successfully";
        header("Location: dashboard.php?message=" . urlencode($msg));

    } else {

        $error="Failed to create the post.";
        header("Location: dashboard.php?error=" . urlencode($error));

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
    <h1>Create Post</h1>
    <form method="post" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <br><br>
        <label for="body">Body:</label>
        <textarea name="body" id="body" rows="5" required></textarea>
        <br><br>
        <input type="submit" value="Submit" name="add_post">
    </form>
</body>
</html>
