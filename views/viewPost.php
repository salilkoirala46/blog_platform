<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

    header("Location: userLogin.php");
    exit;

}?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Detail</title>
</head>
<body>
    <h1>Post Detail</h1>

    <!-- show success and error message after adding, editing and deleting post -->
    <?php if (isset($_GET['message'])): ?>
        <div><?php echo $_GET['message']; ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div><?php echo $_GET['error']; ?></div>
    <?php endif; ?>

    <?php
    // Include the PostManager class
    require_once '../classes/Post.php';
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


    $post = new Post($conn);
    $comment = new Comment($conn);

    // Retrieve all posts from the database
    $postID = $_GET['id'];
    $posts = $post->getPostById($_GET['id']);

    if (!empty($posts)) { ?>

            <h2><?php echo $posts['title']; ?></h2>
            <p><?php echo $posts['body']; ?></p>
            <a href="editPost.php?id=<?php echo $posts['id']?>"><button type="button" name="edit_post">Edit post</button></a>
            
            <!-- Display the comment form -->

            <h3>Add comment</h3>
            <form id="comment-form" method="POST" action="#">
            <input type="hidden" name="post_id" value="<?php echo $postID ?>">
            User Name: <input type="text" name="user_name"><br><br>
            Comment: <textarea name="comment_body"></textarea><br>
            <input type="submit" name="submit" value="Submit">
            </form>
        	
            <div id="comments-section"></div>

       <?php 
    	    
    } else {

        echo '<p>No posts found.</p>';

    }
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle comment form submission
    $('#comment-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get form data
        var postID = '<?php echo $postID; ?>';
        var userName = $('input[name="user_name"]').val();
        var commentBody = $('textarea[name="comment_body"]').val();

        // Send AJAX request to createComment.php
        $.ajax({
            type: 'POST',
            url: 'createComment.php',
            data: {
                post_id: postID,
                user_name: userName,
                comment_body: commentBody
            },
            success: function(response) {
                loadComments(postID);
                // Clear the comment form
                $('input[name="user_name"]').val('');
                $('textarea[name="comment_body"]').val('');
            },
            error: function(xhr, status, error) {
                console.log(error); 
            }
        });
    });

    function loadComments(postID) {
        $.ajax({
            type: 'GET',
            url: 'getComments.php',
            data: {
                post_id: postID
            },
            success: function(response) {
                $('#comments-section').html(response);
            },
            error: function(xhr, status, error) {
                console.log(error); 
            }
        });
    }

    // Load comments on page load
    loadComments('<?php echo $postID; ?>');
});
</script>

</body>
</html>