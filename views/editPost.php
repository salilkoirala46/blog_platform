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

// Create an instance of the PostManager class
$post = new Post($conn);
$postDetail = $post->getPostById($_GET['id']);

if (isset($_POST['edit_post'])) {

    $title = $_POST['title'];
    $body = $_POST['body'];
    $id=$_POST['id'];


    // Insert the post into the database
    $postId = $post->updatePost($id, $title, $body);

    if ($postId) {

        $msg="Post updated successfully.";
        header("Location: dashboard.php?message=" . urlencode($msg));

    } else {

        $error="Failed to update the post.";
        header("Location: dashboard.php?error=" . urlencode($error));

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $postDetail['id'];?>">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $postDetail['title']; ?>"required>
        <br><br>
        <label for="body">Body:</label>
        <textarea name="body" id="body" rows="5"  required><?php echo $postDetail['body']; ?></textarea>
        <br><br>
        <input type="submit" value="Submit" name="edit_post">
    </form>
</body>
</html>
