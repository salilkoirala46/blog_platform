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
    <title>Post Listing</title>
</head>
<body>
    <h1>Post Listing</h1>
    
    <?php if (isset($_GET['message'])): ?>
        <div><?php echo $_GET['message']; ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div><?php echo $_GET['error']; ?></div>
    <?php endif; ?>


    <a href="/views/addPost.php"><button type="button" name="add_new_post">Add new post</button></a>

    <?php
    if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {?>

       <a href="logout.php"> <button type="button" name="logout">Logout</button></a>

   <?php }?>

    <?php
    // Include the PostManager class
    require_once '../classes/Post.php';

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

    // Pagination
    $perPage = 3; // Number of posts per page
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $perPage;

    // Retrieve all posts from the database
    $posts = $post->getAllPosts($currentPage,$perPage);

    if (!empty($posts)) {
        foreach ($posts as $postDetail) { ?>
            <h2><?php echo $postDetail['title']; ?></h2>
            <p><?php echo $postDetail['body']; ?></p>
            <a href="viewPost.php?id=<?php echo $postDetail['id']?>"><button type="button" name="view_post">view post</button></a>
            <a href="deletePost.php?id=<?php echo $postDetail['id']?>"><button type="button" name="delete_post">delete post</button></a>
            <hr>
       <?php }
    } else {
        echo '<p>No posts found.</p>';
    }

    // Determine the total number of posts
    $totalPosts = $post->getTotalPostsCount();

    // Calculate the total number of pages
    $totalPages = ceil($totalPosts / $perPage);

    echo '<h2>Pagination</h2>';
    // Display pagination links
    for ($i = 1; $i <= $totalPages; $i++) {
        $isActive = $i == $currentPage ? 'active' : '';
        echo '<a href="?page=' . $i . '" class="' . $isActive . '">' . $i . '</a>';
    }
    ?>

</body>
</html>