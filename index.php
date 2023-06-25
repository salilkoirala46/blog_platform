
<?php 

include 'includes/header.php';

    if (isset($_GET['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_GET['message']; ?>
        </div>
        <div></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_GET['error']; ?>
        </div>
    <?php endif; ?>

    
    <!-- make a db connection -->
    <?php
    require_once 'classes/Post.php';

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

    if (!empty($posts)) { ?>

        <h1>Blog Post Listing</h1>
        <div class="list-group">
        <?php foreach ($posts as $postDetail) { ?>
            <a href="viewPost.php?id=<?php echo $postDetail['id']; ?>" class="list-group-item list-group-item-action">
            <h5 class="mb-1"><?php echo $postDetail['title']; ?></h5>
            <p class="mb-1"><?php echo $postDetail['body']; ?></p>
            </a>
        <?php } ?>
        </div>

    <?php 
    } else {
        echo '<p>No posts found.</p>';
    }

    // Determine the total number of posts
    $totalPosts = $post->getTotalPostsCount();

    // Calculate the total number of pages
    $totalPages = ceil($totalPosts / $perPage);

     ?>
     <!-- Display pagination links -->
    <nav aria-label="Page navigation example">
            <ul class="pagination">
                
                <?php 
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage-1) . '">Previous</a></li>'; 
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a> </li>';
                    }
                
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage+1). '">Next</a></li>';
                ?>
            </ul>
        </nav>
    
<?php

include 'includes/footer.php';

?>